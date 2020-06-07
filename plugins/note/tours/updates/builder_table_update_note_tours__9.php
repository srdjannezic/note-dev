<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours9 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('currency', 10)->nullable();
            $table->string('duration_value', 50)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('currency');
            $table->dropColumn('duration_value');
        });
    }
}
