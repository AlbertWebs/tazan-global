<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\InsightController as AdminInsightController;
use App\Http\Controllers\Admin\SiteContentController;
use App\Http\Controllers\InsightController;
use App\Models\Insight;
use App\Models\SiteContent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'content' => SiteContent::currentCopy(),
        'insights' => Insight::published()->latest('published_at')->limit(3)->get(),
    ]);
})->name('home');

Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{slug}', [InsightController::class, 'show'])->name('insights.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->middleware('auth')->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminInsightController::class, 'index'])->name('dashboard');
        Route::resource('/insights', AdminInsightController::class)->except('show');
        Route::get('/website', [SiteContentController::class, 'index'])->name('content.edit');
        Route::put('/website', [SiteContentController::class, 'update'])->name('content.update');
    });
});
