<?php namespace Note\Faq\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNoteFaq extends Migration
{
    public function up()
    {
        Schema::create('note_faq_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('question');
            $table->text('answer')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('note_faq_');
    }
}
