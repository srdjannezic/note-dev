<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNoteToursTourtype extends Migration
{
    public function up()
    {
        Schema::create('note_tours_tourtype', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('note_tours_tourtype');
    }
}
