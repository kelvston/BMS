<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    // Display list of invoices
    public function index()
    {
        $invoices = Invoice::with(['customer', 'issuedBy'])->get();
        dd($invoices);
        return view('invoices.index', compact('invoices'));
    }

    // Show invoice creation form
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('invoices.create', compact('customers', 'products'));
    }

    // Store new invoice
    public function store(Request $request)
{

    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'due_date' => 'required|date|after_or_equal:today',
        'tax_rate' => 'required|numeric|min:0|max:30',
        'discount' => 'nullable|numeric|min:0',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0'
    ]);

    // Calculate invoice totals
    $subtotal = collect($validated['items'])->sum(function($item) {
        return $item['price'] * $item['quantity'];
    });

    $taxAmount = $subtotal * ($validated['tax_rate'] / 100);
    $totalAmount = $subtotal + $taxAmount - ($validated['discount'] ?? 0);
    
    // Create invoice
    $invoice = Invoice::create([
        'invoice_number' => 'INV-' . now()->format('Ymd') . strtoupper(Str::random(4)),
        'customer_id' => $validated['customer_id'],
        'issued_by' => auth()->id(),
        'total_amount' => $totalAmount,
        'tax_amount' => $taxAmount,
        'discount' => $validated['discount'] ?? 0,
        'status' => 'unpaid',
        'due_date' => $validated['due_date']
    ]);

    // Add invoice items
    $invoice->items()->createMany($validated['items']);

    return redirect()->route('invoices.show', $invoice)
                   ->with('success', 'Invoice created successfully!');
}


    // Show invoice details
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items.product', 'issuedBy']);
        return view('invoices.show', compact('invoice'));
    }
    // Generate PDF
    public function generatePdf(Invoice $invoice)
    {
        $invoice->load(['customer', 'items.product']);
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-'.$invoice->invoice_number.'.pdf');
    }

    // Mark as paid
    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);
        return back()->with('success', 'Invoice marked as paid.');
    }
}