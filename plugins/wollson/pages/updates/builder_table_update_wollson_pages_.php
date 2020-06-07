<?php namespace Wollson\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateWollsonPages extends Migration
{
    public function up()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->dropColumn('content_title');
            $table->dropColumn('content_subtitle');
            $table->dropColumn('content_gallery');
        });
    }
    
    public function down()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->string('content_title', 255)->nullable();
            $table->text('content_subtitle')->nullable();
            $table->text('content_gallery')->nullable();
        });
    }
}
