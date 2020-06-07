<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNoteToursTransportation extends Migration
{
    public function up()
    {
        Schema::create('note_tours_transportation', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('note_tours_transportation');
    }
}
