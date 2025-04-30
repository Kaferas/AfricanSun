<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Orders;
use App\Models\OrdersDetails;
use App\Models\Service;
use App\Models\PayMode;
use App\Models\OrdersPayement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $orders = $queryOrders->whereNull('invoice_number')->latest()->paginate(100);
        
        return view('orders.index',[
            "search" => $search,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "orders" => $orders,
        ]);
    }

    public function indexInvoice(Request $request)
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
            $queryOrders->where('date_facturation', '>=', $start_date);
        }

        if ($request->has('end_date') && $end_date != null && !empty($end_date)) {
            $queryOrders->where('date_facturation', '<=', $end_date);
        }

        $orders = $queryOrders->whereNotNull('invoice_number')->latest()->paginate(100);
        
        return view('orders.invoices',[
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
            "orderDetails" => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            "customer_id" => "required",
            "sold_price" => "required|array",
            "sold_price.*" => "required|integer|min:1",
            "sold_qty" => "required|array",
            "sold_qty.*" => "required|integer|min:1",
        ],[
            "customer_id.required" => "Le Client est requis",
            "sold_price.required" => "vous devez choisir au moins un service",
            "sold_qty.required" => "vous devez choisir au moins un service",
            'sold_price.*.min' => "Le Prix vendue doit être superieur a 1.",
            'sold_qty.*.min' => 'La quantité vendue doit être superieur a 1.',
        ]);

        $orderDetails = [];

        if (!$validated->fails()) {

            $serviceId = $request->service_id;
            $serviceName = $request->service_name;
            $servicePrice = $request->service_price;
            $soldPrice = $request->sold_price;
            $soldQty = $request->sold_qty;

            $order = Orders::create([
                "order_code" => $this->generateOrderCode(),
                "customer_id" => $request->customer_id,
                "created_by" => auth()->user()->id,
            ]);

            if ($order) {
                for ($i=0; $i < count($serviceId); $i++) { 
                    array_push($orderDetails,[
                        "order_id" => $order->id,
                        "ref_order_code" => $order->order_code,
                        "service_id" => $serviceId[$i],
                        "service_name" => $serviceName[$i],
                        "service_price" => $servicePrice[$i],
                        "sold_qty" => floatval($soldQty[$i]),
                        "sold_price" => floatval($soldPrice[$i]),
                        "htva_price" => floatval($soldPrice[$i]),
                        "tva_price" => 0,
                        "created_by" => auth()->user()->id,
                        "created_at" => date('Y-m-d H:i:s')
                    ]);
                }

                OrdersDetails::insert($orderDetails);

                return response()->json(['success' => true, "messages" => "Commande créé avec succé"]);
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
    public function show(Orders $order)
    {
        $orderDetails = OrdersDetails::where('ref_order_code',$order->order_code)->get();
        $mode = PayMode::all();

        return view('orders.show',[
            "ordersDetails" => $orderDetails,
            "mode" => $mode,
            "orders" => $order,
        ]);  
    }

    public function showInvoice(Orders $order)
    {
        $orderDetails = OrdersDetails::where('ref_order_code',$order->order_code)->get();
        $mode = PayMode::all();

        return view('orders.showInvoice',[
            "ordersDetails" => $orderDetails,
            "mode" => $mode,
            "orders" => $order,
        ]);  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $order)
    {
        $customers = Customer::active()->get(); 
        $services = Service::active()->get();
        $orderDetails = OrdersDetails::where('ref_order_code',$order->order_code)->get();

        return view('orders.form',[
            "customers" => $customers,
            "services" => $services,
            "orderDetails" => $orderDetails,
            "orders" => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $order)
    {
        $validated = Validator::make($request->all(),[
            "customer_id" => "required",
            "sold_price" => "required|array",
            "sold_price.*" => "required|integer|min:1",
            "sold_qty" => "required|array",
            "sold_qty.*" => "required|integer|min:1",
        ],[
            "customer_id.required" => "Le Client est requis",
            "sold_price.required" => "vous devez choisir au moins un service",
            "sold_qty.required" => "vous devez choisir au moins un service",
            'sold_price.*.min' => "Le Prix vendue doit être superieur a 1.",
            'sold_qty.*.min' => 'La quantité vendue doit être superieur a 1.',
        ]);

        $orderDetails = [];

        if (!$validated->fails()) {

            $serviceId = $request->service_id;
            $serviceName = $request->service_name;
            $servicePrice = $request->service_price;
            $soldPrice = $request->sold_price;
            $soldQty = $request->sold_qty;

            $order->update([
                "customer_id" => $request->customer_id,
                "updated_by" => auth()->user()->id,
            ]);

            if ($order) {
                OrdersDetails::where('ref_order_code',$order->order_code)->delete();
                for ($i=0; $i < count($serviceId); $i++) { 
                    array_push($orderDetails,[
                        "order_id" => $order->id,
                        "ref_order_code" => $order->order_code,
                        "service_id" => $serviceId[$i],
                        "service_name" => $serviceName[$i],
                        "service_price" => $servicePrice[$i],
                        "sold_qty" => floatval($soldQty[$i]),
                        "sold_price" => floatval($soldPrice[$i]),
                        "htva_price" => floatval($soldPrice[$i]),
                        "tva_price" => 0,
                        "created_by" => auth()->user()->id,
                        "updated_by" => auth()->user()->id,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]);
                }

                OrdersDetails::insert($orderDetails);

                return response()->json(['success' => true, "messages" => "Commande modifié avec succé"]);
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
    public function destroy(Orders $order)
    {
        $status = $order->update([
            "order_delete_status" => 1,
            "deleted_by" => auth()->user()->id,
            "deleted_at" => date('Y-m-d'),
        ]);

        if ($status) {
            echo json_encode([
                'success' => true,
                'messages' => "Commande supprimé avec succé"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "messages" => ['error' => 'Erreur,veillez Réessayer svp!!']
            ]);
        }
    }

    public function validatePayment(Request $request){
        $validated = Validator::make($request->all(),[
            "mode" => "required",
            "price" => "required",
        ],[
            "mode.required" => "Le mode de Paiement est requis",
            "price.required" => "Le montant pour le Paiement est requis",
        ]);
        
        if (!$validated->fails()) {

            $invoice = $this->generateInvoiceCode();
            Orders::where('order_code',$request->order)->update([
                "invoice_number" => $invoice,
                "date_facturation" => date('Y-m-d'),
            ]);

            $pay = OrdersPayement::create([
                "invoice_number" => $invoice,
                "mode" => $request->mode,
                "price" => $request->price,
                "paid_by" => auth()->user()->id,
            ]);

            if ($pay) {
                return response()->json(['success' => true, "messages" => "Paiement ajouté avec succé"]);
                
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

    private function generateOrderCode()
    {
        $currentYear = date('Y');

        // Find the last order code for the current year
        $lastOrder = Orders::whereYear('created_at', $currentYear)
            ->orderBy('order_code', 'desc')
            ->first();

        if ($lastOrder) {
            // Extract the numeric part of the order code
            preg_match('/CN(\d{4})\/\d{4}/', $lastOrder->order_code, $matches);
            $lastCode = intval($matches[1]);
            $nextCode = $lastCode + 1;
        } else {
            // Start from 1 if no orders exist for the current year
            $nextCode = 1;
        }

        // Format the order code
        return sprintf('CN%04d/%d', $nextCode, $currentYear);
    }

    private function generateInvoiceCode()
    {
        $currentYear = date('Y');

        // Find the last order code for the current year
        $lastOrder = Orders::whereNotNull('invoice_number')->whereYear('created_at', $currentYear)
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastOrder) {
            // Extract the numeric part of the order code
            preg_match('/FN(\d{4})\/\d{4}/', $lastOrder->invoice_number, $matches);
            $lastCode = intval($matches[1]);
            $nextCode = $lastCode + 1;
        } else {
            // Start from 1 if no orders exist for the current year
            $nextCode = 1;
        }

        // Format the order code
        return sprintf('FN%04d/%d', $nextCode, $currentYear);
    }
}
