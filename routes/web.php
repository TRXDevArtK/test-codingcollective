<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('fastview');
    });

    Route::get('/livewire', function () {
        return view('livewireview');
    });

    Route::get('candidate', [CandidateController::class, 'get'])->name('candidate.get');
    Route::post('candidate', [CandidateController::class, 'store'])->name('candidate.store');
    Route::post('candidate/update', [CandidateController::class, 'update'])->name('candidate.update');
    Route::post('candidate/delete', [CandidateController::class, 'delete'])->name('candidate.delete');
});

Route::get('/login', [AuthController::class, 'redirOauth'])->name('login');
Route::get('/login/redir', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
