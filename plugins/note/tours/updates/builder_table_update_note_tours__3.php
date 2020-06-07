<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours3 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->integer('duration')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('duration', 255)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
