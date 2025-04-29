<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $serviceQuery = Service::query();

        if ($request->has('search') && !empty($search)) {
            $serviceQuery = $serviceQuery->where('service_name', 'LIKE', "%$search%");
        }

        $services = $serviceQuery->active()->get();

        return view('service.index',[
            "search" => $search,
            "services" => $services
        ]);
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
            "service_name" => "required",
            "service_price" => "required",
            "service_duration" => "required",
        ],[
            "service_name.required" => "Le Nom du service est requis",
            "service_price.required" => "Le Prix du service est requis",
            "service_duration.required" => "La Garatie du service est requis",
        ]);

        if (!$validated->fails()) {
            $service = Service::create([
                "service_name" => $request->service_name,
                "service_price" => $request->service_price,
                "service_duration" => $request->service_duration,
                "service_description" => $request->service_description,
                "created_by" => auth()->user()->id
            ]);

            if ($service) {
                echo json_encode([
                    'success' => true,
                    'messages' => "Service créé avec succé"
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
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = Validator::make($request->all(),[
            "service_name" => "required",
            "service_price" => "required",
            "service_duration" => "required",
        ],[
            "service_name.required" => "Le Nom du service est requis",
            "service_price.required" => "Le Prix du service est requis",
            "service_duration.required" => "La Garatie du service est requis",
        ]);

        if (!$validated->fails()) {
            $service = $service->update([
                "service_name" => $request->service_name,
                "service_price" => $request->service_price,
                "service_duration" => $request->service_duration,
                "service_description" => $request->service_description,
                "updated_by" => auth()->user()->id
            ]);

            if ($service) {
                echo json_encode([
                    'success' => true,
                    'messages' => "Service modifié avec succé"
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
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $status = $service->update(["service_status" => 1]);

        if ($status) {
            echo json_encode([
                'success' => true,
                'messages' => "Service supprimé avec succé"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "messages" => ['error' => 'Erreur,veillez Réessayer svp!!']
            ]);
        }
        
    }
}
