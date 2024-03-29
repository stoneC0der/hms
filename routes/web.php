<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::resources([
        'roomTypes' => 'RoomTypesManagementController',
        'rooms'     => 'RoomsManagementController',
        'tenants'   => 'TenantsManagementController',
        'rents'  => 'RentsManagementController',
    ]);

    Route::post('/rent/available-rooms', ['App\Http\Controllers\Admin\RentsManagementController','availableRooms'])->name('available-rooms');
});

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
