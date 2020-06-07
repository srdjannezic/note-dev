<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursTourstyle extends Migration
{
    public function up()
    {
        Schema::table('note_tours_tourstyle', function($table)
        {
            $table->integer('tour_id');
            $table->integer('style_id');
            $table->dropColumn('id');
            $table->primary(['tour_id','style_id']);
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_tourstyle', function($table)
        {
            $table->dropPrimary(['tour_id','style_id']);
            $table->dropColumn('tour_id');
            $table->dropColumn('style_id');
            $table->increments('id')->unsigned();
        });
    }
}
