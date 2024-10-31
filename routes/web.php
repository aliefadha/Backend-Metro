<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\EkskulController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SmartController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonyController;
use App\Http\Controllers\Pelatih\DataSiswaController;
use App\Http\Controllers\Siswa\InfoEkskulController;
use App\Http\Controllers\Siswa\InfoKriteriaController;
use App\Http\Controllers\Siswa\PemilihanEkskulController;
use App\Http\Controllers\Siswa\RiwayatPemilihanController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
})->name('login');


// Route::get('/', function () {
//     return view('auth.login');
// });
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::prefix('service')->group(function () {
        Route::get('/show', [ServiceController::class, 'index'])->name('service.show');
        Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
        Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::get('/destroy/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
    });
    Route::prefix('client')->group(function () {
        Route::get('/show', [ClientController::class, 'index'])->name('client.show');
        Route::post('/store', [ClientController::class, 'store'])->name('client.store');
        Route::post('/update/{id}', [ClientController::class, 'update'])->name('client.update');
        Route::get('/destroy/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
    });
    Route::prefix('project')->group(function () {
        Route::get('/show', [ProjectController::class, 'index'])->name('project.show');
        Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
        Route::post('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
        Route::get('/destroy/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
    });
    Route::prefix('team')->group(function () {
        Route::get('/show', [TeamController::class, 'index'])->name('team.show');
        Route::post('/store', [TeamController::class, 'store'])->name('team.store');
        Route::post('/update/{id}', [TeamController::class, 'update'])->name('team.update');
        Route::get('/destroy/{id}', [TeamController::class, 'destroy'])->name('team.destroy');
    });
    Route::prefix('skill')->group(function () {
        Route::get('/show', [SkillController::class, 'index'])->name('skill.show');
        Route::post('/store', [SkillController::class, 'store'])->name('skill.store');
        Route::post('/update/{id}', [SkillController::class, 'update'])->name('skill.update');
        Route::get('/destroy/{id}', [SkillController::class, 'destroy'])->name('skill.destroy');
    });
    Route::prefix('testimony')->group(function () {
        Route::get('/show', [TestimonyController::class, 'index'])->name('testimony.show');
        Route::post('/store', [TestimonyController::class, 'store'])->name('testimony.store');
        Route::post('/update/{id}', [TestimonyController::class, 'update'])->name('testimony.update');
        Route::get('/destroy/{id}', [TestimonyController::class, 'destroy'])->name('testimony.destroy');
    });
    Route::prefix('user')->group(function () {
        Route::get('/show', [UserController::class, 'index'])->name('user.show');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });
});

require __DIR__ . '/auth.php';
