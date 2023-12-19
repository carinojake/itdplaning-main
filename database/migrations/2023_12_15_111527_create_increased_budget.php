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
        Schema::create('increasedbudgets', function (Blueprint $table) {

            $table->integer('increased_budget_id');
            $table->integer('project_id')->nullable();
            $table->string('increased_budget_name')->nullable();
            $table->string('increased_budget_description')->nullable();
            $table->decimal('increased_budget_it_operating', 11, 2)->nullable();
            $table->decimal('increased_budget_it_investment', 11, 2)->nullable();
            $table->decimal('increased_budget_gov_utility', 11, 2)->nullable();
            $table->decimal('increased_budget_amount', 11, 2)->nullable();
            $table->date('increased_budget_date')->nullable();
            $table->integer('increased_budget_status')->nullable();
            $table->integer('increased_budget_created_by')->nullable();
            $table->integer('increased_budget_updated_by')->nullable();
            $table->integer('increased_budget_deleted_by')->nullable();
            $table->date('increased_budget_created_at')->nullable();
            $table->date('increased_budget_updated_at')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
            $table->primary('increased_budget_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('increased_budget');
    }
};
