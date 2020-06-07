<?php namespace BenFreke\MenuManager\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBenfrekeMenumanagerMenus extends Migration
{
    public function up()
    {
        Schema::table('benfreke_menumanager_menus', function($table)
        {
            $table->text('icon')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('benfreke_menumanager_menus', function($table)
        {
            $table->dropColumn('icon');
        });
    }
}
