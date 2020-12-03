<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'category_id'=>'required|exists:Categories,id'
        ]);
        $imageController = new ImageController();
        $image=$imageController->store($request);

        $sub_category = SubCategory::create(['name' => $request->name,
            'category_id'=>$request->category_id,
            'image_id' => $image->id
        ]);

        return $sub_category->with('image')->get();
    }

    public function update(Request $request, $sub_category)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);
        $sub_category = SubCategory::findorfail($sub_category);

        if ($request->hasFile('image')) {
            $imageController = new ImageController();
            $image_id = $imageController->store($request)->id;
            $sub_category->image_id = $image_id;
        }
        $sub_category ->update(['name' => $request->name,
            'category_id'=>$request->category_id,
            'image_id' => $sub_category->image_id
        ]);
        return $sub_category->get();
    }

    public function destroy($sub_category)
    {
        SubCategory::findorfail($sub_category)->delete();
    }

    public function restore($sub_category)
    {
        SubCategory::onlyTrashed()->findOrFail($sub_category)->restore();
    }

    public function ajaxAll(){
        return SubCategory::with(['category'])->get();
    }

    public function ajaxOne($sub_category){
        return SubCategory::with(['products'])->with(['category'])->findorfail($sub_category);
    }
    public function index()
    {
        return view("admin.pages.sub-categories");
    }
    public function paginate(){
        return SubCategory::with(['category'])->paginate(2);
    }
    //
}
