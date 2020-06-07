<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursTourdestinations extends Migration
{
    public function up()
    {
        Schema::table('note_tours_tourdestinations', function($table)
        {
            $table->smallInteger('review')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_tourdestinations', function($table)
        {
            $table->dropColumn('review');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
