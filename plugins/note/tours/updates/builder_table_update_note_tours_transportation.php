<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursTransportation extends Migration
{
    public function up()
    {
        Schema::table('note_tours_transportation', function($table)
        {
            $table->text('icon')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_transportation', function($table)
        {
            $table->dropColumn('icon');
        });
    }
}
