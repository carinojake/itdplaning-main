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

            $table->decimal('contract_po_budget', 11, 2)->nullable();
            $table->decimal('contract_er_budget', 11, 2)->nullable();
            $table->decimal('contract_cn_budget', 11, 2)->nullable();
            $table->string('contract_po')->nullable();
            $table->string('contract_er')->nullable();
            $table->string('contract_cn')->nullable();
            $table->timestamp('insurance_start_date')->nullable();
            $table->timestamp('insurance_end_date')->nullable();

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
        });
    }
};
