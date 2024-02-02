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
    { // task_id,used_project_id, used_refer_task_id, used_refer_amount
        Schema::create('refer_budget', function (Blueprint $table) {
            $table->integer('refer_id');
            $table->integer('task_id')->nullable();
            $table->integer('used_project_id')->nullable();
            $table->decimal('used_refer_task_id', 11, 2)->nullable();
            $table->decimal('used_refer_amount', 11, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('refer_budget');

    }
};
