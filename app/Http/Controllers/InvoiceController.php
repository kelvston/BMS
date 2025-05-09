<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    // Display list of invoices
    // app/Http/Controllers/InvoiceController.php
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:paid,unpaid',
            'sort' => 'sometimes|in:newest,oldest,due_date,amount',
            'from' => 'sometimes|date',
            'to' => 'sometimes|date|after_or_equal:from',
        ]);

        $invoices = Invoice::query()
            ->with(['customer', 'items'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->from && $request->to, function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->from)->startOfDay(),
                    Carbon::parse($request->to)->endOfDay()
                ]);
            })
            ->when($request->sort, function ($query, $sort) {
                switch ($sort) {
                    case 'newest':
                        return $query->latest();
                    case 'oldest':
                        return $query->oldest();
                    case 'due_date':
                        return $query->orderBy('due_date');
                    case 'amount':
                        return $query->orderByDesc('total_amount');
                }
            }, function ($query) {
                return $query->latest();
            })
            ->paginate(15)
            ->withQueryString();

        return view('invoices.index', [
            'invoices' => $invoices,
            'filters' => $validated
        ]);
    }

    // Show invoice creation form
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('invoices.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'tax_rate' => 'required|numeric|min:0|max:30',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:unpaid,paid,partial',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0'
        ]);

        $subtotal = collect($validated['items'])->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $taxAmount = $subtotal * ($validated['tax_rate'] / 100);
        $totalAmount = $subtotal + $taxAmount - ($validated['discount'] ?? 0);

        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . now()->format('YmdHis') . Str::random(6),
            'customer_id' => $validated['customer_id'],
            'issued_by' => auth()->id(),
            'total_amount' => $totalAmount,
            'tax_amount' => $taxAmount,
            'discount' => $validated['discount'] ?? 0,
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'invoice_date' => $validated['invoice_date'],
        ]);

        $itemsWithTotals = collect($validated['items'])->map(function ($item) {
            $item['total'] = $item['price'] * $item['quantity'];
            return $item;
        })->toArray();

        $invoice->items()->createMany($itemsWithTotals);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully!');
    }


    // Store new invoice
//    public function store(Request $request)
//{
//
//    $validated = $request->validate([
//        'customer_id' => 'required|exists:customers,id',
//        'invoice_date' => 'required|date',
//        'due_date' => 'required|date|after:invoice_date',
//        'tax_rate' => 'required|numeric|min:0|max:30',
//        'discount' => 'nullable|numeric|min:0',
//        'status' => 'required|in:unpaid,paid,partial',
//        'items' => 'required|array|min:1',
//        'items.*.product_id' => 'required|exists:products,id',
//        'items.*.quantity' => 'required|integer|min:1',
//        'items.*.price' => 'required|numeric|min:0'
//    ]);
//
//    // Calculate invoice totals
//    $subtotal = collect($validated['items'])->sum(function($item) {
//        return $item['price'] * $item['quantity'];
//    });
//
//    $taxAmount = $subtotal * ($validated['tax_rate'] / 100);
//    $totalAmount = $subtotal + $taxAmount - ($validated['discount'] ?? 0);
//
//    // Create invoice
//    $invoice = Invoice::create([
//        'invoice_number' => 'INV-'.now()->format('YmdHis').Str::random(6),
//        'customer_id' => $validated['customer_id'],
//        'issued_by' => auth()->id(),
//        'total_amount' => $totalAmount,
//        'tax_amount' => $taxAmount,
//        'discount' => $validated['discount'] ?? 0,
//        'status' => 'unpaid',
//        'due_date' => $validated['due_date']
//    ]);
//
//    // Add invoice items
//    $invoice->items()->createMany($validated['items'],'total'=>$totalAmount);
//
//    return redirect()->route('invoices.show', $invoice)
//                   ->with('success', 'Invoice created successfully!');
//}


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

        $invoice->load(['customer', 'items.product', 'issuedBy']);
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    // Mark as paid
    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);
        return back()->with('success', 'Invoice marked as paid.');
    }

    public function createQuickSale()
    {
        // Generate invoice number (adjust according to your numbering system)
        $lastInvoice = Invoice::latest()->first();
        $invoiceNumber = $lastInvoice ? 'INV-' . str_pad($lastInvoice->id + 1, 6, '0', STR_PAD_LEFT) : 'INV-000001';

        // Create draft invoice
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'customer_id' => null, // You can set a default customer if needed
            'due_date' => now()->addDays(30),
            'status' => 'unpaid',
            'issued_by' => auth()->id(),
            'tax_rate' => 0, // Default tax rate
        ]);

        return redirect()->route('invoices.edit', $invoice)
            ->with('success', 'Draft invoice created - add items and customer details');
    }
}
