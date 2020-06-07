<?php namespace Wollson\Widgets\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateWollsonWidgetsRegions extends Migration
{
    public function up()
    {
        Schema::create('wollson_widgets_regions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('name', 255);
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wollson_widgets_regions');
    }
}
