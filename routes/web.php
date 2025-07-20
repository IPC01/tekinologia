<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\FinanceController;




Route::get('/',[FrontendController::class, 'index'])->name('frontend.index');
Route::get('/shop',[FrontendController::class, 'shop'])->name('frontend.shop');
Route::get('/about',[FrontendController::class, 'about'])->name('frontend.about');

Route::resource('frontend', FrontendController::class);


Route::get('/dashboard', [FrontendController::class, 'dash'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/updaterole', [ProfileController::class, 'updateRole'])->name('profile.updaterole');
    Route::get('/contract',[FrontendController::class, 'contract'])->name('frontend.contract');
    Route::get('/myorders',[OrderController::class, 'myorders'])->name('orders.myorders');

});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('settings', SettingController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/finance', [FinanceController::class, 'store'])->name('finance.store');



});

require __DIR__.'/auth.php';
