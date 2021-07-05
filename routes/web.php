<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserBooksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('lang/{lang}', [LanguageController::class, 'changeLanguage'])->name('lang');

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('publishers', PublisherController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
});

Route::group([['middleware' => 'locale']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'indexUser'])->name('home');
    Route::get('all-books', [UserBooksController::class, 'index'])->name('user.books');
    Route::get('all-books/{book_id}', [UserBooksController::class, 'detail'])->name('user.bookdetail');
});
