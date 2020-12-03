<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {


        $request->validate([
            "name" => 'required|string|min:3|max:255',
            "description" => 'required|string|min:3',
            "qty" => 'required|min:1',
            "price" => 'required|numeric',
            "sub_category_id" => 'required',
            "photos" => "image|mimes:jpeg,png,jpg,svg"
        ]);
        $imageController = new ImageController();
        $image = $imageController->store($request);

        $product = Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "qty" => $request->qty,
            "sub_category_id" => $request->sub_category_id,
            'image_id' => $image->id
        ]);


        return Product::with(["subCategory"])->findOrFail($product->id);

    }

    public function update(Request $request, $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            "description" => 'required|string|min:3',
            'qty' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'sub_category_id' => 'required|exists:sub_categories,id'
        ]);
        $product = Product::findorfail($product);

        if ($request->hasFile('image')) {
            $imageController = new ImageController();
            $image_id = $imageController->store($request)->id;
            $product->image_id = $image_id;
        }
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            "description" => $request->description,
            "qty" => $request->qty,
            'sub_category_id' => $request->sub_category_id,
            'image_id' => $product->image_id
        ]);

        return Product::with(["subCategory"])->findOrFail($product->id);
    }

    public function destroy($product)
    {
        Product::findorfail($product)->delete();
    }

    public function restore($product)
    {
        Product::onlyTrashed()->findOrFail($product)->restore();
    }

    public function ajaxAll()
    {
        return Product::with(["subCategory"])->get();
    }

    public function paginate(Request $request)
    {
        $filtering = $request->type;
        switch ($filtering) {
            case 'high':
                return Product::with(["subCategory"])->orderBy('price', 'desc')->paginate(10);
            case 'low':
                return Product::with(["subCategory"])->orderBy('price', 'asc')->paginate(10);
            case 'sub_category':
                return Product::with(["subCategory"])->orderBy('sub_category_id', 'desc')->paginate(10);
            default:        return Product::with(["subCategory"])->paginate(10);

        }
    }

    public function getRandomProduct()
    {
        return Product::with(["subCategory"])->get();

    }

    public function ajaxOne($product)
    {
        return Product::with(["subCategory"])->findOrFail($product);
    }

    public function index()
    {
        return view("admin.pages.products");
    }

    //
    public function getProductsBySubCateogryPaginated($subCategory, Request $request)
    {
        switch ($request->sort) {

            case'low':
                return Product::with(["subCategory"])->orderBy('price', 'ASC')->where('sub_category_id', $subCategory)
                    ->paginate(10);

            case'high':
                return Product::with(["subCategory"])->orderBy('price', 'DESC')->where('sub_category_id', $subCategory)
                    ->paginate(10);

            case'name':
                return Product::with(["subCategory"])->orderBy('name', 'DESC')->where('sub_category_id', $subCategory)
                    ->paginate(10);

            case'qty':
                return Product::with(["subCategory"])->orderBy('qty', 'DESC')->where('sub_category_id', $subCategory)
                    ->paginate(10);


            default :
                return Product::with(["subCategory"])->where('sub_category_id', $subCategory)->paginate(10);
        }
    }


}
