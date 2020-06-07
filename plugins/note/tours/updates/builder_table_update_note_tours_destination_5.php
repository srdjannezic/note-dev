<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursDestination5 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->string('slug', 255)->nullable();
            $table->smallInteger('review')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->dropColumn('slug');
            $table->dropColumn('review');
        });
    }
}
