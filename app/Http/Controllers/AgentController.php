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
    {   $agents=Agent::orderBy('id','desc')->get();
        return view('agent.index',['agents'=>$agents]);
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

    public function getAgent(){
        $agent_id = $_POST['agent_id'];
        $agent = Agent::find($agent_id);
        return response()->json($agent);
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
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'commune' =>'required',
            'colline' =>'required',
            'zone' =>'required',
            'address' =>'required',
        ]);
        // dd($validated);
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
        $agent = Agent::findOrFail($id);
        $provinces = DB::select("SELECT distinct region from burundizipcodes");
        return view('agent.edit', compact('agent', 'provinces'));
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
