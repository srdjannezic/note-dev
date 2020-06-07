<?php namespace Wollson\Widgets\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateWollsonWidgets extends Migration
{
    public function up()
    {
        Schema::create('wollson_widgets_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->integer('region_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wollson_widgets_');
    }
}
