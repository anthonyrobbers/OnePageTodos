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
        Schema::create('todo_items',function(blueprint $table){
            $table->increments('id');
            $table->string('task',90);
            $table->integer('priority');
            $table->boolean('complete');
            $table->string('group',90);
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
        //
        Schema::dropIfExists('TodoItem');
        Schema::dropIfExists('todo_items');
    }
}
