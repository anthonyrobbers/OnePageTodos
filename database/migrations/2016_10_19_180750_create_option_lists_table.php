<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_lists', function (Blueprint $table) {
            $table->increments('id')->comment('1 is the default option set. others can be used for users or saving extra sets for later.');
            
            $table->string('group',90)->comment('the group to be used');
            $table->string('style',90)->comment('style sheet type to use default or mvc to start with');
            $table->integer('filter')->comment('matching complete is displayed 3 displays all');
            $table->boolean('verbosity')->comment('true or false this displays status');
            
            $table->timestamps();
        });
        
        $newOptionList = new optionList(['group'=>'INDEX', 'filter'=>2, 
                'style'=>'default', 'verbosity'=>true]);
            // TODO: add first optoin list with the default options to the repository of option lists  
            $newOptionList->Save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_lists');
    }
}
