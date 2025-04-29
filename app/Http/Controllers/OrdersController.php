<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Orders;
use App\Models\Service;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $queryOrders = Orders::query();

        if ($request->has('search') && $search != null && !empty($search)) {
            $queryOrders->whereHas('customer', function ($query) use ($search) {
                $query->where('customer_firstname', 'like', '%' . $search . '%')
                      ->orWhere('customer_lastname', 'like', '%' . $search . '%');
            });
        }

        $queryOrders->with(['customer','user']);

        if ($request->has('start_date') && $start_date != null && !empty($start_date)) {
            $queryOrders->where('created_at', '>=', $start_date);
        }

        if ($request->has('end_date') && $end_date != null && !empty($end_date)) {
            $queryOrders->where('created_at', '<=', $end_date);
        }

        $orders = $queryOrders->latest()->paginate(100);
        
        return view('orders.index',[
            "search" => $search,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "orders" => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::active()->get(); 
        $services = Service::active()->get();

        return view('orders.form',[
            "customers" => $customers,
            "services" => $services,
        ]);
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
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
