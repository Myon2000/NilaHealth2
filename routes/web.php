<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiagnosisController;
use Illuminate\Support\Facades\Route;
use App\Models\Diagnosis;

Route::middleware('auth')->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('home');
    Route::get('/diagnosis', [DiagnosisController::class,'form']   )->name('diagnosis.form');
    Route::post('/diagnosis', [DiagnosisController::class,'predict'])->name('diagnosis.predict');
    Route::get('/diagnosis/result', [DiagnosisController::class,'result'] )->name('diagnosis.result');
    Route::get('/diagnosis/recommendation/{disease}', [DiagnosisController::class, 'recommendation'])->name('diagnosis.recommendation');
    Route::get('/diagnosis/classes', function () {
        // Ambil hasil diagnosis yang sudah ada di database
        $classes = Diagnosis::select('hasil_diagnosis')->distinct()->get()->pluck('hasil_diagnosis');
        
        return response()->json($classes);
    });

    Route::get('/uploads/original/{filename}', function ($filename) {
        $path = storage_path('app/nilahealth-model/uploads/original/' . $filename);
        if (file_exists($path)) {
            return response()->file($path);
        }
    
        abort(404);
    });


    // Admin area
    Route::prefix('admin')
         ->name('admin.')
         ->group(function () {
            Route::get('dashboard', [AdminController::class, 'index'])
                  ->name('dashboard');

            Route::get('users', [UserController::class, 'index'])
                  ->name('users');
            Route::delete('users/{user}', [UserController::class, 'destroy'])
                  ->name('users.destroy');
         });

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'show'])
         ->middleware(['auth'])
         ->name('profile.show');

});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
