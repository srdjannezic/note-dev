<?php namespace Wollson\Widgets\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateWollsonWidgetsRegions extends Migration
{
    public function up()
    {
        Schema::table('wollson_widgets_regions', function($table)
        {
            $table->increments('id')->change();
        });
    }
    
    public function down()
    {
        Schema::table('wollson_widgets_regions', function($table)
        {
            $table->integer('id')->change();
        });
    }
}
