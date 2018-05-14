<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('eazy_tasks')) {
            Schema::create('eazy_tasks', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('description');
                $table->dateTime('date');

                $table->integer('task_type_id')->unsigned();
                $table->foreign('task_type_id')->references('id')->on('eazy_task_type');

                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eazy_tasks');
    }
}
