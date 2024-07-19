@extends('dashboard.partials.blank')

@section('maincontent')
<div class="container">
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
    <div class="row">
        <div class="col-sm-12 text-center">
            <h3>Category Creation</h3>
        </div>
    </div>
    <form action="/category" method="POST">
    @csrf
    <div class="row">
        <div class="col-sm-6 mt-2">
            <div class="form-group">
                <label for="catname">Name</label>
                <input type="text" class="form-control" id="catname" name="catname" placeholder="Category Name">
            </div>
        </div>
        <div class="col-sm-6 mt-2">
            <div class="form-group">
                <label for="parent">Parent Category</label>
                <select class="form-select" id="parent" name="parent" required>
                    <option>None</option>
                    <option value="0">Parent</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mt-2">
            <div class="form-group">
                <label for="subcategory">Sub Category</label>
                <select class="form-select form-control" id="subcategory" name="subcategory" required>
                    <option>None</option>
                    <option value="0">sub</option>
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
@endsection