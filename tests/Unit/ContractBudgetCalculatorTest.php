<?php

namespace Tests\Unit;

use App\Services\ContractBudgetCalculator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ContractBudgetCalculatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('contracts');
        Schema::create('contracts', function (Blueprint $table): void {
            $table->increments('contract_id');
            $table->string('contract_name');
            $table->string('contract_number');
            $table->integer('contract_fiscal_year');
            $table->string('contract_status')->nullable();
            $table->decimal('contract_pr_budget', 11, 2)->nullable();
            $table->decimal('contract_pa_budget', 11, 2)->nullable();
            $table->decimal('contract_peryear_pa_budget', 11, 2)->nullable();
            $table->decimal('contract_refund_pa_budget', 11, 2)->nullable();
            $table->integer('contract_refund_pa_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('contracts');

        parent::tearDown();
    }

    public function test_totals_are_scoped_to_fiscal_year_and_counted_statuses(): void
    {
        $this->insertContract(2569, 'approved', 100, 80, 10, 5, 1);
        $this->insertContract(2569, '1', 200, 150, 20, 7, 1);
        $this->insertContract(2569, '2', 50, 40, 3, 2, 1);
        $this->insertContract(2569, 'draft', 900, 800, 90, 90, 1);
        $this->insertContract(2569, ' CANCELED ', 700, 600, 70, 70, 1);
        $this->insertContract(2568, 'approved', 500, 400, 50, 50, 1);
        $this->insertContract(2569, 'approved', 1000, 900, 100, 100, 1, now());

        $summary = (new ContractBudgetCalculator())->forFiscalYear(2569);

        $this->assertSame(350.0, $summary['pr_total']);
        $this->assertSame(270.0, $summary['pa_total']);
        $this->assertSame(33.0, $summary['per_year_pa_total']);
        $this->assertSame(14.0, $summary['refund_pa_total']);
    }

    public function test_refund_total_only_counts_active_refund_records(): void
    {
        $this->insertContract(2569, null, 100, 80, 10, 25, 1);
        $this->insertContract(2569, null, 200, 150, 20, 30, 2);
        $this->insertContract(2569, 'cancelled', 300, 250, 30, 40, 1);

        $summary = (new ContractBudgetCalculator())->forFiscalYear(2569);

        $this->assertSame(300.0, $summary['pr_total']);
        $this->assertSame(230.0, $summary['pa_total']);
        $this->assertSame(25.0, $summary['refund_pa_total']);
    }

    private function insertContract(
        int $fiscalYear,
        ?string $status,
        float $pr,
        float $pa,
        float $perYearPa,
        float $refund,
        int $refundStatus,
        $deletedAt = null
    ): void {
        DB::table('contracts')->insert([
            'contract_name' => 'Test contract',
            'contract_number' => uniqid('CN-', true),
            'contract_fiscal_year' => $fiscalYear,
            'contract_status' => $status,
            'contract_pr_budget' => $pr,
            'contract_pa_budget' => $pa,
            'contract_peryear_pa_budget' => $perYearPa,
            'contract_refund_pa_budget' => $refund,
            'contract_refund_pa_status' => $refundStatus,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => $deletedAt,
        ]);
    }
}
