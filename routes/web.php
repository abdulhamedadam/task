<?php

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

Route::controller(\App\Http\Controllers\Articles_C::class)->group(function () {
    Route::get('/Articles/all_articles','index')->name('articles_data');
    Route::get('/Articles/get_ajax_data','get_ajax_data')->name('get_ajax_data');
    Route::get('/Articles/create_article','create')->name('create_article');
    Route::post('/Articles/save_article','save')->name('save_article');
    Route::get('/Articles/edit_article/{id}','creat')->name('edit_article');
    Route::post('/Articles/update_article/{id}','update')->name('update_article');
    Route::get('/Articles/delete_article/{id}','delete')->name('delete_article');


});
