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
            $table->string('contract_oe')->nullable()->default('');
            $table->timestamp('contract_oe_start_date')->nullable();;
            $table->timestamp('contract_oe_end_date')->nullable();;
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
        Schema::table('contracts', function (Blueprint $table) {
            //
            $table->dropColumn('contract_oe');
            $table->dropColumn('contract_oe_start_date');
            $table->dropColumn('contract_oe_end_date');
        });
    }
};
