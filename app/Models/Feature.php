<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
  use HasFactory;

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function file()
  {
    return File::find( $this->file );
  }

  public function contents()
  {
    return file_get_contents( asset( 'storage/' . $this->file()->location ) );
  }


  protected $guarded = [];

}
