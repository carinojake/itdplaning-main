<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->integer('project_id', true);
            $table->string('project_name')->nullable();
            $table->text('project_description')->nullable();
            $table->string('project_type')->nullable();
            $table->timestamp('project_start_date')->nullable();
            $table->timestamp('project_end_date')->nullable();
            $table->decimal('budget_gov_operating', 11, 2)->nullable();
            $table->decimal('budget_gov_investment', 11, 2)->nullable();
            $table->decimal('budget_gov_utility', 11, 2)->nullable();
            $table->decimal('budget_it_operating', 11, 2)->nullable();
            $table->decimal('budget_it_investment', 11, 2)->nullable();
            $table->decimal('project_cost', 11, 2)->nullable();
            $table->string('project_owner')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('projects');
    }
}
