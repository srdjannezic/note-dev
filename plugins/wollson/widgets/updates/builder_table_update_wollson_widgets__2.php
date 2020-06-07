<?php namespace Wollson\Widgets\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateWollsonWidgets2 extends Migration
{
    public function up()
    {
        Schema::table('wollson_widgets_', function($table)
        {
            $table->renameColumn('icon', 'blocks');
        });
    }
    
    public function down()
    {
        Schema::table('wollson_widgets_', function($table)
        {
            $table->renameColumn('blocks', 'icon');
        });
    }
}
