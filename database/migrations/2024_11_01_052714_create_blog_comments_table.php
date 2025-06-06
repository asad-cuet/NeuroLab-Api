<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateBlogCommentsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('blog_comments', function (Blueprint $table) {
              $table->id();
              $table->string('image')->nullable();
              $table->string('name')->nullable();
              $table->string('phone')->nullable();
              $table->string('email')->nullable();
              $table->integer('user_id')->nullable();
              $table->integer('blog_id')->nullable();
              $table->integer('parent_id')->nullable();
              $table->string('status')->nullable();   //approved, pending, cancelled
              $table->text('description')->nullable();
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
          Schema::dropIfExists('blog_comments');
      }
  }
  