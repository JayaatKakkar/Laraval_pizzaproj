@extends('dashboard.partials.blank')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('maincontent')
<div class="container bg-grey">
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
<!-- <div class="row">
    @if(session()->has('data'))
    <h4>{{ session()->get('data.category_name') }}</h4>
    @endif
</div> -->
<div class="row mt-2">
        <div class="col-sm-6 align-self-center">
            <h3>{{session()->has('data')?'Update Category':'Category Creation'}}</h3>
        </div>
        <div class="col-sm-6 d-flex justify-content-end">
        <button class="btn  text-dark" type="button" data-toggle="collapse" data-target="#categorycol" aria-expanded="false" aria-controls="collapseExample" style="background: linear-gradient(to bottom, rgb(251 170 170 / 50%) 0%, rgb(247 247 247 / 0%) 100%);">
    Add Category
  </button>
        </div>
    </div>
<div class="collapse" id="categorycol">
   
    <form action="/category" id="catform" method="{{session()->has('data')?'PUT':'POST'}}">
    @csrf
    <div class="row">
        <div class="col-sm-6 mt-2">
            <div class="form-group">
                <label for="catname">Name</label>
                <input type="text" class="form-control" id="catname" name="catname" value="{{session()->has('data')?session()->get('data.category_name'):''}}" placeholder="Category Name">
            </div>
        </div>
        <div class="col-sm-6 mt-2">
            <div class="form-group">
                <label for="parent">Parent Category</label>
                <select class="form-select" id="parent" name="parent" required>
                    <option>None</option>
                    @if(session()->has('data') && is_null(session()->get('data.parent') ))
                    <option value="0" selected>Parent</option>
                    @else
                    <option value="0">Parent</option>
                    @endif
                    @foreach($parentCategories as $parentCategory)
                    @if(session()->has('data') && session()->get('data.parent')== $parentCategory->id )
                <option value="{{ $parentCategory->id }}" selected>{{ $parentCategory->category_name }}</option>
                    @else
                    <option value="{{ $parentCategory->id }}">{{ $parentCategory->category_name }}</option>
                    @endif
            @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mt-2">
            <div class="form-group">
                <label for="subcategory">Sub Category</label>
                <select class="form-select form-control" id="subcategory" name="subcategory" required>
                    <option>Choose</option>
                    <option value="0">None</option>
                  
                </select>
            </div>
        </div>
        <div class="col-sm-6 mt-2">
            <div class="form-group">
                <label for="desc">Category Description</label>
                <textarea class="form-control" id="desc" name="desc" placeholder="Describe" rows="4"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mt-2">
            <div class="row">
                <div class="col-sm-4">Available</div>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="rdbtn1" name="rdbtn" value="1">
                        <label class="form-check-label" for="rdbtn1">YES</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline float-left">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="0">
                        <label class="form-check-label" for="inlineCheckbox2">NO</label>
                    </div>
                </div>
            </div>
               
                
            </div>
        <div class="col-sm-6 mt-2">
           <button type="submit" name="subm" id="subm" class="btn btn-outline-primary">Submit</button>
        </div>
    </div>
    
    </form>
    </div>
</div>  
<div class="container mt-3 bg-white">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <table id="categorytab" class="table  table-striped table-hover nowrap" width="100%">
                <thead>
                    <th>S. No.</th>
                    <th>Category Name</th>
                    <th>category Description</th>
                    <th>Parent Category</th>
                    <th>Sub-Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>
            </table>
        </div>
    </div>
</div> 
@endsection