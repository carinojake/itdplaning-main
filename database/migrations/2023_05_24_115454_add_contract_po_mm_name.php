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
            $table->string('contract_er_name')->nullable()->default('');
            $table->string('contract_cn_name')->nullable()->default('');
            $table->string('contract_mm_name')->nullable()->default('');
            $table->string('contract_oe_name')->nullable()->default('');
            $table->decimal('contract_oe_budget', 11, 2)->nullable()->default(0.0);

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
            $table->dropColumn('contract_er_name');
            $table->dropColumn('contract_cn_name');
            $table->dropColumn('contract_mm_name');
            $table->dropColumn('contract_oe_name');
            $table->dropColumn('contract_oe_budget');
        });
    }
};
