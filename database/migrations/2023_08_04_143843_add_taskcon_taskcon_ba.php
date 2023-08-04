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
            $table->string('taskcon_ba')->nullable();
            $table->string('taskcon_bd')->nullable();
            $table->timestamp('taskcon_ba_start_date')->nullable();
            $table->timestamp('taskcon_ba_end_date')->nullable();
            $table->timestamp('taskcon_bd_start_date')->nullable();
            $table->timestamp('taskcon_bd_end_date')->nullable();
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
            $table->dropColumn('taskcon_ba');
            $table->dropColumn('taskcon_bd');
            $table->dropColumn('taskcon_ba_start_date');
            $table->dropColumn('taskcon_ba_end_date');
            $table->dropColumn('taskcon_bd_start_date');
            $table->dropColumn('taskcon_bd_end_date');
        });
    }
};
