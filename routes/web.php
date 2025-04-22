<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\Admin\DiagnosisController as AdminDiagnosisController;
use App\Models\Diagnosis;

/*
|--------------------------------------------------------------------------
| Debug route (optional)
|--------------------------------------------------------------------------
| Cek nilai config mail secara cepat
*/
Route::get('/_debug-mail', function () {
    return response()->json([
        'mailer'     => env('MAIL_MAILER'),
        'default'    => config('mail.default'),
        'host'       => config('mail.mailers.smtp.host'),
        'port'       => config('mail.mailers.smtp.port'),
        'username'   => config('mail.mailers.smtp.username'),
        'encryption' => config('mail.mailers.smtp.encryption'),
    ]);
});

/*
|--------------------------------------------------------------------------
| Auth routes (login, register, verify-email, etc.)
|--------------------------------------------------------------------------
| Ini mendaftarkan route:
| - register, login, forgot-password, reset-password
| - email verification routes: verification.notice, verification.verify, verification.send
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
| Hanya middleware auth (tidak perlu verifikasi email)
*/
Route::middleware('auth')
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         // Dashboard
         Route::get('dashboard', [AdminController::class, 'index'])
              ->name('dashboard');

         // Manage Users
         Route::get('users', [UserController::class, 'index'])
              ->name('users');
         Route::delete('users/{user}', [UserController::class, 'destroy'])
              ->name('users.destroy');

         // Lihat Diagnoses
         Route::get('diagnoses', [AdminDiagnosisController::class, 'index'])
              ->name('diagnoses');
     });

/*
|--------------------------------------------------------------------------
| User‐side routes
|--------------------------------------------------------------------------
| Harus login dan sudah verify email
*/
Route::middleware(['auth', 'verified'])
     ->group(function () {
         // Homepage
         Route::get('/', [HomepageController::class, 'index'])
              ->name('home');

         // Diagnosa Ikan
         Route::get('/diagnosis', [DiagnosisController::class, 'form'])
              ->name('diagnosis.form');
         Route::post('/diagnosis', [DiagnosisController::class, 'predict'])
              ->name('diagnosis.predict');
         Route::get('/diagnosis/result', [DiagnosisController::class, 'result'])
              ->name('diagnosis.result');
         Route::get('/diagnosis/recommendation/{disease}', [DiagnosisController::class, 'recommendation'])
              ->name('diagnosis.recommendation');

         // API kecil untuk classes
         Route::get('/diagnosis/classes', function () {
             $classes = Diagnosis::select('hasil_diagnosis')
                                 ->distinct()
                                 ->pluck('hasil_diagnosis');
             return response()->json($classes);
         });

         // Serve gambar upload original
         Route::get('/uploads/original/{filename}', function ($filename) {
             $path = storage_path('app/nilahealth-model/uploads/original/' . $filename);
             if (! file_exists($path)) {
                 abort(404);
             }
             return response()->file($path);
         });

         // Profile
         Route::get('/profile', [ProfileController::class, 'show'])
              ->name('profile.show');
         Route::get('/profile/edit', [ProfileController::class, 'edit'])
              ->name('profile.edit');
         Route::patch('/profile', [ProfileController::class, 'update'])
              ->name('profile.update');
         Route::delete('/profile', [ProfileController::class, 'destroy'])
              ->name('profile.destroy');
     });
