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

        $customers = $customerQuery->active()->paginate(100);

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
        ],[
            "customer_firstname.required" => "Le nom est requis.",
            "customer_lastname.required" => "Le prénom est requis.",
            "customer_cni.required" => "Le numéro de CNI est requis.",
            "customer_phone.required" => "Le numéro de téléphone est requis.",
            "customer_province.required" => "La province est requise.",
            "customer_commune.required" => "La commune est requise.",
            "customer_zone.required" => "La zone est requise.",
            "customer_colline.required" => "La colline est requise.",
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
        $validatedData = $request->validate([
            'customer_firstname' => 'required|string|max:255',
            'customer_lastname' => 'required|string|max:255',
            'customer_cni' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_province' => 'required|string|max:255',
            'customer_commune' => 'required|string|max:255',
            'customer_zone' => 'required|string|max:255',
            'customer_colline' => 'required|string|max:255',
        ],[
            "customer_firstname.required" => "Le nom est requis.",
            "customer_lastname.required" => "Le prénom est requis.",
            "customer_cni.required" => "Le numéro de CNI est requis.",
            "customer_phone.required" => "Le numéro de téléphone est requis.",
            "customer_province.required" => "La province est requise.",
            "customer_commune.required" => "La commune est requise.",
            "customer_zone.required" => "La zone est requise.",
            "customer_colline.required" => "La colline est requise.",
        ]);

        $validatedData['updated_by'] = auth()->user()->id;

        $customer->update($validatedData);

        return redirect()->route('customer.index')->with('success', 'Client modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $status = $customer->update([
            'customer_status' => 1,
            'updated_by' => auth()->user()->id
        ]);
        if ($status) {
            echo json_encode(['success' => true, 'message' => 'Client supprimé avec succès.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du client.']);
        }
    }

    
}
