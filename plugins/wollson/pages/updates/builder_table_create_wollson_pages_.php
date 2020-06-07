<?php namespace Wollson\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateWollsonPages extends Migration
{
    public function up()
    {
        Schema::create('wollson_pages_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->string('title', 255)->nullable();
            $table->text('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->string('content_title', 255)->nullable();
            $table->text('content_subtitle')->nullable();
            $table->text('content_gallery')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wollson_pages_');
    }
}
