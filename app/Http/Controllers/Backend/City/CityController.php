<?php

namespace App\Http\Controllers\Backend\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class CityController extends Controller
{
    public function index(){
        $countries = Country::all();
        return view('backend.city.index', compact('countries'));
    }

    public function data(){
        $cities = City::with(['state','country'])->get();
        return response()->json($cities);
    }

    public function store(Request $request){
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:100',
        ]);

        $city = new City();
        $city->country_id = $request->country_id;
        $city->state_id = $request->state_id;
        $city->name = $request->name;
        $city->save();
        return response()->json($city);
    }

    public function edit($id){
        $city = City::find($id);
        return response()->json($city);
    }

        public function update(Request $request, $id){
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:100',
        ]);

        $city = City::find($id);
        $city->country_id = $request->country_id;
        $city->state_id = $request->state_id;
        $city->name = $request->name;
        $city->save();
        return response()->json($city);
    }

    public function delete($id){
        $city = City::find($id);
        $city->delete();
        return response()->json($city);
    }
}
