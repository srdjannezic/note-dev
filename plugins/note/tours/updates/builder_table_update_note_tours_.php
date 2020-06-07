<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteTours extends Migration
{
    public function up()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->string('title', 500);
            $table->text('featured_media')->nullable();
            $table->string('price', 255)->nullable();
            $table->string('duration', 255)->nullable();
            $table->text('gallery')->nullable();
            $table->text('content')->nullable();
            $table->text('highlights')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_', function($table)
        {
            $table->dropColumn('title');
            $table->dropColumn('featured_media');
            $table->dropColumn('price');
            $table->dropColumn('duration');
            $table->dropColumn('gallery');
            $table->dropColumn('content');
            $table->dropColumn('highlights');
        });
    }
}
