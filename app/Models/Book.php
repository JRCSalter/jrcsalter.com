<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * External link categories for books.
   */
  public static $ext_links = [
    'amazon_pb',
    'amazon_eb',
    'apple',
    'audible',
    'goodreads',
    'kobo',
    'nook',
    'patreon',
    'subscribestar',
    'sw',
    'world_anvil',
    'youtube',
  ];
  
  /**
   * Internal link categories for books.
   */
  public static $int_links = [
    'bbcode',
    'epub',
    'html',
    'kindle',
    'pdf',
    'md',
    'tex',
    'txt',
  ];
    
  /**
   * Supported formats.
   */
  public static  $formats = [
    'epub',
    'audio',
    'paperback',
  ];
  
  /**
   * Supported currencies.
   */
  public static $currencies = [
    'gbp',
    'eur',
    'usd'
  ];

  public function getRouteKeyName()
{
  return 'slug';
}

  /**
   * Gets the File object associated with the cover.
   * 
   * @return File Object
   */
  public function cover()
  {
    return File::find( $this->cover );
  }

  /**
   * Gets the series the book belongs to.
   * 
   * @return Series
   */
  public function series()
  {
    return $this->belongsTo( Series::class )->first();
  }
  
  /**
   * Gets all books and organises them into an array organised by series.
   * Also includes books not in series.
   * 
   * @return array
   */
  public static function allWithSeries()
  {
    $books = [];
    
    foreach ( Series::all() as $series )
    {
      foreach ( $series->books as $book )
      {
        $books[ $series->title ][] = $book;
      }
    
    }
    
    // Here, we need to get all the books, and select only those without a corresponding series.
    foreach ( parent::all() as $book )
    {
      if ( $book->attributes[ 'series_id' ] != NULL ) continue;
      $books[ $book->title ] = $book;
    }

    ksort( $books );

    return $books;
  }

  /**
   * Gets all the external links for a paritcular book.
   * Uses the set links provided in Book::class.
   * 
   * @return array
   */
  public function links()
  {
    $links = [];

    foreach ( Book::$ext_links as $link )
    {
      $links[] = $link . '_link';
    }

    return Book::find( $this->id, $links );
  }

  /**
   * Gets all the internal links for a particular book.
   * Uses the set links provided in Book::class.
   * 
   * @return array
   */
  public function int_links()
  {
    $links = [];
    foreach ( Book::$int_links as $link )
    {
      $links[] = $link . '_link';
    }

    return Book::find( $this->id, $links );
  }

  /**
   * Gets the relevant prices for each format of a book in currencies specified in Book::class.
   * 
   * @return array
   */
  public function prices()
  {
    $prices = [];
    foreach ( Book::$formats as $format )
    {
      foreach ( Book::$currencies as $currency )
      {
        $format_prices[] = 'cost_' . $format . '_' . $currency;
      }
      $prices[ $format ] = Book::find( $this->id, $format_prices )->attributes;
    }

    return $prices;
  }

  /**
   * Get the price of a book in the specified format and currency.
   * 
   * @param $format   string = 'epub'
   * @param $currency string = 'usd'
   * 
   * @return string
   */
  public function getPrice( $format = 'epub', $currency = 'usd', $withsymbol = false )
  {
    $symbol = "";
    $aftersymbol = "";
    if( $withsymbol )
    {
      switch ( $currency ) {
        case 'gbp':
          $symbol = "£";
          break;
        
        case 'eur':
          $symbol = "€";
          break;
        
        default:
          $symbol = "$";
          break;
      }
    }

    $string = $symbol . $this->prices()[ $format ][ 'cost_' . $format . '_' . $currency ] . $aftersymbol;

    return $string == "" ? NULL : $string;
  }

  /**
   * Gets all the keywords, and formats them into an array.
   * 
   * @return array
   */
  public function getKeywords()
  {
    return explode( ",", $this->keywords );
  }
}
