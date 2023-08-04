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

            $table->integer('taskcon_type')->nullable();

            $table->string('taskcon_po')->nullable();
            $table->string('taskcon_er')->nullable();
            $table->string('taskcon_cn')->nullable();

            $table->string('taskcon_er_name')->nullable();
            $table->string('taskcon_cn_name')->nullable();
            $table->string('taskcon_mm_name')->nullable();
            $table->string('taskcon_oe_name')->nullable();
            $table->integer('taskcon_fiscal_year')->nullable();

            $table->timestamp('insurance_start_date')->nullable();
            $table->timestamp('insurance_end_date')->nullable();
            $table->timestamp('taskcon_po_start_date')->nullable();
            $table->timestamp('taskcon_po_end_date')->nullable();
            $table->timestamp('taskcon_er_start_date')->nullable();
            $table->timestamp('taskcon_er_end_date')->nullable();
            $table->timestamp('disbursement_taskcons_status')->nullable();
            $table->timestamp('disbursement_taskcons_date')->nullable();

            $table->decimal('taskcon_mm_budget', 11, 2)->nullable();
            $table->decimal('taskcon_oe_budget', 11, 2)->nullable();
            $table->decimal('taskcon_po_budget', 11, 2)->nullable();
            $table->decimal('taskcon_er_budget', 11, 2)->nullable();
            $table->decimal('taskcon_cn_budget', 11, 2)->nullable();
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
            $table->dropColumn('taskcon_type');
            $table->dropColumn('taskcon_po');
            $table->dropColumn('taskcon_er');
            $table->dropColumn('taskcon_cn');
            $table->dropColumn('taskcon_er_name');
            $table->dropColumn('taskcon_cn_name');
            $table->dropColumn('taskcon_mm_name');
            $table->dropColumn('taskcon_oe_name');
            $table->dropColumn('taskcon_fiscal_year');
            $table->dropColumn('insurance_start_date');
            $table->dropColumn('insurance_end_date');
            $table->dropColumn('taskcon_po_start_date');
            $table->dropColumn('taskcon_po_end_date');
            $table->dropColumn('taskcon_er_start_date');
            $table->dropColumn('taskcon_er_end_date');
            $table->dropColumn('disbursement_taskcons_status');
            $table->dropColumn('disbursement_taskcons_date');
            $table->dropColumn('taskcon_mm_budget');
            $table->dropColumn('taskcon_oe_budget');
            $table->dropColumn('taskcon_po_budget');
            $table->dropColumn('taskcon_er_budget');
            $table->dropColumn('taskcon_cn_budget');
        });
    }
};
