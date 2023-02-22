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
        Schema::create('taskcons', function (Blueprint $table) {
            $table->integer('taskcon_id', true);
            $table->integer('contract_id');
            $table->string('taskcon_name');
            $table->text('taskcon_description')->nullable();
            $table->text('taskcon_parent')->nullable();
            $table->timestamp('taskcon_start_date')->nullable();;
            $table->timestamp('taskcon_end_date')->nullable();;
            $table->decimal('taskcon_budget_gov_operating', 11, 2)->nullable();
            $table->decimal('taskcon_budget_gov_investment', 11, 2)->nullable();
            $table->decimal('taskcon_budget_gov_utility', 11, 2)->nullable();
            $table->decimal('taskcon_budget_it_operating', 11, 2)->nullable();
            $table->decimal('taskcon_budget_it_investment', 11, 2)->nullable();
            $table->timestamps();
            $table->decimal('taskcon_cost_gov_operating', 11, 2)->nullable();
            $table->decimal('taskcon_cost_gov_investment', 11, 2)->nullable();
            $table->decimal('taskcon_cost_gov_utility', 11, 2)->nullable();
            $table->decimal('taskcon_cost_it_operating', 11, 2)->nullable();
            $table->decimal('taskcon_cost_it_investment', 11, 2)->nullable();
            $table->text('taskcon_status')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taskcons', function (Blueprint $table) {
            $table->dropColumn('taskcon_id', true);
            $table->dropColumn('contract_id');
            $table->dropColumn('taskcon_name');
            $table->texdropColumnt('taskcon_description')->nullable();
            $table->dropColumntext('taskcon_parent')->nullable();
            $table->dropColumn('taskcon_start_date')->nullable();;
            $table->dropColumn('taskcon_end_date')->nullable();;
            $table->dropColumn('taskcon_budget_gov_operating', 11, 2)->nullable();
            $table->dropColumn('taskcon_budget_gov_investment', 11, 2)->nullable();
            $table->dropColumn('taskcon_budget_gov_utility', 11, 2)->nullable();
            $table->dropColumn('taskcon_budget_it_operating', 11, 2)->nullable();
            $table->decidropColumnmal('taskcon_budget_it_investment', 11, 2)->nullable();

            $table->dropColumn('taskcon_cost_gov_operating', 11, 2)->nullable();
            $table->dropColumn('taskcon_cost_gov_investment', 11, 2)->nullable();
            $table->dropColumn('taskcon_cost_gov_utility', 11, 2)->nullable();
            $table->dropColumn('taskcon_cost_it_operating', 11, 2)->nullable();
            $table->dropColumn('taskcon_cost_it_investment', 11, 2)->nullable();
            $table->dropColumn('taskcon_status')->nullable();

        });
    }
};
