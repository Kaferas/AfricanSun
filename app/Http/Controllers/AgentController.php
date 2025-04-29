<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return view('agent.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = DB::select("SELECT distinct region from burundizipcodes");
        return view('agent.create',compact('provinces'));
    }

    public function getCommuneOfProvince()
    {
        $province = $_POST['province'];
        $communes = DB::select("SELECT distinct district from burundizipcodes where region='" . $province . "'");
        return response()->json($communes);
    }



    public function QuartierOfCommune()
    {
        $commune = $_POST['commune'];
        $communes = DB::select("SELECT distinct city from burundizipcodes where district='" . $commune . "'");
        return response()->json($communes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'commune' => 'nullable|string|max:255',
            'colline' => 'nullable|string|max:255',
            'zone' => 'nullable|string|max:255',
        ]);
        // Assuming you have an Agent model
        Agent::create($validated);
        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
