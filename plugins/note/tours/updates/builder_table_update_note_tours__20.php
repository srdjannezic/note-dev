<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours20 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->boolean('is_on_demand')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('is_on_demand', 255)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
