<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('dashboard.dashboard');
});

// Category view page with parent dropdown 
Route::get('/category', [CategoryController::class,'parentCategory']);

// ........Subcategory dropdown ............
Route::get('/get-subcategories/{parentId}', [CategoryController::class, 'getSubcategories']);

// ............Category Insertion.............
Route::post('/category', [CategoryController::class, 'create']);

// ............Category View.............
Route::post("/viewcategory",[CategoryController::class, 'show']);

