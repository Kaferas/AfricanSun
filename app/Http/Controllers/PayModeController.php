<?php

namespace App\Http\Controllers;

use App\Models\PayMode;
use Illuminate\Http\Request;

class PayModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payModes = PayMode::orderBy('id', 'desc')->with("creator")->get();
        return view('paymode.index',[
                'payModes' => $payModes,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('paymode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated= $request->validate([
            'paymode_name' => 'required|string|max:255',
            'paymode_account' => 'required|string|max:255',
        ],[
            'paymode_name.required' => 'Mode de paiement est requis.',
            'paymode_account.required' => 'Numero de Compte requis.',
        ]);

        PayMode::create([
            'created_by' => auth()->user()->id,
            'paymode_name' => $request->paymode_name,
            'paymode_account' => $request->paymode_account,
        ]);

        return redirect()->route('payMode.index')->with('success', 'Payment mode created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PayMode $payMode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PayMode $payMode)
    {
        return view('paymode.edit', [
            'payMode' => $payMode,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PayMode $payMode)
    {
        $validated= $request->validate([
            'paymode_name' => 'required|string|max:255',
            'paymode_account' => 'required|string|max:255',
        ],[
            'paymode_name.required' => 'Mode de paiement est requis.',
            'paymode_account.required' => 'Numero de Compte requis.',
        ]);

        $payMode->update([
            'paymode_name' => $request->paymode_name,
            'paymode_account' => $request->paymode_account,
        ]);

        return redirect()->route('payMode.index')->with('success', 'Payment mode updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayMode $payMode)
    {
        $payMode->delete();
        return redirect()->route('payMode.index')->with('success', 'Payment mode deleted successfully.');
    }
}
