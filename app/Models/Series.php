<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Series extends Model
{
  use HasFactory;

  protected $guarded = [];
  
  /**
   * Gets the File object associated with the image.
   * 
   * @return File Object
   */
  public function image()
  {
    return File::find( $this->image );
  }

  public function getRouteKeyName()
{
  return 'slug';
}

    
  /**
   * Gets all books in the database, ordered by series and position in series.
   * 
   * @return array of Book::class
   */
  public function books()
  {
    return $this->hasMany( Book::class )
      ->select( DB::raw(
        'series.id AS series_id,
        series.title AS series_title,
        books.id,
        books.title,
        books.slug,
        books.position_in_series,
        books.cover'
      ))
      ->leftJoin( 'series', 'books.series_id' , '=' , 'series.id' )
      ->orderBy( 'series.id' )
      ->orderBy( 'books.position_in_series' );
  }

}
