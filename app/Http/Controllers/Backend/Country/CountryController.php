<?php

namespace App\Http\Controllers\Backend\Country;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){
        return view('backend.country.index');
    }
    public function data(){
        $countries = Country::all();
        return response()->json($countries);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:countries,name'
        ]);
        $country = new Country();
        $country->name = $request->name;
        $country->status = 'Active';
        $country->save();
        return response()->json($country);
    }
    public function edit($id){
        $country = Country::find($id);
        return response()->json($country);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|unique:countries,name,'.$id
        ]);
        $country = Country::find($id);
        $country->name = $request->name;
        $country->update();
        return response()->json($country);
    }


}
