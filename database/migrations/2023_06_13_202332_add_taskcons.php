<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('contract_id')->nullable();
            $table->string('taskcon_name')->nullable();
            $table->text('taskcon_description')->nullable();
            $table->text('taskcon_parent')->nullable();
            $table->timestamp('taskcon_start_date')->nullable();
            $table->timestamp('taskcon_end_date')->nullable();
            $table->decimal('taskcon_budget_gov_operating', 11, 2)->nullable();
            $table->decimal('taskcon_budget_gov_investment', 11, 2)->nullable();
            $table->decimal('taskcon_budget_gov_utility', 11, 2)->nullable();
            $table->decimal('taskcon_budget_it_operating', 11, 2)->nullable();
            $table->decimal('taskcon_budget_it_investment', 11, 2)->nullable();
            $table->decimal('taskcon_cost_gov_operating', 11, 2)->nullable();
            $table->decimal('taskcon_cost_gov_investment', 11, 2)->nullable();
            $table->decimal('taskcon_cost_gov_utility', 11, 2)->nullable();
            $table->decimal('taskcon_cost_it_operating', 11, 2)->nullable();
            $table->decimal('taskcon_cost_it_investment', 11, 2)->nullable();
            $table->text('taskcon_status')->nullable();
            $table->string('taskcon_projectplan')->nullable();
            $table->string('taskcon_mm')->nullable();
            $table->string('taskcon_pr')->nullable();
            $table->string('taskcon_pa')->nullable();
            $table->decimal('taskcon_pr_budget', 11, 2)->nullable();
            $table->decimal('taskcon_pa_budget', 11, 2)->nullable();
            $table->string('disbursement_taskcons_status')->nullable();
            $table->timestamp('disbursement_taskcons_date')->nullable();
            $table->decimal('taskcon_refund_gov_operating', 11, 2)->nullable();
            $table->decimal('taskcon_refund_gov_investment', 11, 2)->nullable();
            $table->decimal('taskcon_refund_gov_utility', 11, 2)->nullable();
            $table->decimal('taskcon_refund_it_operating', 11, 2)->nullable();
            $table->decimal('taskcon_refund_it_investment', 11, 2)->nullable();
            $table->timestamp('taskcon_pay_date')->nullable();
            $table->decimal('taskcon_pay', 11, 2)->nullable();
            $table->string('taskcon_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('contract_id');
            $table->dropColumn('taskcon_name');
            $table->dropColumn('taskcon_description');
            $table->dropColumn('taskcon_parent');
            $table->dropColumn('taskcon_start_date');
            $table->dropColumn('taskcon_end_date');
            $table->dropColumn('taskcon_budget_gov_operating');
            $table->dropColumn('taskcon_budget_gov_investment');
            $table->dropColumn('taskcon_budget_gov_utility');
            $table->dropColumn('taskcon_budget_it_operating');
            $table->dropColumn('taskcon_budget_it_investment');
            $table->dropColumn('taskcon_cost_gov_operating');
            $table->dropColumn('taskcon_cost_gov_investment');
            $table->dropColumn('taskcon_cost_gov_utility');
            $table->dropColumn('taskcon_cost_it_operating');
            $table->dropColumn('taskcon_cost_it_investment');
            $table->dropColumn('taskcon_status');
            $table->dropColumn('taskcon_projectplan');
            $table->dropColumn('taskcon_mm');
            $table->dropColumn('taskcon_pr');
            $table->dropColumn('taskcon_pa');
            $table->dropColumn('taskcon_pr_budget');
            $table->dropColumn('taskcon_pa_budget');
            $table->dropColumn('disbursement_taskcons_status');
            $table->dropColumn('disbursement_taskcons_date');
            $table->dropColumn('taskcon_refund_gov_operating');
            $table->dropColumn('taskcon_refund_gov_investment');
            $table->dropColumn('taskcon_refund_gov_utility');
            $table->dropColumn('taskcon_refund_it_operating');
            $table->dropColumn('taskcon_refund_it_investment');
            $table->dropColumn('taskcon_pay_date');
            $table->dropColumn('taskcon_pay');
            $table->dropColumn('taskcon_type');

        });
    }
};
