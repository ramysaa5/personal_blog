<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

Route::middleware('auth', 'is_admin:admin')->prefix('admin/')->name('admin.')->group(function () {
    Route::get('/', [NewsController::class, 'dashboard']);
    Route::get('dashboard', [NewsController::class, 'dashboard'])->name('dashboard');

    // article
    Route::get('articles/trash', [ArticleController::class, 'trash'])->name('articles.trash');
    Route::get('articles/restore/{article}', [ArticleController::class, 'restore'])->name('articles.restore');
    Route::delete('articles/forcedelete/{article}', [ArticleController::class, 'forcedelete'])->name('articles.forcedelete');
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
