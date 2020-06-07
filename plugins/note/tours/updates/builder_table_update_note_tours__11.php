<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours11 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('transportation');
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('transportation', 255)->nullable();
        });
    }
}
