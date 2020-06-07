<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours10 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->text('summary')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('summary');
        });
    }
}
