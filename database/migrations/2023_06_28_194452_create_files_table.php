<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create( 'files', function ( Blueprint $table ) {
      $table->id();
      $table->unsignedBigInteger( 'user_id'    )->nullable();
      $table->string(             'title'      )->nullable();
      $table->string(             'name'      )->nullable();
      $table->string(             'location'       )->nullable();
      $table->string(             'location-md'    )->nullable();
      $table->string(             'location-sm'    )->nullable();
      $table->string(             'type'       )->nullable();
      $table->string(             'size'       )->nullable();
      $table->timestamps();

      $table->foreign( 'user_id' )
        ->references( 'id' )
        ->on( 'users' )
        ->onDelete( 'cascade' );
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
      Schema::dropIfExists( 'files' );
  }
};
