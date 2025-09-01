<?php

namespace App\Http\Controllers\Backend\State;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        $countries = Country::all();
        return view('backend.state.index', compact('countries'));
    }

    public function data(){
        $states = State::with('country')->get();
        return response()->json($states);
    }

    public function store(Request $request){
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:100',
        ]);

        $state = new State();
        $state->country_id = $request->country_id;
        $state->name = $request->name;
        $state->save();
        return response()->json($state);
    }

    public function edit($id){
        $state = State::find($id);
        return response()->json($state);
    }

    public function update(Request $request, $id){
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:100',
        ]);

        $state = State::find($id);
        $state->country_id = $request->country_id;
        $state->name = $request->name;
        $state->update();
        return response()->json($state);
    }

    public function delete($id){
        $state = State::find($id);
        $state->delete();
        return response()->json($state);
    }

    public function getState($country_id){
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }
}
