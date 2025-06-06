<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateBlogsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('blogs', function (Blueprint $table) {
              $table->id();
              $table->string('banner')->nullable();
              $table->string('title')->nullable();
              $table->string('slug')->unique();
              $table->string('meta_title')->nullable();
              $table->string('meta_tags')->nullable();
              $table->integer('blog_category_id')->nullable();
              $table->string('status')->nullable();
              $table->text('short_description')->nullable();
              $table->text('description')->nullable();
              $table->text('meta_description')->nullable();
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
          Schema::dropIfExists('blogs');
      }
  }
  