<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

  protected function createSlug( $string )
  {
    $string = str_replace( '\'', '', $string );
    $string = str_replace( '"',  '', $string );
    $string = str_replace( '!',  '', $string );
    $string = str_replace( '?',  '', $string );
    $string = str_replace( ' ',  '-', $string );
    $string = str_replace( '--',  '-', $string );
    $string = strtolower( $string );

    return $string;
  }

}
