<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursDestination2 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->text('featured_image')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->dropColumn('featured_image');
        });
    }
}
