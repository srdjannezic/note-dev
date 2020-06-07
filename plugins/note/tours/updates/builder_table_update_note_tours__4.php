<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours4 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->smallInteger('min_people')->nullable();
            $table->smallInteger('max_people');
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('min_people');
            $table->dropColumn('max_people');
        });
    }
}
