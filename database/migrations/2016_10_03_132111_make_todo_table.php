<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('laravelToDos',function(blueprint $table){
            $table->increments('id')->primary();
            $table->string('task',90);
            $table->integer('priority');
            $table->boolean('complete');
            $table->string('group',90);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('laravelToDos');
    }
}
