<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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
//Route::get('/admin/{any}', [FrontendController::class, 'admin'])->where('any', '.*');
// For public application
//Route::any('/{any}', [FrontendController::class, 'app'])->where('any', '^(?!api).*$');

// Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

Route::get('/lang/{locale}', function ($locale) {

    if (array_key_exists($locale, [
        'en' => 'English',
        'cn' => '中文',
        'th' => 'Thailand',
        'vn' => 'Vietnam',
        'kr' => 'Korea',
    ])) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return Redirect::back();

    //
});

// Route::get('lang/{lang}', 'LanguageController@get')->name('switchLang');

Route::get('/manage{any}', function () {
    return view('app');
})->where('any', '.*');

// Route::get('/', function () {
//     return view('home.index');
// });

Route::get('/', function () {
    return view('app');
})->where('any', '.*');

// Route::get('/home/binaxtion', function () {
//     return view('home.binaxtion');
// });

// Route::get('/home/our_story', function () {
//     return view('home.our_story');
// });

// Route::get('/home/contact_us', function () {
//     return view('home.contact_us');
// });

// Route::get('/register', function () {
//     return view('web');
// })->where('any', '.*');

Route::get('/web{any}', function () {
    return view('web');
})->where('any', '.*');
