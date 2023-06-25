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
            //
            $table->decimal('task_ba_budget', 11, 2)->nullable();
            $table->decimal('task_bd_budget', 11, 2)->nullable();
            $table->decimal('task_cost_disbursement', 11, 2)->nullable();

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
            //
            $table->dropColumn('task_ba_budget');
            $table->dropColumn('task_bd_budget');
            $table->dropColumn('task_cost_disbursement');
        });
    }
};
