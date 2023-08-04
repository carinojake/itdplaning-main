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
            $table->timestamp('taskcon_pay_date')->nullable();
            $table->decimal('taskcon_pay', 11, 2)->nullable();
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
            $table->dropColumn('taskcon_pay_date');  //
            $table->dropColumn('taskcon_pay');  //
        });
    }
};
