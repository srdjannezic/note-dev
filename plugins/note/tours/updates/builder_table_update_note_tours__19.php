<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours19 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('is_on_demand', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('is_on_demand');
        });
    }
}
