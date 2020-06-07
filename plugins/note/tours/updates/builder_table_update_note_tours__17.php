<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours17 extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->text('bokun_media')->nullable();
            $table->integer('bokun_activity_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('bokun_media');
            $table->dropColumn('bokun_activity_id');
        });
    }
}
