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
            $table->string('pr_file')->nullable();
            $table->string('pa_file')->nullable();
            $table->string('cn_file')->nullable();
            $table->string('mm_file')->nullable();
            $table->string('etc_file')->nullable();
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
            $table->dropColumn('pr_file');
            $table->dropColumn('pa_file');
            $table->dropColumn('cn_file');
            $table->dropColumn('mm_file');
            $table->dropColumn('etc_file');

        });
    }
};
