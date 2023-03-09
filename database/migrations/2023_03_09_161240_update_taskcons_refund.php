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
            $table->decimal('taskcon_refund_gov_operating', 11, 2)->nullable();
            $table->decimal('taskcon_refund_gov_investment', 11, 2)->nullable();
            $table->decimal('taskcon_refund_gov_utility', 11, 2)->nullable();
            $table->decimal('taskcon_refund_it_operating', 11, 2)->nullable();
            $table->decimal('taskcon_refund_it_investment', 11, 2)->nullable();  //
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
            $table->dropColumn('taskcon_refund_gov_operating');
            $table->dropColumn('taskcon_refund_gov_investment');
            $table->dropColumn('taskcon_refund_gov_utility');
            $table->dropColumn('taskcon_refund_it_operating');
            $table->dropColumn('taskcon_refund_it_investment'); //
        });
    }
};
