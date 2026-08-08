<?php

namespace Tests\Feature;

use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

class ContractValidationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        Schema::dropIfExists('contracts');
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('contract_id');
            $table->string('contract_name');
            $table->string('contract_number', 50);
            $table->integer('contract_fiscal_year');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('contracts');

        parent::tearDown();
    }

    public function test_store_rejects_duplicate_contract_number_in_same_fiscal_year(): void
    {
        $this->insertContract('CN-001', 2569);

        $response = $this
            ->from('/contract/create')
            ->post('/contract', $this->validPayload([
                'contract_number' => ' CN-001 ',
            ]));

        $response
            ->assertRedirect('/contract/create')
            ->assertSessionHasErrors('contract_number');

        $this->assertDatabaseCount('contracts', 1);
    }

    public function test_store_allows_same_contract_number_in_different_fiscal_year(): void
    {
        $this->insertContract('CN-001', 2568);

        $request = StoreContractRequest::create('/contract', 'POST', $this->validPayload([
            'contract_number' => 'CN-001',
            'contract_fiscal_year' => 2569,
        ]));

        $this->resolveRequest($request);

        $this->assertSame('CN-001', $request->input('contract_number'));
    }

    public function test_store_allows_number_from_soft_deleted_contract(): void
    {
        $this->insertContract('CN-001', 2569, now());

        $request = StoreContractRequest::create('/contract', 'POST', $this->validPayload());

        $this->resolveRequest($request);

        $this->assertSame('CN-001', $request->input('contract_number'));
    }

    public function test_update_ignores_the_current_contract_number(): void
    {
        $contractId = $this->insertContract('CN-001', 2569);
        $hashid = Hashids::encode($contractId);
        $request = UpdateContractRequest::create('/contract/'.$hashid, 'PUT', $this->validPayload());
        $request->setRouteResolver(fn () => new class($hashid)
        {
            public function __construct(private string $contract)
            {
            }

            public function parameter(string $key, $default = null)
            {
                return $key === 'contract' ? $this->contract : $default;
            }
        });

        $this->resolveRequest($request);

        $this->assertSame('CN-001', $request->input('contract_number'));
    }

    public function test_update_rejects_another_contract_number_in_same_fiscal_year(): void
    {
        $this->insertContract('CN-001', 2569);
        $contractId = $this->insertContract('CN-002', 2569);

        $response = $this
            ->from('/contract/'.$contractId.'/edit')
            ->put('/contract/'.Hashids::encode($contractId), $this->validPayload([
                'contract_number' => 'CN-001',
            ]));

        $response
            ->assertRedirect('/contract/'.$contractId.'/edit')
            ->assertSessionHasErrors('contract_number');
    }

    public function test_update_applies_date_and_budget_validation(): void
    {
        $contractId = $this->insertContract('CN-002', 2569);

        $response = $this
            ->from('/contract/'.$contractId.'/edit')
            ->put('/contract/'.Hashids::encode($contractId), $this->validPayload([
                'contract_number' => 'CN-002',
                'contract_start_date' => '02/10/2568',
                'contract_end_date' => '01/10/2568',
                'contract_pr_budget' => '-0.01',
            ]));

        $response
            ->assertRedirect('/contract/'.$contractId.'/edit')
            ->assertSessionHasErrors([
                'contract_end_date',
                'contract_pr_budget',
            ]);
    }

    public function test_store_rejects_end_date_before_start_date(): void
    {
        $response = $this
            ->from('/contract/create')
            ->post('/contract', $this->validPayload([
                'contract_start_date' => '02/10/2568',
                'contract_end_date' => '01/10/2568',
            ]));

        $response
            ->assertRedirect('/contract/create')
            ->assertSessionHasErrors('contract_end_date');
    }

    public function test_store_rejects_invalid_date_format(): void
    {
        $response = $this
            ->from('/contract/create')
            ->post('/contract', $this->validPayload([
                'contract_start_date' => '2568-10-01',
            ]));

        $response
            ->assertRedirect('/contract/create')
            ->assertSessionHasErrors('contract_start_date');
    }

    /**
     * @dataProvider budgetFields
     */
    public function test_store_rejects_negative_budget(string $field): void
    {
        $response = $this
            ->from('/contract/create')
            ->post('/contract', $this->validPayload([$field => '-0.01']));

        $response
            ->assertRedirect('/contract/create')
            ->assertSessionHasErrors($field);
    }

    public function test_budget_values_with_thousands_separators_are_normalized(): void
    {
        $request = StoreContractRequest::create('/contract', 'POST', $this->validPayload([
            'contract_mm_budget' => '1,500,000.00',
            'contract_pr_budget' => ' 1,250,000.50 ',
        ]));

        $this->resolveRequest($request);

        $this->assertSame('1500000.00', $request->input('contract_mm_budget'));
        $this->assertSame('1250000.50', $request->input('contract_pr_budget'));
    }

    public function test_duplicate_check_endpoint_returns_the_real_existence_state(): void
    {
        $this->insertContract('CN-001', 2569);

        $this->getJson('/contract/check-contract?contract_fiscal_year=2569&contract_number=CN-001')
            ->assertOk()
            ->assertJson([
                'exists_contract_number' => true,
                'error' => 'เลขที่สัญญามีอยู่แล้ว',
            ]);

        $this->getJson('/contract/check-contract?contract_fiscal_year=2569&contract_number=CN-999')
            ->assertOk()
            ->assertExactJson([
                'exists_contract_number' => false,
            ]);
    }

    /**
     * @return array<string, array{string}>
     */
    public function budgetFields(): array
    {
        return [
            'MM budget' => ['contract_mm_budget'],
            'PR budget' => ['contract_pr_budget'],
            'PA budget' => ['contract_pa_budget'],
            'PO budget' => ['contract_po_budget'],
            'ER budget' => ['contract_er_budget'],
            'CN budget' => ['contract_cn_budget'],
            'OE budget' => ['contract_oe_budget'],
            'BA budget' => ['contract_ba_budget'],
            'BD budget' => ['contract_bd_budget'],
            'refund PA budget' => ['contract_refund_pa_budget'],
            'yearly PA budget' => ['contract_peryear_pa_budget'],
            'contract payment' => ['contract_pay'],
        ];
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'contract_name' => 'สัญญาทดสอบ',
            'contract_number' => 'CN-001',
            'contract_fiscal_year' => 2569,
            'contract_start_date' => '01/10/2568',
            'contract_end_date' => '30/09/2569',
            'contract_mm_budget' => '1,000,000.00',
            'contract_pr_budget' => '900000',
            'contract_pa_budget' => '800000',
            'contract_po_budget' => '0',
            'contract_er_budget' => '0',
            'contract_cn_budget' => '0',
            'contract_oe_budget' => '0',
            'contract_ba_budget' => '0',
            'contract_bd_budget' => '0',
            'contract_refund_pa_budget' => '0',
            'contract_peryear_pa_budget' => '0',
            'contract_pay' => '0',
        ], $overrides);
    }

    private function insertContract(string $number, int $fiscalYear, $deletedAt = null): int
    {
        return DB::table('contracts')->insertGetId([
            'contract_name' => 'Existing contract',
            'contract_number' => $number,
            'contract_fiscal_year' => $fiscalYear,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => $deletedAt,
        ], 'contract_id');
    }

    private function resolveRequest(FormRequest $request): void
    {
        $request->setContainer($this->app);
        $request->setRedirector($this->app->make(Redirector::class));
        $request->validateResolved();
    }
}
