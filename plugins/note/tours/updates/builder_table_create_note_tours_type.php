<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNoteToursType extends Migration
{
    public function up()
    {
        Schema::create('note_tours_type', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255);
            $table->text('icon')->nullable();
            $table->text('description');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('note_tours_type');
    }
}
