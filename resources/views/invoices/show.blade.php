@extends('layouts.app')

@section('title', 'Invoice #' . $invoice->invoice_number)

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Invoice #{{ $invoice->invoice_number }}</h1>
        <a href="{{ route('invoices.pdf', $invoice) }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            Download PDF
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Invoice Header -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="font-semibold text-gray-700">Bill To:</h3>
                <p>{{ $invoice->customer->name }}</p>
                <p>{{ $invoice->customer->email }}</p>
                <p>{{ $invoice->customer->phone }}</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-gray-700">Invoice Details:</h3>
                <p>Date: {{ $invoice->created_at->format('M d, Y') }}</p>
                <p>Due Date: {{ $invoice->due_date->format('M d, Y') }}</p>
                <p>Status: 
                    <span class="px-2 py-1 rounded text-xs font-bold 
                        {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </p>
            </div>
            
            <div>
                <h3 class="font-semibold text-gray-700">Issued By:</h3>
                <p>{{ $invoice->issuedBy->name }}</p>
                <p>{{ $invoice->issuedBy->email }}</p>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($invoice->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($item->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Invoice Summary -->
        <div class="p-6 bg-gray-50">
            <div class="flex justify-end">
                <div class="w-64 space-y-2">
                    <div class="flex justify-between">
                        <span class="font-medium">Subtotal:</span>
                        <span>${{ number_format($invoice->total_amount - $invoice->tax_amount + $invoice->discount, 2) }}</span>
                    </div>
                    @if($invoice->discount > 0)
                    <div class="flex justify-between">
                        <span class="font-medium">Discount:</span>
                        <span>-${{ number_format($invoice->discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="font-medium">Tax ({{ $invoice->tax_rate }}%):</span>
                        <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                        <span class="font-bold">Total:</span>
                        <span class="font-bold">${{ number_format($invoice->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Actions -->
    <div class="mt-6 flex justify-end space-x-4">
        @if($invoice->status !== 'paid')
        <form action="{{ route('invoices.mark-paid', $invoice) }}" method="POST">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Mark as Paid
            </button>
        </form>
        @endif
        <a href="{{ route('invoices.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
            Back to Invoices
        </a>
    </div>
</div>
@endsection