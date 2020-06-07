<?php namespace Wollson\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateWollsonPages3 extends Migration
{
    public function up()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->text('gallery')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->dropColumn('gallery');
        });
    }
}
