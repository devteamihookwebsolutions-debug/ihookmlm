<?php

namespace Admin\App\Http\Controllers\Masters;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Masters\CountryMaster;
use Illuminate\Http\Request;

class CountryMasterController extends Controller
{
    public function index()
    {
        $countries = CountryMaster::all();
        return view('Masters.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('Masters.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sortname' => 'required|string|max:3',
            'country_master_name' => 'required|string|max:150',
        ]);

        CountryMaster::create($request->all());
        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function show(CountryMaster $country)
    {
        return view('Masters.countries.show', compact('country'));
    }

    public function edit(CountryMaster $country)
    {
        return view('Masters.countries.edit', compact('country'));
    }

    public function update(Request $request, CountryMaster $country)
    {
        $request->validate([
            'sortname' => 'required|string|max:3',
            'country_master_name' => 'required|string|max:150',
        ]);

        $country->update($request->all());
        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(CountryMaster $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
    