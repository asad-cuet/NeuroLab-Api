<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateUserClassificationsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('user_classifications', function (Blueprint $table) {
              $table->id();
              $table->integer('sampling_duration_sec')->nullable();
              $table->double('stress_score',3,2)->nullable();
              $table->integer('user_id')->nullable();
              $table->text('raw_eeg')->nullable();
              $table->text('features')->nullable();
              $table->integer('order')->default(0);
              $table->timestamps();
          });
      }

      public function down()
      {
          Schema::dropIfExists('user_classifications');
      }
  }
  