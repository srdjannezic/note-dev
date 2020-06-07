<?php namespace Wollson\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateWollsonPages2 extends Migration
{
    public function up()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->text('cover_image')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->dropColumn('cover_image');
            $table->increments('id')->unsigned()->change();
        });
    }
}
