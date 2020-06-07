<?php namespace Note\Partners\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNotePartners extends Migration
{
    public function up()
    {
        Schema::create('note_partners_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->text('icon')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('note_partners_');
    }
}
