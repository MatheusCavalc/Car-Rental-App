<?php

use App\Livewire\Pages\Index;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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

//Route::get('/', Index::class);
Volt::route('/', 'index')
    ->name('index');

Volt::route('/reserve/itinerary', 'pages.itinerary')
    ->name('itinerary');

Volt::route('/reserve/choose-vehicle', 'pages.choose-vehicle')
    ->middleware(['check.location.valid'])
    ->name('choose.vehicle');

//Auth/Dashboard routes
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
