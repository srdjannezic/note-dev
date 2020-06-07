<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours16 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->renameColumn('type', 'group_type');
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->renameColumn('group_type', 'type');
        });
    }
}
