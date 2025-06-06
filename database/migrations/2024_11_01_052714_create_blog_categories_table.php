<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateBlogCategoriesTable extends Migration
  {
      
      public function up()
      {
          Schema::create('blog_categories', function (Blueprint $table) {
              $table->id();
              $table->string('banner')->nullable();$table->string('title')->nullable();$table->string('slug')->unique();$table->integer('parent_id')->nullable();
              $table->integer('order')->default(0);
              $table->boolean('is_active')->default(true);
              $table->unsignedBigInteger('created_by')->nullable();
              $table->unsignedBigInteger('updated_by')->nullable();
              $table->timestamps();
              $table->softDeletes();
          });
      }

      public function down()
      {
          Schema::dropIfExists('blog_categories');
      }
  }
  