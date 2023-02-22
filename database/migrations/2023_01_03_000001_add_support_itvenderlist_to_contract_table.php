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
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('contract_juristic_id')->nullable();
            $table->string('contract_order_no')->nullable();
            $table->string('contract_acquisition')->nullable();
            $table->timestamp('contract_sign_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('contract_juristic_id');
            $table->dropColumn('contract_order_no');
            $table->dropColumn('contract_acquisition');
            $table->dropColumn('contract_sign_date');
        });
    }
};
