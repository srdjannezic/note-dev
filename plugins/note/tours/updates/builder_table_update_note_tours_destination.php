<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursDestination extends Migration
{
    public function up()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->string('title', 500);
            $table->text('cover_media')->nullable();
            $table->text('content')->nullable();
            $table->text('summary')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_destination', function($table)
        {
            $table->dropColumn('title');
            $table->dropColumn('cover_media');
            $table->dropColumn('content');
            $table->dropColumn('summary');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->increments('id')->unsigned()->change();
        });
    }
}
