<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('permission')->nullable();
            $table->integer('crud_id')->nullable();
            $table->string('icon')->nullable();
            $table->integer('is_newtab')->nullable();
            $table->string('bullet')->default('dot');
            $table->integer('parent_id')->default(0);
            $table->boolean('is_shortcut')->nullable();
            $table->boolean('is_quick_action')->nullable();
            $table->string('color_type')->nullable();
            $table->integer('is_section')->nullable();
            $table->integer('is_separator')->nullable();
            $table->boolean('is_active')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menus');
    }
}
