<?php

use App\Http\Controllers\Admin\MhController;
use Illuminate\Support\Facades\Route;

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

Route::get('/mhs/{mh}/show', 'App\Http\Controllers\Admin\MhController@show');

Route::get('export/', [MhController::class, 'export']);

Route::get('exportar/', [MhController::class, 'exportar']);

Route::get('exportarExcel/', [MhController::class, 'exportExcel']);
//Route::get('export', [\App\Http\Controllers\Admin\MhController::class, 'export']);

//Route::get('export/', 'MhController@export')->name('excel');

//Route::get('/export', 'MhController@export');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('mhs')->name('mhs/')->group(static function() {
            Route::get('/',                                             'MhController@index')->name('index');
            Route::get('/create',                                       'MhController@create')->name('create');
            Route::post('/',                                            'MhController@store')->name('store');
            Route::get('/{mh}/edit',                                    'MhController@edit')->name('edit');
            Route::get('/{mh}/show',                                    'MhController@show');
            Route::post('/bulk-destroy',                                'MhController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{mh}',                                        'MhController@update')->name('update');
            Route::delete('/{mh}',                                      'MhController@destroy')->name('destroy');

        });
    });
});
