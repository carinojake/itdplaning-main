<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->integer('contract_id', true);
            $table->string('contract_name');
            $table->string('contract_number', 50);
            $table->string('contract_year', 10)->nullable();
            $table->text('contract_description')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('contract_status')->nullable();
            $table->timestamp('contract_start_date')->nullable();
            $table->timestamp('contract_end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contract_has_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('task_id');
            $table->index('contract_id', 'contract_has_tasks_index');

            // $table->foreign('contract_id')
            //     ->references('task_id')
            //     ->on('tasks')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('contract_has_tasks');
    }
}
