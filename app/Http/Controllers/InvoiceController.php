<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
    
         $invoices = Invoice::with(['order', 'restaurantTable'])
        ->orderBy('created_at', 'asc')
        ->get();

         return response()->json([
          'data' => $invoices
    ]);
    }
    public function show(Invoice $invoice)
    {
        
        $invoice->load(['order', 'restaurantTable']);

        return response()->json([
            'message' => 'Invoice details displayed successfully.',
            'data'    => $invoice
        ], 200);
    }
}
