<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'address' => 'required|string|min:3|max:255',
            'mobile' => 'required|string|min:3|max:20',
            'label' => 'required|string|min:3|max:20',
            'city_id' => 'required'

        ]);
        return Address::create(
            [
                "user_id"=>2,
                "address" => $request->address,
                "mobile" => $request->mobile,
                "label" => $request->label,
                "city_id" => $request->city_id,
            ]
        );

    }

    public function ajaxAll($user_id){

       return Address::with(['city'])->where('user_id',$user_id)->get();
    }

    public function getCities(){

        return City::all();
    }



    //
}
