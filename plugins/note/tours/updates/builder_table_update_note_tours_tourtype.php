<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursTourtype extends Migration
{
    public function up()
    {
        Schema::table('note_tours_tourtype', function($table)
        {
            $table->integer('tour_id');
            $table->integer('type_id');
            $table->dropColumn('id');
            $table->primary(['tour_id','type_id']);
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_tourtype', function($table)
        {
            $table->dropPrimary(['tour_id','type_id']);
            $table->dropColumn('tour_id');
            $table->dropColumn('type_id');
            $table->increments('id')->unsigned();
        });
    }
}
