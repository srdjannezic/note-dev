<?php namespace Wollson\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateWollsonPages4 extends Migration
{
    public function up()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->text('price_left')->nullable();
            $table->text('price_right')->nullable();
            $table->text('price_description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('wollson_pages_', function($table)
        {
            $table->dropColumn('price_left');
            $table->dropColumn('price_right');
            $table->dropColumn('price_description');
        });
    }
}
