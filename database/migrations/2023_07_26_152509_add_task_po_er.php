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
            $table->string('task_er_name')->nullable()->default('');
            $table->string('task_po_name')->nullable()->default('');
            $table->string('task_oe_name')->nullable()->default('');
            $table->decimal('task_er_budget', 11, 2)->nullable()->default(0.0);
            $table->decimal('task_po_budget', 11, 2)->nullable()->default(0.0);
            $table->decimal('task_oe_budget', 11, 2)->nullable()->default(0.0);
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
            $table->dropColumn('task_er_name');
            $table->dropColumn('task_po_name');
            $table->dropColumn('task_oe_name');
            $table->dropColumn('task_oe_budget');
            $table->dropColumn('task_er_budget');
            $table->dropColumn('task_po_budget');
        });
    }
};
