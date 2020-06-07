<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours8 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('name', 500)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('name');
        });
    }
}
