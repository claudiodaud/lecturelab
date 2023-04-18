<?php

use App\Http\Livewire\Irons\Irons;
use App\Http\Livewire\Lectures\Phosphorous;
use App\Http\Livewire\Roles\RoleIndex;
use App\Http\Livewire\Users\UserIndex;
use App\Http\Livewire\Volumetries\Volumetries;
use Illuminate\Support\Facades\DB;
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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {   
        return view('dashboard');
    })->name('dashboard');

    Route::get('/phosphorous', Phosphorous::class)->name('phosphorous');
    Route::get('/irons', Irons::class)->name('irons');
    Route::get('/volumetries', Volumetries::class)->name('volumetries');

    //Users - Roles and Permission Modules
    Route::get('/users-index', UserIndex::class)->name('users.index');
    Route::get('/roles-index', RoleIndex::class)->name('roles.index');

});


