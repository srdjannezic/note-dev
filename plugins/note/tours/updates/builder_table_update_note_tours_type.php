<?php namespace Note\Tours\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNoteToursType extends Migration
{
    public function up()
    {
        Schema::table('note_tours_type', function($table)
        {
            $table->string('slug', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->text('description')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('note_tours_type', function($table)
        {
            $table->dropColumn('slug');
            $table->dropColumn('name');
            $table->text('description')->nullable(false)->change();
        });
    }
}
