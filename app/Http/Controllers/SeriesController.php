<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\FlareClient\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class SeriesController extends Controller
{
  /**
   * Returns the admin.series.index view
   * 
   * @return view
   */
  public function index()
  {
      return view( 'admin.series.index', [
          'series' => Series::all()
      ]);
  }
  
  /**
   * Validates the input for creating or editing a series.
   * 
   * @param Series = NULL
   * 
   * @return array
   */
  public function validateInput( ?Series $series = NULL ): array
  {
    $series ??= new Series();

    $attributes = request()->validate([
      'title'              => [
        'required',
        'max:255',
        Rule::unique('series', 'title')->ignore( $series )
      ],
      'description' => [ 'required',     'max:65535'                         ],
      'image'       => $series->exists ? [ 'image' ] : [ 'required', 'image' ],
    ]);

    return $attributes;
  }

  /**
   * Returns the series.create view.
   *
   * @return view
   */
  public function create()
  {
    return view( 'admin.series.create' );
  }

  /**
   * Stores a Series in the database, and processes the uploaded file.
   *
   * @return redirect
   */
  public function store()
  {
    $attributes = $this->validateInput();
    
    if ( request()->file() )
    {
      $attributes[ 'image' ] = FileController::store( request()->file( 'image' ), $attributes )->id;
    }

    $attributes[ 'slug' ] = $this->createSlug( $attributes[ 'title' ] );

    Series::create( $attributes );

    return redirect( '/admin' );
  }
  
  /**
   * Return the view to edit the series.
   * 
   * @return view
   */
  public function edit( Series $series )
  {
    return view( 'admin.series.edit', [ 'series' => $series ]);
  }

  /**
   * Updates the series and processes the uploaded file.
   * Will delete a file if changed.
   * 
   * @param Series $series
   * 
   * @return redirect
   */
  public function update( Series $series )
  {
    $attributes = $this->validateInput( $series );

    if ( request()->file( 'image' ) )
    {
      $attributes[ 'image' ] = FileController::store( request()->file( 'image' ), $attributes )->id;
    }
    
    if (
      $series->image &&
      isset( $attributes[ 'image' ]) &&
      $attributes[ 'image' ] &&
      $attributes[ 'image' ] != $series->image
    )
    {
      $file = $series->image();
      unlink( public_path( 'storage/' . $file->location ));
    }

    $attributes[ 'slug' ] = $this->createSlug( $attributes[ 'title' ] );
    
    $series->update( $attributes );

    if ( isset( $file ) ) $file->delete();

    return redirect('/admin')->with( 'success', "$series->title was updated" );
  }

  /**
   * Deletes a series
   * 
   * @param Series $series
   * 
   * @return back()
   */
  public function destroy( Series $series )
  {
    $title = $series->title;
    if ( $series->image ) FileController::destroy( $series->image() );
    $series->delete();

    return back()->with( 'success', "$title is deleted" );
  }
}
