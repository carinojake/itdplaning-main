<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderColumnToProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('order_column')->nullable(); // คุณสามารถเปลี่ยนชื่อคอลัมน์เป็นชื่อที่คุณต้องการ
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('order_column'); // คุณสามารถเปลี่ยนชื่อคอลัมน์เป็นชื่อที่คุณต้องการ
        });
    }
}
