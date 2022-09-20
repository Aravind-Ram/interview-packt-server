<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\ShopController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



use App\Http\Controllers\Api\V1\{
    GenreController,
    AuthorController,
    PublisherController,
    BookController
};

Route::prefix('v1')->group(function () {

    Route::resources([
        'genre' => GenreController::class,
        'author' => AuthorController::class,
        'publisher' => PublisherController::class,
        'book' => BookController::class,
    ], [
        'except' => ['create', 'edit']
    ]);

    Route::resource('gallery', GalleryController::class)->only(['index', 'store', 'show']);
    Route::get('genre-options', [GenreController::class, 'options']);
    Route::get('author-options', [AuthorController::class, 'options']);
    Route::get('publisher-options', [PublisherController::class, 'options']);
    Route::get('book-collections', [BookController::class, 'collections']);    
});

