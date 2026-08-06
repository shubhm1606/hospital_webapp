<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::all();
        return view('admin.agents.index', compact('agents'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:agents',
            'email' => 'required|email|unique:agents',
            'pan_card' => 'required|string|unique:agents',
            'password' => 'required|min:6',
        ]);

        Agent::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pan_card' => $request->pan_card,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:agents,phone,' . $id,
            'email' => 'required|email|unique:agents,email,' . $id,
            'pan_card' => 'required|string|unique:agents,pan_card,' . $id,
        ]);

        $agent->update($request->all());

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Agent::findOrFail($id)->delete();
        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = !$agent->status;
        $agent->save();

        return redirect()->route('agents.index')->with('success', 'Agent status updated successfully.');
    }
}
