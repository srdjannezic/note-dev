<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNoteToursTourtransportation extends Migration
{
    public function up()
    {
        Schema::create('note_tours_tourtransportation', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('tour_id');
            $table->integer('transportation_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['tour_id','transportation_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('note_tours_tourtransportation');
    }
}
