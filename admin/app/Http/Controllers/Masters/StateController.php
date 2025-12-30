<?php

namespace Admin\App\Http\Controllers\Masters;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Masters\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::with('country')->get();
        return view('Masters.states.index', compact('states'));
    }
    //  public function index( Request $request ) {
    //     $limit = $request->get( 'limit', 10 );
    //     $states = State::with( [ 'country' ] )->take( $limit )->get();

    //     return view( 'Masters.states.index', compact( 'states' ));
    // }

    public function create()
    {
        return view('Masters.states.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_code'   => 'required|string|max:500',
            'state_name'   => 'required|string|max:255',
            'country_code' => 'required|string|max:10',
        ]);

        State::create($request->all());

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State created successfully.');
    }

    public function show(State $state)
    {
        $state->load('country');
        return view('Masters.states.show', compact('state'));
    }

    public function edit(State $state)
    {
        return view('Masters.states.edit', compact('state'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'state_code'   => 'required|string|max:500',
            'state_name'   => 'required|string|max:255',
            'country_code' => 'required|string|max:10',
        ]);

        $state->update($request->all());

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        if ($state->cities()->exists()) {
            return redirect()
                ->route('admin.states.index')
                ->with('error', 'Cannot delete state because it has associated cities.');
        }

        $state->delete();

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State deleted successfully.');
    }
}
