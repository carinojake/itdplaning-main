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
            $table->integer('task_parent_sub_refund_pa_status')->nullable();
            $table->decimal('task_parent_sub_budget', 11, 2)->nullable();
            $table->decimal('task_parent_sub_cost', 11, 2)->nullable();
            $table->decimal('task_parent_sub_refund_budget', 11, 2)->nullable();

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
            $table->dropColumn('task_parent_sub_refund_pa_status');
            $table->dropColumn('task_parent_sub_budget');
            $table->dropColumn('task_parent_sub_cost');
            $table->dropColumn('task_parent_sub_refund_budget');
        });
    }
};
