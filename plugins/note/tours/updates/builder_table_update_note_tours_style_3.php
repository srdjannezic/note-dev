<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursStyle3 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_style', function($table)
        {
            $table->text('description')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_style', function($table)
        {
            $table->text('description')->nullable(false)->change();
        });
    }
}
