<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFastOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('option_lists', function ($table) {
            $table->boolean('fast')->comment('true or false this skips delete confirmation and other redundant pages.')->default(FALSE);
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
        Schema::table('option_lists', function ($table) {
            $table->dropColumn('votes');
        });
    }
}
