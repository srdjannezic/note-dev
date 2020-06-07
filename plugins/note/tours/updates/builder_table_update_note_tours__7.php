<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours7 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('slug', 255)->nullable();
            $table->smallInteger('review')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('slug');
            $table->dropColumn('review');
        });
    }
}
