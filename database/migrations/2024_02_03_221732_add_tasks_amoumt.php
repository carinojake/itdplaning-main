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
          //  $table->decimal('tasks_increased_amount', 11, 2)->nullable()->after('task_budget_no');
            $table->decimal('tasks_budget_amount', 11, 2)->nullable()->after('task_budget_no');
            $table->decimal('tasks_refund_amount',11,2)->nullable()->after('tasks_budget_amount');;//
            //
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
        });
    }
};
