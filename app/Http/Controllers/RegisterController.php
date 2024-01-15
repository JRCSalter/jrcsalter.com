<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
  /**
   * Returns the register.create view.
   *
   * @return view
   */
  public function create()
  {
    return view( 'admin.register.create' );
  }

  /**
   * Stores a user in the database.
   *
   * @return redirect
   */
  public function store()
  {
     $attributes = request()->validate([
       'name'     => [ 'required', 'min:3', 'max:255', Rule::unique( 'users', 'name'  ) ],
       'email'    => [ 'required', 'email', 'max:255', Rule::unique( 'users', 'email' ) ],
       'password' => [ 'required', 'min:8', 'max:255'                                   ]
     ]);

     $user = User::create( $attributes );

     auth()->login( $user );

     return redirect( '/' );
  }
}
