@extends('layouts.app')

@section('title', 'Invoice #' . $invoice->invoice_number)

@section('content')
    <div class="glass-container rounded-xl shadow-2xl p-8 mx-auto max-w-7xl backdrop-blur-lg border border-white/10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-white bg-clip-text text-transparent">
                Invoice #{{ $invoice->invoice_number }}
            </h1>
            <a href="{{ route('invoices.pdf', $invoice) }}"
               class="glow-btn bg-cyan-600/30 hover:bg-cyan-600/40 px-4 py-2 rounded-lg transition-all">
                Download PDF
            </a>
        </div>

        <div class="glass-card p-6 space-y-6">
            <!-- Invoice Header -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-card p-4">
                    <h3 class="text-cyan-300 font-semibold mb-2">Bill To:</h3>
                    <p class="text-cyan-100">{{ $invoice->customer->name }}</p>
                    <p class="text-cyan-100">{{ $invoice->customer->email }}</p>
                    <p class="text-cyan-100">{{ $invoice->customer->phone }}</p>
                </div>

                <div class="glass-card p-4">
                    <h3 class="text-cyan-300 font-semibold mb-2">Invoice Details:</h3>
                    <p class="text-cyan-100">Date: {{ $invoice->created_at->format('M d, Y') }}</p>
                    <p class="text-cyan-100">Due Date: {{ $invoice->due_date->format('M d, Y') }}</p>
                    <p class="text-cyan-100">Status:
                        <span class="px-2 py-1 rounded text-sm font-bold
                        {{ $invoice->status === 'paid' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                    </p>
                </div>

                <div class="glass-card p-4">
                    <h3 class="text-cyan-300 font-semibold mb-2">Issued By:</h3>
                    <p class="text-cyan-100">{{ $invoice->issuedBy->name }}</p>
                    <p class="text-cyan-100">{{ $invoice->issuedBy->email }}</p>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="glass-card p-4">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-cyan-900/40 to-indigo-900/20">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-cyan-300">Item</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-cyan-300">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-cyan-300">Qty</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-cyan-300">Total</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-cyan-800/30">
                    @foreach($invoice->items as $item)
                        <tr class="hover:bg-cyan-900/10 transition-colors">
                            <td class="px-4 py-3 text-cyan-100">{{ $item->product->name }}</td>
                            <td class="px-4 py-3 text-cyan-100">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-3 text-cyan-100">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-cyan-100">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Invoice Summary -->
            <div class="glass-card p-6">
                <div class="flex justify-end">
                    <div class="w-72 space-y-3">
                        <div class="flex justify-between text-cyan-100">
                            <span>Subtotal:</span>
                            <span>${{ number_format($invoice->subtotal, 2) }}</span>
                        </div>
                        @if($invoice->discount > 0)
                            <div class="flex justify-between text-cyan-100">
                                <span>Discount:</span>
                                <span>-${{ number_format($invoice->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-cyan-100">
                            <span>Tax ({{ $invoice->tax_rate }}%):</span>
                            <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-cyan-800/40 pt-3 mt-2 text-white font-bold">
                            <span>Total:</span>
                            <span>${{ number_format($invoice->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Actions -->
        <div class="mt-8 flex justify-end space-x-4">
            @if($invoice->status !== 'paid')
                <form action="#" method="POST">
                    @csrf
                    <button type="submit"
                            class="glow-btn bg-green-600/30 hover:bg-green-600/40 px-4 py-2 rounded-lg transition-all">
                        Mark as Paid
                    </button>
                </form>
            @endif
            <a href="{{ route('invoices.index') }}"
               class="glass-btn-secondary px-4 py-2 rounded-lg transition-all">
                Back to Invoices
            </a>
        </div>
    </div>

    <style>
        .glass-container {
            background: rgba(16, 24, 39, 0.8);
            backdrop-filter: blur(12px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            backdrop-filter: blur(8px);
        }

        .glow-btn {
            background: rgba(6, 182, 212, 0.15);
            border: 1px solid rgba(6, 182, 212, 0.3);
            color: #a5f3fc;
            transition: all 0.3s ease;
        }

        .glow-btn:hover {
            border-color: rgba(6, 182, 212, 0.6);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);
        }

        .glass-btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
    </style>
@endsection
