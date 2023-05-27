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
            //
            $table->string('contract_ba')->nullable()->default('');
            $table->timestamp('contract_ba_start_date')->nullable();;
            $table->timestamp('contract_ba_end_date')->nullable();;
            $table->string('contract_bd')->nullable()->default('');
            $table->timestamp('contract_bd_start_date')->nullable();;
            $table->timestamp('contract_bd_end_date')->nullable();;
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
            $table->dropColumn('contract_ba');
            $table->dropColumn('contract_ba_start_date');
            $table->dropColumn('contract_ba_end_date');
            $table->dropColumn('contract_bd');
            $table->dropColumn('contract_bd_start_date');
            $table->dropColumn('contract_bd_end_date');


        });
    }
};
