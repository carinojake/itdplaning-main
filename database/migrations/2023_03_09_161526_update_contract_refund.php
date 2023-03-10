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
            $table->decimal('contract_refund_gov_operating', 11, 2)->nullable();
            $table->decimal('contract_refund_gov_investment', 11, 2)->nullable();
            $table->decimal('contract_refund_gov_utility', 11, 2)->nullable();
            $table->decimal('contract_refund_it_operating', 11, 2)->nullable();
            $table->decimal('contract_refund_it_investment', 11, 2)->nullable();  //
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
            $table->dropColumn('contract_refund_gov_operating');
            $table->dropColumn('contract_refund_gov_investment');
            $table->dropColumn('contract_refund_gov_utility');
            $table->dropColumn('contract_refund_it_operating');
            $table->dropColumn('contract_refund_it_investment');  //
        });
    }
};
