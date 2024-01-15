<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\SessionsController;
use App\Models\Book;
use App\Models\Feature;
use App\Models\Series;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
 * Site map:
 * 
 * Public:
 * / - Home
 * /books - view Books
 * /books/{book} - View individual book
 * /books/{series} - View individual series
 * /features - View features
 * /features/{feature} - view individual feature
 * /blog - Blog page
 * /about - About page
 * 
 * Administration:
 * /admin - View admin options. Defaults to admin login if not signed in
 * /admin/books/create - Shows form to create a book
 * /admin/books/edit - Shows form to edit a book
 * /admin/books/store - End point to deliver information from form
 * /admin/books/destroy - End point to delete book via form
 * /admin/books/index - Shows list of all books with options to do stuff
 * /admin/books/update - End point to update a book via form
 * /admin/books/show - Show an individual book
 */

Route::get( '/', function () {
  return view( 'home' );
} );

Route::get( '/books', function () {
  return view( 'books', [
    'books' => Book::allWithSeries()
  ] );
} );

Route::get( '/books/{book:slug}', function ( Book $book ) {
  return view( 'book', [
    'book' => $book
  ] );
} );

Route::get( '/series/{series}', function ( Series $series ) {
  return view( 'series', [
    'series' => $series
  ] );
} );

Route::get( '/series/{series}/{book}', function ( Series $series, Book $book ) {
  return view( 'book', [
    'book' => $book,
    'series' => $series
  ] );
} );

Route::get( '/features', function () {
  return view( 'features' );
} );

Route::get( '/features/{feature}', function ( Feature $feature) {
  return view( 'feature', [
    'feature' => $feature,
    'file' => file_get_contents( asset( 'storage/' . $feature->file()->location ) )
  ]);
} );

Route::get( '/blog', function () {
  return view( 'blog' );
} );

Route::get( '/about', function () {
  return view( 'about' );
} );

Route::get( '/admin', function () {
  return view( 'admin/index' );
} );

Route::get(  '/admin/login',  [ SessionsController::class, 'create'  ] )->middleware( 'guest' );
Route::post( '/admin/login',  [ SessionsController::class, 'store'   ] )->middleware( 'guest' );
Route::post( '/admin/logout', [ SessionsController::class, 'destroy' ] )->middleware( 'auth'  );

Route::get(  '/admin/register', [ RegisterController::class, 'create' ] )->middleware( 'guest' );
Route::post( '/admin/store',    [ RegisterController::class, 'store'  ] )->middleware( 'guest' );

Route::get(    '/admin/series/index',         [ SeriesController::class, 'index'   ] )->middleware( 'auth' );
Route::get(    '/admin/series/create',        [ SeriesController::class, 'create'  ] )->middleware( 'auth' );
Route::post(   '/admin/series/store',         [ SeriesController::class, 'store'   ] )->middleware( 'auth' );
Route::get(    '/admin/series/{series}/show', [ SeriesController::class, 'show'    ] )->middleware( 'auth' );
Route::get(    '/admin/series/{series}/edit', [ SeriesController::class, 'edit'    ] )->middleware( 'auth' );
Route::patch(  '/admin/series/{series}',      [ SeriesController::class, 'update'  ] )->middleware( 'auth' );
Route::delete( '/admin/series/{series}',      [ SeriesController::class, 'destroy' ] )->middleware( 'auth' );

Route::get(    '/admin/books/index',       [ BookController::class, 'index'   ] )->middleware( 'auth' );
Route::get(    '/admin/books/create',      [ BookController::class, 'create'  ] )->middleware( 'auth' );
Route::post(   '/admin/books/store',       [ BookController::class, 'store'   ] )->middleware( 'auth' );
Route::get(    '/admin/books/{book}/show', [ BookController::class, 'show'    ] )->middleware( 'auth' );
Route::get(    '/admin/books/{book}/edit', [ BookController::class, 'edit'    ] )->middleware( 'auth' );
Route::patch(  '/admin/books/{book}',      [ BookController::class, 'update'  ] )->middleware( 'auth' );
Route::delete( '/admin/books/{book}',      [ BookController::class, 'destroy' ] )->middleware( 'auth' );

Route::get(  '/admin/features/create',           [ FeatureController::class, 'create' ] )->middleware( 'auth' );
Route::post( '/admin/features/store',            [ FeatureController::class, 'store'  ] )->middleware( 'auth' );
Route::get(  '/admin/features/index',            [ FeatureController::class, 'index'  ] )->middleware( 'auth' );
Route::get(    '/admin/features/{feature}/show', [ FeatureController::class, 'show'    ] )->middleware( 'auth' );
Route::get(    '/admin/features/{feature}/edit', [ FeatureController::class, 'edit'    ] )->middleware( 'auth' );
Route::patch(  '/admin/features/{feature}',      [ FeatureController::class, 'update'  ] )->middleware( 'auth' );
Route::delete( '/admin/features/{feature}',      [ FeatureController::class, 'destroy' ] )->middleware( 'auth' );