<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Kit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $customer = $request->customer;
        
        $kitQuery = Kit::query();
        if ($request->has('search') && !empty($search)) {
            $kitQuery->where('kit_serial_number', 'like', '%' . $search . '%');
        }

        if ($request->has('customer') && !empty($customer)) {
            $kitQuery->where('customer_id',$customer);
        }
        $kitQuery->with(['customer','user']);

        $kits = $kitQuery->paginate(20);
        $customerList = Customer::active()->get();
            
        return view('kits.index', compact('kits','search','customer','customerList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'kit_serial_number' => 'required|string|unique:kits,kit_serial_number',
            'customer_id' => 'required|exists:customers,id',
        ],[
            'kit_serial_number.required' => 'Le numéro de série du kit est requis',
            'kit_serial_number.unique' => 'Ce numéro de série existe déjà',
            'customer_id.required' => 'Le client est requis',
            'customer_id.exists' => 'Le client sélectionné n\'existe pas'
        ]);

        if (!$validated->fails()) {
            $status = Kit::create([
                'kit_serial_number' => $request->kit_serial_number,
                'customer_id' => $request->customer_id,
                'created_by' => auth()->user()->id,
            ]);

            if ($status) {
                echo json_encode([
                    'success' => true,
                    'messages' => "Kit créé avec succé"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "messages" => ['error' => 'Erreur,veillez Réessayer svp!!']
                ]);
            }
            
        } else {
            echo json_encode([
                "success" => false,
                "messages" => $validated->errors()
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Kit $kit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kit $kit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kit $kit)
    {
        $validated = Validator::make($request->all(),[
            'kit_serial_number' => 'required|string|unique:kits,kit_serial_number,'.$kit->id,
            'customer_id' => 'required|exists:customers,id',
        ],[
            'kit_serial_number.required' => 'Le numéro de série du kit est requis',
            'kit_serial_number.unique' => 'Ce numéro de série existe déjà',
            'customer_id.required' => 'Le client est requis',
            'customer_id.exists' => 'Le client sélectionné n\'existe pas'
        ]);

        if (!$validated->fails()) {
            $status = $kit->update([
                'kit_serial_number' => $request->kit_serial_number,
                'customer_id' => $request->customer_id,
                'updated_by' => auth()->user()->id,
            ]);

            if ($status) {
                echo json_encode([
                    'success' => true,
                    'messages' => "Kit modifié avec succès"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "messages" => ['error' => 'Erreur, veuillez réessayer svp!']
                ]);
            }
            
        } else {
            echo json_encode([
                "success" => false,
                "messages" => $validated->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kit $kit)
    {
        $status = $kit->delete();

        if ($status) {
            echo json_encode([
                'success' => true,
                'messages' => "Kit supprimé avec succé"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "messages" => ['error' => 'Erreur,veillez Réessayer svp!!']
            ]);
        }
    }
}
