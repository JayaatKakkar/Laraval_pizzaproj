<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

Route::get('/', function () {
    return view('dashboard.dashboard');
});
Route::get('/category', function () {
    return view('dashboard.category');
});
Route::post('/category',function(){
    $category=new Category();
    $category->category_name= request('catname');
    $category->desc=request('desc') ;
    $category->parentcat=request('parent') !="0"?request('parent'): null;
    $category->subcat=request('subcategory') !="0"?request('subcategory'): null;
    $category->status=request('rdbtn');
    $category->save();

    return redirect()->back()->with('success', 'Inserted successfully');
});

