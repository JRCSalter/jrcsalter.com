<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('features', function (Blueprint $table) {
      $table->id();
      $table->string(  'title'       )->unique();
      $table->string(  'slug'        )->unique();
      $table->boolean( 'stand_alone' )->nullable();
      $table->string(  'from'        )->nullable();
      $table->string(  'file'        );
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('features');
  }
};
