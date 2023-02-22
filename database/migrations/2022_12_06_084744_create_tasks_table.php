<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->integer('task_id', true);
            $table->integer('project_id');
            $table->string('task_name');
            $table->text('task_description')->nullable();
            $table->timestamp('task_start_date');
            $table->timestamp('task_end_date');
            $table->decimal('task_budget_gov_operating', 11, 2)->nullable();
            $table->decimal('task_budget_gov_investment', 11, 2)->nullable();
            $table->decimal('task_budget_gov_utility', 11, 2)->nullable();
            $table->decimal('task_budget_it_operating', 11, 2)->nullable();
            $table->decimal('task_budget_it_investment', 11, 2)->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
