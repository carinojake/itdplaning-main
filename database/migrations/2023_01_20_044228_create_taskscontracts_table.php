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
        Schema::create('taskscon', function (Blueprint $table) {
            $table->integer('taskcon_id', true);
            $table->integer('contract_id');
            $table->string('taskcon_name');
            $table->text('taskcon_description')->nullable();
            $table->timestamp('taskcon_start_date')->nullable();;
            $table->timestamp('taskcon_end_date')->nullable();;
            $table->decimal('taskcon_budget_gov_operating', 11, 2)->nullable();
            $table->decimal('taskcon_budget_gov_investment', 11, 2)->nullable();
            $table->decimal('taskcon_budget_gov_utility', 11, 2)->nullable();
            $table->decimal('taskcon_budget_it_operating', 11, 2)->nullable();
            $table->decimal('taskcon_budget_it_investment', 11, 2)->nullable();
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
        Schema::dropIfExists('taskscon');
    }
};
