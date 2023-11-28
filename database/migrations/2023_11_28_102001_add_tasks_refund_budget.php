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
            $table->integer('task_refund_budget_type')->nullable();// 1: คืนเงินงบประมาณ 2: คืนเงินงบประมาณและเปลี่ยนแปลงงบประมาณ
            $table->decimal('task_refund_budget', 11, 2)->nullable();
            $table->decimal('task_refund_budget_left', 11, 2)->nullable();
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
