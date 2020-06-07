<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursDestination3 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->string('name', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->dropColumn('name');
        });
    }
}
