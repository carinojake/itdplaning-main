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

            $table->string('contract_projectplan')->nullable();
            $table->string('contract_mm')->nullable();
            $table->string('contract_pr')->nullable();
            $table->string('contract_pa')->nullable();
            $table->decimal('contract_pr_budget')->nullable();
            $table->decimal('contract_pa_budget')->nullable();
        }); //  //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {

            $table->string('contract_projectplan')->nullable();
            $table->string('contract_mm')->nullable();
            $table->string('contract_pr')->nullable();
            $table->string('contract_pa')->nullable();
            $table->decimal('contract_pr_budget')->nullable();
            $table->decimal('contract_pa_budget')->nullable();
        });    //
    }
};
