<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorymodal;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
   public function parentCategory(){
    $parentCategories = Categorymodal::whereNull('parentcat')->get();
    // Return the view with the parent categories
    return view('dashboard.category', compact('parentCategories'));
   }
    // Method to fetch subcategories
    public function getSubcategories($parentId)
    {
        $subcategories = Categorymodal::where('parentcat', $parentId)->get();
        return response()->json($subcategories);
    }

    public function create(Request $request)
    {
        // // Validate the request data
        // $validatedData = $request->validate([
        //     'catname' => 'required|string|max:255',
        //     'desc' => 'nullable|string',
        //     'parent' => 'nullable|exists:categories,id',
        //     'subcategory' => 'nullable|exists:categories,id',
        //     'rdbtn' => 'required|in:1,2',
        // ]);

        // Create a new category instance and assign the validated data
        $category = new Categorymodal();
        $category->category_name = $request->input('catname');
        $category->desc = $request->input('desc');
        $category->parentcat = $request->input('parent') != "0" ? $request->input('parent') : null;
        $category->subcat = $request->input('subcategory') != "0" ? $request->input('subcategory') : null;
        $category->status = $request->input('rdbtn');
        $category->save();
    
        return redirect()->back()->with('success', 'Inserted successfully');
    }

    public function show(Request $request){
        $columnNames = [
            'main.id',
            'main.category_name',
            'desc',
            'parent.category_name',
            'sub.category_name',
            'main.status'
        ];
        $columnIndex = $request->input('order.0.column');
        $columnName = $columnNames[$columnIndex];
        $columnSortOrder = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');
        $start = $request->input('start');
        $length = $request->input('length');
        $categories = Categorymodal::all();

        $query = DB::table('categories as main')
        ->leftJoin('categories as parent', 'main.parentcat', '=', 'parent.id')
        ->leftJoin('categories as sub', 'main.subcat', '=', 'sub.id')
        ->select(
            'main.id as mid',
            'main.category_name',
            'main.desc',
            'parent.category_name as parent_cat',
            'sub.category_name as sub_cat',
            'main.status'
        );


        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('item.item_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('item.itemcode', 'like', '%' . $searchValue . '%')
                  ->orWhere('office.name', 'like', '%' . $searchValue . '%')
                  ->orWhere('off.name', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecords = $query->count();
        $data = $query->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($length)
            ->get();

            $arr1 = [];
            $id = 1;

            foreach ($data as $row) {
                $arraylist = [];
                $arraylist[] = $id;
                $arraylist[] = $row->category_name;
                $arraylist[] = $row->desc;
                $arraylist[] = $row->parent_cat;
                $arraylist[] = $row->sub_cat;
                $arraylist[] = $row->status;
                $arraylist[] = '<a href="#" name="updcat" class="pe-1 btn updcat" id="updcat" data-id="'.$row->mid.'"><i class="fa-regular fa-lg fa-pen-to-square" style="color: #000 ;"></i></a><a href="#" name="delcat" id="delcat" data-id="'.$row->mid.'" class="btn delcat"><i class="fa-solid fa-xl fa-trash-can" style="color: #000 ;"></i></a>';
    
                $arr1[] = $arraylist;
                $id++;
            }
    }

}
?>