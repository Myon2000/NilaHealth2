<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    HomepageController,
    AdminController,
    UserController,
    DiagnosisController,
    Admin\DiagnosisController as AdminDiagnosisController,
    JadwalController,
    NotificationController,
    ArticleController,
    CommentController,
    Admin\ArticleController as AdminArticleController,
};
use App\Models\Diagnosis;

/*
|--------------------------------------------------------------------------
| Auth & Debug
|--------------------------------------------------------------------------
*/
Route::get('/_debug-mail', fn() => response()->json([
    'mailer'     => env('MAIL_MAILER'),
    'default'    => config('mail.default'),
    'host'       => config('mail.mailers.smtp.host'),
    'port'       => config('mail.mailers.smtp.port'),
    'username'   => config('mail.mailers.smtp.username'),
    'encryption' => config('mail.mailers.smtp.encryption'),
]));
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         Route::get('dashboard', [AdminController::class, 'index'])
              ->name('dashboard');
         Route::get('users', [UserController::class, 'index'])->name('users.index');
         Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
         Route::get('diagnoses', [AdminDiagnosisController::class, 'index'])
              ->name('diagnoses');
         Route::resource('articles', AdminArticleController::class);

     });

/*
|--------------------------------------------------------------------------
| User‐side Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified'])
     ->group(function () {

    // Homepage
    Route::get('/', [HomepageController::class, 'index'])->name('home');

    // Diagnosa
    Route::get('/diagnosis', [DiagnosisController::class, 'form'])->name('diagnosis.form');
    Route::post('/diagnosis', [DiagnosisController::class, 'predict'])->name('diagnosis.predict');
    Route::get('/diagnosis/result', [DiagnosisController::class, 'result'])->name('diagnosis.result');
    Route::get('/diagnosis/recommendation/{disease}', [DiagnosisController::class, 'recommendation'])
         ->name('diagnosis.recommendation');
    Route::get('/diagnosis/classes', fn() => response()->json(
        Diagnosis::distinct()->pluck('hasil_diagnosis')
    ));

    // Uploads
    Route::get('/uploads/original/{filename}', function($filename){
        $path = storage_path("app/nilahealth-model/uploads/original/$filename");
        abort_unless(file_exists($path), 404);
        return response()->file($path);
    });

    // Profile
    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile','show')->name('profile.show');
        Route::get('/profile/edit','edit')->name('profile.edit');
        Route::patch('/profile','update')->name('profile.update');
        Route::delete('/profile','destroy')->name('profile.destroy');
    });

    // Jadwal CRUD via AJAX (termasuk show)
    Route::post('/jadwal', [HomepageController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{jadwal}', [HomepageController::class, 'show'])->name('jadwal.show');
    Route::put('/jadwal/{jadwal}', [HomepageController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}', [HomepageController::class, 'destroy'])->name('jadwal.destroy');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::post('/articles/{article}/comments', [ArticleController::class, 'storeComment'])->name('articles.comments.store');

    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    // Notifications
//     Route::prefix('notifications')->name('notifications.')->group(function(){
//         Route::get('/','index');
//         Route::post('/{id}/mark-as-read','markAsRead')->withoutMiddleware('web');
//         Route::post('/mark-all-as-read','markAllAsRead')->withoutMiddleware('web');
//     });

});
