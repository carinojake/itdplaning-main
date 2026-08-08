<?php

namespace Tests\Feature;

use App\Http\Middleware\GetMenu;
use App\Models\Contract;
use App\Models\Taskcon;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ContractAuthorizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([GetMenu::class, RoleMiddleware::class]);
        View::share('appLocale', 'en');
        View::share('appMenus', []);
        View::share('locales', collect());
        $this->createTables();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('increasedbudgets');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('taskcons');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_user_cannot_open_another_users_contract_edit_page(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $attacker = $this->createUser('attacker@example.test', 'user');
        $contract = $this->createContract($owner);

        $this->actingAs($attacker)
            ->get(route('contract.edit', $contract->hashid))
            ->assertForbidden();
    }

    public function test_user_cannot_open_another_users_expense_contract_edit_page(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $attacker = $this->createUser('attacker@example.test', 'user');
        $contract = $this->createContract($owner);

        $this->actingAs($attacker)
            ->get(route('expenses.edit', $contract->hashid))
            ->assertForbidden();
    }

    public function test_owner_can_open_their_contract_edit_page(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $contract = $this->createContract($owner);

        $this->actingAs($owner)
            ->get(route('contract.edit', $contract->hashid))
            ->assertOk();
    }

    public function test_admin_can_open_another_users_contract_edit_page(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $admin = $this->createUser('admin@example.test', 'admin');
        $contract = $this->createContract($owner);

        $this->actingAs($admin)
            ->get(route('contract.edit', $contract->hashid))
            ->assertOk();
    }

    public function test_contract_queries_are_scoped_to_owner_but_admin_sees_all(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $otherUser = $this->createUser('other@example.test', 'user');
        $admin = $this->createUser('admin@example.test', 'admin');
        $ownersContract = $this->createContract($owner, 'CN-001');
        $othersContract = $this->createContract($otherUser, 'CN-002');

        $this->actingAs($owner);
        $this->assertSame([$ownersContract->getKey()], Contract::pluck('contract_id')->all());

        $this->actingAs($admin);
        $this->assertEqualsCanonicalizing(
            [$ownersContract->getKey(), $othersContract->getKey()],
            Contract::pluck('contract_id')->all()
        );
    }

    public function test_new_contract_is_automatically_owned_by_authenticated_creator(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $this->actingAs($owner);

        $contract = new Contract([
            'contract_name' => 'New protected contract',
            'contract_number' => 'CN-NEW',
            'contract_status' => '1',
            'contract_start_date' => now()->subDay(),
            'contract_end_date' => now()->addDay(),
        ]);
        $contract->contract_fiscal_year = 2569;
        $contract->save();

        $this->assertSame($owner->getKey(), $contract->owner_user_id);
    }

    public function test_nested_taskcon_must_belong_to_contract_in_route(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $routeContract = $this->createContract($owner, 'CN-001');
        $otherContract = $this->createContract($owner, 'CN-002');
        $taskcon = Taskcon::create([
            'contract_id' => $otherContract->getKey(),
            'taskcon_name' => 'Task from another contract',
        ]);

        $this->actingAs($owner)
            ->get(route('contract.task.edit', [
                'contract' => $routeContract->hashid,
                'taskcon' => $taskcon->hashid,
            ]))
            ->assertNotFound();
    }

    public function test_expense_nested_taskcon_must_belong_to_contract_in_route(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $routeContract = $this->createContract($owner, 'CN-001');
        $otherContract = $this->createContract($owner, 'CN-002');
        $taskcon = Taskcon::create([
            'contract_id' => $otherContract->getKey(),
            'taskcon_name' => 'Task from another contract',
        ]);

        $this->actingAs($owner)
            ->get(route('expenses.task.edit', [
                'contract' => $routeContract->hashid,
                'taskcon' => $taskcon->hashid,
            ]))
            ->assertNotFound();
    }

    public function test_updatepay_rejects_task_ids_from_another_contract_without_mutation(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $routeContract = $this->createContract($owner, 'CN-001');
        $otherContract = $this->createContract($owner, 'CN-002');
        $otherTaskcon = Taskcon::create([
            'contract_id' => $otherContract->getKey(),
            'taskcon_name' => 'Other task',
            'taskcon_pay' => 100,
        ]);

        $this->actingAs($owner)
            ->put(route('contract.updatepay', $routeContract->hashid), [
                'tasks' => [[
                    'id' => $otherTaskcon->getKey(),
                    'task_name' => 'Tampered task',
                    'taskcon_pay' => '999',
                ]],
            ])
            ->assertNotFound();

        $this->assertDatabaseHas('taskcons', [
            'taskcon_id' => $otherTaskcon->getKey(),
            'taskcon_name' => 'Other task',
            'taskcon_pay' => 100,
        ]);
    }

    public function test_updatepay_allows_owner_to_update_task_in_their_contract(): void
    {
        $owner = $this->createUser('owner@example.test', 'user');
        $contract = $this->createContract($owner);
        $taskcon = Taskcon::create([
            'contract_id' => $contract->getKey(),
            'taskcon_name' => 'Owned task',
            'taskcon_pay' => 100,
        ]);

        $this->actingAs($owner)
            ->from(route('contract.editpay', $contract->hashid))
            ->put(route('contract.updatepay', $contract->hashid), [
                'tasks' => [[
                    'id' => $taskcon->getKey(),
                    'task_name' => 'Updated task',
                    'taskcon_pay' => '250',
                ]],
            ])
            ->assertRedirect(route('contract.editpay', $contract->hashid));

        $this->assertDatabaseHas('taskcons', [
            'taskcon_id' => $taskcon->getKey(),
            'taskcon_name' => 'Updated task',
            'taskcon_pay' => 250,
        ]);
    }

    public function test_migration_assigns_legacy_contracts_to_first_admin(): void
    {
        $admin = $this->createUser('admin@example.test', 'admin');
        Schema::table('contracts', function (Blueprint $table): void {
            $table->dropColumn('owner_user_id');
        });
        $contractId = DB::table('contracts')->insertGetId([
            'contract_name' => 'Legacy contract',
            'contract_number' => 'CN-LEGACY',
            'contract_fiscal_year' => 2568,
            'created_at' => now(),
            'updated_at' => now(),
        ], 'contract_id');

        $migration = require database_path('migrations/2026_08_08_000001_add_owner_user_id_to_contracts_table.php');
        $migration->up();

        $this->assertTrue(Schema::hasColumn('contracts', 'owner_user_id'));
        $this->assertDatabaseHas('contracts', [
            'contract_id' => $contractId,
            'owner_user_id' => $admin->getKey(),
        ]);
    }

    private function createUser(string $email, string $role): User
    {
        $user = User::create([
            'name' => $email,
            'email' => $email,
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($role);

        return $user;
    }

    private function createContract(User $owner, string $number = 'CN-001'): Contract
    {
        $contractId = DB::table('contracts')->insertGetId([
            'contract_name' => 'Protected contract',
            'contract_number' => $number,
            'contract_fiscal_year' => 2569,
            'contract_status' => '1',
            'contract_start_date' => now()->subDay(),
            'contract_end_date' => now()->addDay(),
            'owner_user_id' => $owner->id,
            'created_at' => now(),
            'updated_at' => now(),
        ], 'contract_id');

        return Contract::findOrFail($contractId);
    }

    private function createTables(): void
    {
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('increasedbudgets');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('taskcons');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('role_has_permissions', function (Blueprint $table): void {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->primary(['permission_id', 'role_id']);
        });

        Schema::create('model_has_roles', function (Blueprint $table): void {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        Schema::create('contracts', function (Blueprint $table): void {
            $table->increments('contract_id');
            $table->string('contract_name');
            $table->string('contract_number');
            $table->integer('contract_fiscal_year');
            $table->string('contract_status')->nullable();
            $table->timestamp('contract_start_date')->nullable();
            $table->timestamp('contract_end_date')->nullable();
            $table->unsignedBigInteger('owner_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('taskcons', function (Blueprint $table): void {
            $table->increments('taskcon_id');
            $table->unsignedBigInteger('contract_id');
            $table->string('taskcon_name')->nullable();
            $table->decimal('taskcon_pay', 11, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('projects', function (Blueprint $table): void {
            $table->increments('project_id');
        });

        Schema::create('increasedbudgets', function (Blueprint $table): void {
            $table->increments('increased_budget_id');
            $table->unsignedBigInteger('project_id');
            $table->integer('increased_budget_status')->nullable();
            $table->decimal('increased_budget_it_operating', 11, 2)->nullable();
            $table->decimal('increased_budget_it_investment', 11, 2)->nullable();
            $table->decimal('increased_budget_gov_utility', 11, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
