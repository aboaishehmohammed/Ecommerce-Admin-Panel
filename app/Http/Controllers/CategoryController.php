<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);
        $imageController = new ImageController();
        $image = $imageController->store($request);

        $category = Category::create(['name' => $request->name,
            'image_id' => $image->id
        ]);
        return $category->with('image')->get();
    }

    public function update(Request $request, $category)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        $category = Category::findorfail($category);

        if ($request->hasFile('image')) {
            $imageController = new ImageController();
            $image_id = $imageController->store($request)->id;
            $category->image_id = $image_id;
        }
        $category->update(['name' => $request->name,
            'image_id' => $category->image_id
        ]);
        return $category->get();
    }

    public function destroy($category)
    {
        Category::findorfail($category)->delete();
    }

    public function restore($category)
    {
        Category::onlyTrashed()->findOrFail($category)->restore();
    }

    public function ajaxAll()
    {

        return Category::all();
    }
    public function paginate()
    {

        return Category::orderby('created_at','desc')->paginate(10);
    }

    public function ajaxOne($category)
    {
        return Category::with(['subCategories'])->findorfail($category);
    }

    //
    public function index()
    {
        return view("admin.pages.categories");
    }
}
