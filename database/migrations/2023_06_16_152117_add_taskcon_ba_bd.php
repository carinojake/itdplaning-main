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
            //
            $table->decimal('taskcon_ba_budget', 11, 2)->nullable();
            $table->decimal('taskcon_bd_budget', 11, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taskcons', function (Blueprint $table) {
            //
            $table->dropColumn('taskcon_ba_budget');
            $table->dropColumn('taskcon_bd_budget');
        });
    }
};
