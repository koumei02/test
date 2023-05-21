<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AutoController;
use App\Http\Controllers\MasterController;


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
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::group(['middleware' => 'auth'], function(){
    // Route::get('/', 'HomeController@index')->name('home');
    Route::resource('auto','AutoController');
    Route::resource('food','FoodController');
    Route::resource('master','MasterController');
    Route::resource('mastersub','MasterSubController');
    Route::resource('masteraccount','MasterAccountController');
    Route::post('/ajaxlike', 'FoodController@ajaxlike')->name('food.ajaxlike');
});



