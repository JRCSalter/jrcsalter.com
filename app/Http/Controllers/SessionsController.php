<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SessionsController extends Controller
{

  /**
   * Returns the admin.sessions.create view.
   * 
   * @return view
   */
  public function create()
  {
    return view( 'admin.sessions.create' );
  }

  /**
   * Creates a new session.
   * 
   * @return redirect
   */
  public function store()
  {
    $attributes = request()->validate([
      'email'    => [ 'required', 'email' ],
      'password' => [ 'required'          ],
    ]);

    if ( auth()->attempt( $attributes ) )
    {
      session()->regenerate();

      return redirect( '/admin' )->with( 'success', 'Logged in' );
    }

    return back()->withInput()->withErrors([ 'email' => 'Could not be verified' ]);
  }
  
  /**
   * Ends the session.
   * 
   * @return redirect
   */
  public function destroy()
  {
    auth()->logout();

    return redirect( '/' )->with( 'success', 'You have been successfully logged out.' );
  }
}
