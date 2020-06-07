<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursStyle4 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_style', function($table)
        {
            $table->string('slug', 255)->nullable();
            $table->string('name', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_style', function($table)
        {
            $table->dropColumn('slug');
            $table->dropColumn('name');
        });
    }
}
