<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractHasTaskconTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('contract_has_taskscon', function (Blueprint $table) {
            $table->unsignedBigInteger('taskcon_id');
            $table->unsignedBigInteger('task_id');
            $table->index('taskcon_id', 'contract_has_taskscon');

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
        Schema::dropIfExists('contract_has_taskcons');
        //
    }
};
