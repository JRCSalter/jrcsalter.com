<?php

use App\Models\Book;
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
    Schema::create( 'books', function ( Blueprint $table ) {
      $table->id();
      $table->string(             'supertitle'         )->nullable();
      $table->string(             'title'              );
      $table->string(             'slug'               );
      $table->string(             'subtitle'           )->nullable();
      $table->unsignedBigInteger( 'cover'              )->nullable();
      $table->foreignId(          'series_id'          )->nullable();
      $table->integer(            'position_in_series' )->nullable();
      $table->text(               'blurb'              )->nullable();
      $table->text(               'excerpt'            )->nullable();
      $table->text(               'praise'             )->nullable();
      $table->integer(            'word_count'         )->nullable();
      $table->integer(            'pages'              )->nullable();
      $table->text(               'chapters'           )->nullable();
      $table->text(               'keywords'           )->nullable();
      $table->timestamp(          'published'          )->nullable();
      $table->string(             'isbn'               )->nullable();
      $table->string(             'isbn_13'            )->nullable();
      $table->string(             'asin'               )->nullable();

      foreach ( Book::$ext_links as $link )
      {
        $table->string( $link . '_link' )->nullable();
      }
      foreach ( Book::$int_links as $link )
      {
        $table->string( 'jrcsalter_' . $link . '_link' )->nullable();
      }
      foreach ( Book::$formats as $format )
      {
        foreach ( Book::$currencies as $currency )
        {
          $table->string( 'cost_' . $format . '_' . $currency )->nullable();
        }
      }

      $table->foreign( 'cover' )
        ->references( 'id' )
        ->on( 'files' )
        ->onDelete( 'cascade' );
     
      $table->foreign( 'series_id' )
        ->references( 'id' )
        ->on( 'series' )
        ->onDelete( 'cascade' );
     
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists( 'books' );
  }
};
