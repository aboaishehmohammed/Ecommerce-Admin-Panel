<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function getProductPrice($product)
    {
        return Product::findOrFail($product)->price;
    }

    public function updateProductQty($product, $qty)

    {
        $product = Product::findOrFail($product);
        $product->qty -= $qty;
        $product->update();
    }

    public function store(Request $request)
    {
        $request->validate([
            "products" => "required|array",
            "products.*.id" => "required",
            "products.*.qty" => "required|numeric",
            "address_id" => "required|numeric"
        ]);

        $order_status = false;

        $user_id = 2;

        $bill = Bill::create(
            [
                "user_id" => $user_id,
                "order_status" => $order_status,
                "address_id" => $request->address_id
            ]
        );

        $products = $request->products;
        for ($i = 0; $i < sizeof($products); $i++) {
            $bill->billProducts()->create(
                [
                    "qty" => $products[$i]['qty'],
                    "product_id" => $products[$i]['id'],
                    "price" => $this->getProductPrice($products[$i]['id'])
                ]
            );
            $this->updateProductQty($products[$i]['id'], $products[$i]['qty']);
        }

        return $bill;
    }

    public function destroy($bill)
    {
        Bill::findorfail($bill)->delete();
    }

    public function restore($bill)
    {
        Bill::onlyTrashed()->findOrFail($bill)->restore();
    }

    public function ajaxOne($bill)
    {
        $bills = Bill::with([
            "billProducts" => function ($q) {
                $q->with(["product" => function ($q) {
                    $q->with(['image']);
                }]);
            }

        ])->with(["user", "address" => function ($q) {
            $q->with(['city']);
        }])->findorfail($bill);
        return $bills;
    }

    public function orderDone($bill)
    {
        $bill = Bill::findorfail($bill);
        $bill->order_status = true;
        $bill->update();
    }

    public function paginate()
    {
        $bills = Bill::with(["billProducts" => function ($q) {
            $q->with(["product"]);
        }])->orderBy("created_at", 'desc')->paginate(20);
        return $bills;
    }

    public function report($str, Request $request)
    {

        $bills = BillProduct::whereHas("bill");

        switch ($str) {
            case 'daily':
                $date = $request->date;
                $bills->whereRaw(DB::raw("date(created_at)='{$date}'"));
                break;
            case 'monthly':
                $request->validate(["month" => "required|numeric", "year" => "required|numeric"]);
                $year = $request->year;
                $month = $request->month;
                $bills->whereRaw(DB::raw("year(date(created_at))=$year"));
                $bills->whereRaw(DB::raw("month(date(created_at))=$month"));
                break;
            case 'yearly':
                $request->validate(["year" => "required|numeric"]);
                $year = $request->year;
                $bills->whereRaw(DB::raw("year(date(created_at))=" . $year));
                break;
            default :
                return response("NO Content", 204);
        }
        $response = [];


        $response['bill_total'] = $bills->sum(DB::raw("price*qty"));
        $response['products'] = $bills->
        groupBy('product_id')
            ->selectRaw('sum(qty) as sum,product_id,(select name from products where id=product_id) as name')->get();

        return $response;

    }

    public function getProducts(Request $request)
    {
        $request->validate([
            "products_id" => "required|array"
        ]);

        $products_id = $request->products_id;

        return Product::whereIn("id", $products_id)->withTrashed()->get();

    }

    public function ajaxAll()
    {
        return Bill::with(['user'])->get();
    }

    public function index()
    {
        return view("admin.pages.bills");
    }

    public function indexReport()
    {
        return view("admin.pages.reports");
    }
    //
}
