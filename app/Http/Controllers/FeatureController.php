<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeatureController extends Controller
{
  
  /**
   * Returns a list of all features with options to view, edit, or delete.
   * 
   * @return view
   */
  public function index()
  {
      return view( 'admin.features.index', [
          'features' => Feature::paginate( 50 )
      ]);
  }

  /**
   * Return the view to edit the feature.
   * 
   * @return view
   */
  public function edit( Feature $feature )
  {
    return view( 'admin.features.edit', [ 'feature' => $feature ]);
  }

  /**
   * Updates the feature and saves the contents to file.
   * 
   * @param Feature $feature
   * 
   * @return redirect
   */
  public function update( Feature $feature )
  {
    $attributes = $this->validateInput( $feature );

    $file = fopen( 'storage/' . $feature->file()->location, 'w' );

    fwrite( $file, $attributes[ 'contents' ] );

    fclose( $file );

    $attributes[ 'slug' ] = $this->createSlug( $attributes[ 'title' ] );
    
    unset($attributes[ 'contents']);
    
    $feature->update( $attributes );

    return redirect('/admin')->with( 'success', "$feature->title was updated" );
  }

  
  /**
   * Returns the feature.create view.
   *
   * @return view
   */
  public function create()
  {
    return view( 'admin.features.create' );
  }

  public function validateInput( ?Feature $feature = NULL ): array
  {
    $feature ??= new Feature();

    $attributes = request()->validate([
      'title' => [
        'required',
        'max:255',
        Rule::unique( 'features', 'title' )->ignore( $feature )
      ],
      'file'    => $feature->exists ? [] : [ 'required' ],
      'from'        => [ 'max:255'                                  ],
      'stand_alone' => [ 'boolean'                                  ],
      'contents'    => [ ''                                         ]
    ]);

    if ( $attributes[ 'from' ] != "" ) $attributes[ 'stand_alone' ] = "0";

    return $attributes;
  }

  /**
   * Stores a Featue in the database, and processes the uploaded file.
   *
   * @return redirect
   */
  public function store()
  {
    $attributes = $this->validateInput();
    
    $attributes[ 'file' ] = FileController::store( request()->file( 'file' ), $attributes, 'features' )->id;
    
    $attributes[ 'slug' ] = $this->createSlug( $attributes[ 'title' ] );

    Feature::create( $attributes );

    return redirect( '/admin' );
  }

  /**
   * Deletes a feature
   * 
   * @param Feature $feature
   * 
   * @return back()
   */
  public function destroy( Feature $feature )
  {
    $title = $feature->title;
    FileController::destroy( $feature->file() );
    $feature->delete();

    return back()->with( 'success', "$title is deleted" );
  }

}
