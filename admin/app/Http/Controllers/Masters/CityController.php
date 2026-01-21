<?php

/**
 * This class contains public functions related to CityController
 *
 * @package         CityController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
         $prefix = config('services.ihook.prefix');
        $request->validate([
            'country_id' => 'required|integer|exists:' . $prefix . '_country_master_table,country_master_id',
            'state_id' => 'required|integer|exists:' . $prefix . '_state_table,state_id',
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
         $prefix = config('services.ihook.prefix');
        $request->validate([
            'country_id' => 'required|integer|exists:' . $prefix . '_country_master_table,country_master_id',
            'state_id' => 'required|integer|exists:' . $prefix . '_state_table,state_id',
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
