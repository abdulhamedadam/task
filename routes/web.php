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
    //used for landing page
    Route::get('/','index');
    Route::get('/Articles/all_articles','index')->name('articles_data');
    Route::get('/Articles/get_ajax_data','get_ajax_data')->name('get_ajax_data');
    Route::get('/Articles/create_article','create')->name('create_article');
    Route::post('/Articles/save_article','store')->name('save_article');
    Route::get('/Articles/edit_article/{id}','edit')->name('edit_article');
    Route::post('/Articles/update_article/{id}','updateArticle')->name('update_article');
    Route::post('/Articles/save_image/{id}','storeImage')->name('save_article_image');
    Route::get('/Articles/delete_article/{id}','deleteArticle')->name('delete_article');
    Route::get('/Articles/delete_image/{image_id}/{article_id}','delete_image')->name('delete_image');
    Route::get('/Articles/details/{id}','show')->name('article_details');


});
