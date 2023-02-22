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
        Schema::table('taskcons', function (Blueprint $table) {
            $table->integer('task_status')->nullable();
            $table->string('taskcon_projectplan')->nullable();
            $table->string('taskcon_mm')->nullable();
            $table->string('taskcon_pr')->nullable();
            $table->string('taskcon_pa')->nullable();
            $table->decimal('taskcon_pr_budget')->nullable();
            $table->decimal('taskcon_pa_budget')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taskcons', function (Blueprint $table) {
            $table->integer('task_status')->nullable();
            $table->string('taskcon_projectplan')->nullable();
            $table->string('taskcon_mm')->nullable();
            $table->string('taskcon_pr')->nullable();
            $table->string('taskcon_pa')->nullable();
            $table->decimal('taskcon_pr_budget')->nullable();
            $table->decimal('taskcon_pa_budget')->nullable();
        }); // //
    }
};
