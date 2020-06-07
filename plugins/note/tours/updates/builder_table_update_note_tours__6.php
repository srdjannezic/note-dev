<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours6 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->renameColumn('destination_id', 'destinations_id');
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->renameColumn('destinations_id', 'destination_id');
        });
    }
}
