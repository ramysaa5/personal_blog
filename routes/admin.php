<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

Route::prefix('admin/')->name('admin.')->group(function () {
    Route::get('dashboard', [NewsController::class, 'dashboard'])->name('dashboard');


    Route::resource('articles', ArticleController::class);

    // tags
    Route::get('tags/trash', [TagController::class, 'trash'])->name('tags.trash');
    Route::get('tags/restore/{tag}', [TagController::class, 'restore'])->name('tags.restore');
    Route::delete('tags/forcedelete/{tag}', [TagController::class, 'forcedelete'])->name('tags.forcedelete');
    Route::resource('tags', TagController::class);

    // categories
    Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::get('categories/restore/{tag}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/forcedelete/{tag}', [CategoryController::class, 'forcedelete'])->name('categories.forcedelete');
    Route::resource('categories', CategoryController::class);
});
