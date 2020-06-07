<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours18 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dateTime('tour_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('tour_date');
        });
    }
}
