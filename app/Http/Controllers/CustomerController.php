<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $province = $request->province;
        $commune = $request->commune;

        $customerQuery = Customer::query();

        if ($request->has('search') && !empty($search)) {
            $customerQuery = $customerQuery->where('customer_firstname','LIKE',"%$search%")
                                ->orWhere('customer_lastname', 'like', '%' . $search . '%');
        }

        if ($request->has('province') && !empty($province)) {
            $customerQuery = $customerQuery->where('customer_province',$province);
        }

        if ($request->has('commune') && !empty($commune)) {
            $customerQuery = $customerQuery->where('customer_commune',$commune);
        }

        $customers = $customerQuery->paginate(100);

        return view('customer.index',[
            'customers' => $customers,
            'search' => $search,
            'province' => $province,
            'commune' => $commune,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = DB::select("SELECT distinct region from burundizipcodes");
        return view('customer.form',['provinces' => $provinces]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_firstname' => 'required|string|max:255',
            'customer_lastname' => 'required|string|max:255',
            'customer_cni' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_province' => 'required|string|max:255',
            'customer_commune' => 'required|string|max:255',
            'customer_zone' => 'required|string|max:255',
            'customer_colline' => 'required|string|max:255',
        ]);

        $validatedData['created_by'] = auth()->user()->id;
        $validatedData['customer_status'] = 0;

        Customer::create($validatedData);

        return redirect()->route('customer.index')->with('success', 'Client créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $provinces = DB::select("SELECT distinct region from burundizipcodes");
        return view('customer.form',['provinces' => $provinces,'customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    
}
