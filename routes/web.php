<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\LanguageController;

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
// Route Languages
Route::get('lang/change', [LanguageController::class,'change'])->name('changeLang');
// Route Get All links of all users
Route::get('/', [LinkController::class, 'getAllLinks'])->name('links.index.all');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route Links
Route::resource('links', LinkController::class);
