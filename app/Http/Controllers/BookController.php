<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use App\Models\Series;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
  
  /**
   * Returns a list of all books with options to view, edit, or delete.
   * 
   * @return view
   */
  public function index()
  {
      return view( 'admin.books.index', [
          'books' => Book::paginate( 50 )
      ]);
  }
  
  /**
   * Returns the book.create view.
   *
   * @return view
   */
  public function create()
  {
    return view( 'admin.books.create' );
  }

  /**
   * Validates the input for creating or editing a book.
   * 
   * @param Book = NULL
   * 
   * @return array
   */
  public function validateInput( ?Book $book = NULL ): array
  {
    $book ??= new Book();

    $attributes = request()->validate([
      'title'              => [
        'required',
        'max:255',
        Rule::unique('books', 'title')->ignore( $book )
      ],
      'supertitle'         => [               'max:255'                           ],
      'subtitle'           => [               'max:255'                           ],
      'blurb'              => [ 'required',   'max:65535'                         ],
      'cover'              => $book->exists ? [ 'image' ] : [ 'required', 'image' ],
      'series_id'          => [               'numeric'                           ],
      'position_in_series' => [               'numeric'                           ],
      'blurb'              => [               'max:65535'                         ],
      'excerpt'            => [               'max:65535'                         ],
      'praise'             => [               'max:65535'                         ],
      'word_count'         => [               'numeric'                           ],
      'pages'              => [               'numeric'                           ],
      'chapters'           => [               'max:65535'                         ],
      'keywords'           => [               'max:65535'                         ],
      'published'          => [               'date'                              ],
      'isbn'               => [               'max:255'                           ],
      'isbn_13'            => [               'max:255'                           ],
      'asin'               => [               'max:255'                           ],
    ]);
    
    // Need to loop through all the prices, and validate them.
    foreach ( Book::$formats as $format )
    {
      foreach ( Book::$currencies as $currency )
      {
        $name = 'cost_' . $format . '_' . $currency;
        $attributes += request()->validate([ $name => [ 'decimal:2' ] ]);
        if ( $attributes[ $name ] == "0.00" )
        {
          $attributes[ $name ] = NULL;
        }
      }
    }

    // Convert empty strings or zeroes into NULL.
    if ( !$attributes[ 'series_id'          ]        ) $attributes[ 'series_id'          ] = NULL;
    if ( $attributes[  'position_in_series' ] == "0" ) $attributes[ 'position_in_series' ] = NULL;
    if ( $attributes[  'word_count'         ] == "0" ) $attributes[ 'word_count'         ] = NULL;
    if ( $attributes[  'pages'              ] == "0" ) $attributes[ 'pages'              ] = NULL;

    return $attributes;
  }

  /**
   * Stores a Book in the database, and processes the uploaded file.
   *
   * @return redirect
   */
  public function store() // StoreFileRequest $request )
  {
    $attributes = $this->validateInput();
    
    if ( request()->file() )
    {
      $attributes[ 'cover' ] = FileController::store( request()->file( 'cover' ), $attributes )->id;
    }
    
    $attributes[ 'slug' ] = $this->createSlug( $attributes[ 'title' ] );

    Book::create( $attributes );

    return redirect( '/admin' );
  }

  /**
   * Return the view to edit the book.
   * 
   * @return view
   */
  public function edit( Book $book )
  {
    return view( 'admin.books.edit', [ 'book' => $book ]);
  }

  /**
   * Updates the book and processes the uploaded file.
   * Will delete a file if changed.
   * 
   * @param Book $book
   * 
   * @return redirect
   */
  public function update( Book $book )
  {
    $attributes = $this->validateInput( $book );

    if ( request()->file( 'cover' ) )
    {
      $attributes[ 'cover' ] = FileController::store( request()->file( 'cover' ), $attributes )->id;
    }
    
    if (
      $book->cover &&
      isset( $attributes[ 'cover' ]) &&
      $attributes[ 'cover' ] &&
      $attributes[ 'cover' ] != $book->cover
    )
    {
      $file = $book->cover();
      unlink( public_path( 'storage/' . $file->location ));
    }
    
    $attributes[ 'slug' ] = $this->createSlug( $attributes[ 'title' ] );
    
    $book->update( $attributes );

    if ( isset( $file ) ) $file->delete();

    return redirect('/admin')->with( 'success', "$book->title was updated" );
  }

  /**
   * Deletes a book
   * 
   * @param Book $book
   * 
   * @return back()
   */
  public function destroy( Book $book )
  {
    $title = $book->title;
    if ( $book->cover() ) FileController::destroy( $book->cover() );
    $book->delete();

    return back()->with( 'success', "$title is deleted" );
  }
}
