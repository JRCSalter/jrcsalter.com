<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
  /**
   * Stores a file in the database.
   *
   * @param File Object
   * @param Array = [] of attributes
   * @param String = 'image' to indicate the storage directory
   * 
   * @return File
   */
  public static function store( Object $file, $attributes = [], $storageDir = 'images' )
  {
     $type = $file->getClientMimeType();
     $size = $file->getSize();
     $location = $file->store( $storageDir );

     File::create([
       'user_id' => auth()->id(),
       'name'   => $file->getClientOriginalName(),
       'title' => $attributes[ 'title' ] ?? $location,
       'location'    => $location,
       'type'    => $type,
       'size'    => $size
     ]);
     
     return File::wherelocation( $location )->first();
      
  }

  /**
   * Deletes the file from the database, and removes it from the storage directory
   * 
   * @param File Object
   * 
   * @return void
   */
  public static function destroy( File $file )
  {
    unlink( public_path( 'storage/' . $file->location ));
    $file->delete();
  }
}
