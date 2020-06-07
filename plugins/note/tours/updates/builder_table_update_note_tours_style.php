<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursStyle extends Migration
{
    public function up()
    {
        Schema::table('note_tours_style', function($table)
        {
            $table->string('title', 255);
            $table->text('description');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_style', function($table)
        {
            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->increments('id')->unsigned()->change();
        });
    }
}
