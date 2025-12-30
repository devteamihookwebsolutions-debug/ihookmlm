<?php

namespace Admin\App\Http\Controllers\Masters;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Masters\City;
use Admin\App\Models\Masters\CountryMaster;
use Admin\App\Models\Masters\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with(['country', 'state'])->get();
        return view('Masters.cities.index', compact('cities'));
    }

    public function create()
    {
        $countries = CountryMaster::all();
        $states = State::all();
        return view('Masters.cities.create', compact('countries', 'states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer|exists:ihook_country_master_table,country_master_id',
            'state_id' => 'required|integer|exists:ihook_state_table,state_id',
            'city_name' => 'required|string|max:250',
        ]);

        City::create($request->all());
        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function show(City $city)
    {
        $city->load(['country', 'state']);
        return view('Masters.cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        $countries = CountryMaster::all();
        $states = State::all();
        return view('Masters.cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'country_id' => 'required|integer|exists:ihook_country_master_table,country_master_id',
            'state_id' => 'required|integer|exists:ihook_state_table,state_id',
            'city_name' => 'required|string|max:250',
        ]);

        $city->update($request->all());
        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }
}
