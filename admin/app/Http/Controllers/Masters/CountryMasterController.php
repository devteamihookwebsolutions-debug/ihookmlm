<?php

/**
 * This class contains public functions related to CountryMasterController
 *
 * @package         CountryMasterController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
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
