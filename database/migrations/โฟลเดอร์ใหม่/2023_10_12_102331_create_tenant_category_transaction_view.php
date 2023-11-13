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
        Schema::create('tenant_category_transaction_view', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('idParentCategory')->nullable();
            $table->integer('sumSubtotal')->nullable();
            $table->integer('sumQuantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_category_transaction_view');
    }
};
