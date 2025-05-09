@extends('layouts.app')

@section('title', 'Invoices Pool')

@section('content')
    <div class="glass p-8 mx-auto max-w-7xl" style="transform-style: preserve-3d;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-3xl font-bold mb-4 md:mb-0 text-white">Invoices Pool</h1>

            <div class="flex gap-4">
                <a href="{{ route('invoices.create') }}"
                   class="glow-btn bg-cyan-600/30 hover:bg-cyan-600/40 px-4 py-2 rounded-lg transition-all">
                    Create New Invoice
                </a>

                <form action="{{ route('invoices.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <input type="text" name="search" placeholder="Search..."
                               class="glass-input w-full" value="{{ request('search') }}">
                    </div>

                    <div>
                        <select name="status" class="glass-select w-full">
                            <option value="">All Statuses</option>
                            @foreach(['paid', 'unpaid'] as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="sort" class="glass-select w-full">
                            <option value="">Sort By</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="due_date" {{ request('sort') === 'due_date' ? 'selected' : '' }}>Due Date</option>
                            <option value="amount" {{ request('sort') === 'amount' ? 'selected' : '' }}>Total Amount</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="glow-btn bg-cyan-600/30 hover:bg-cyan-600/40 w-full">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="glass-card p-6">
            <div class="grid grid-cols-1">
                <!-- Table Header -->
                <div class="hidden md:grid grid-cols-12 gap-4 p-3 bg-cyan-900/20 rounded-t-lg">
                    <div class="col-span-2 text-cyan-300 font-medium">Invoice #</div>
                    <div class="col-span-3 text-cyan-300 font-medium">Customer</div>
                    <div class="col-span-2 text-cyan-300 font-medium">Date</div>
                    <div class="col-span-2 text-cyan-300 font-medium">Due Date</div>
                    <div class="col-span-1 text-cyan-300 font-medium">Status</div>
                    <div class="col-span-2 text-cyan-300 font-medium text-right">Amount</div>
                </div>

                <!-- Table Body -->
                @forelse($invoices as $invoice)
                    <a href="{{ route('invoices.show', $invoice) }}"
                       class="group grid grid-cols-12 gap-4 p-3 hover:bg-cyan-900/10 transition-colors border-b border-cyan-900/30">
                        <div class="col-span-12 md:col-span-2 flex items-center">
                    <span class="text-white font-medium group-hover:text-cyan-300 transition-colors">
                        #{{ $invoice->invoice_number }}
                    </span>
                        </div>

                        <div class="col-span-12 md:col-span-3 flex items-center text-cyan-100">
                            {{ $invoice->customer->name ?? 'No Customer' }}
                        </div>

                        <div class="col-span-6 md:col-span-2 flex items-center text-cyan-100">
                            {{ $invoice->created_at->format('M d, Y') }}
                        </div>

                        <div class="col-span-6 md:col-span-2 flex items-center text-cyan-100">
                            {{ $invoice->due_date->format('M d, Y') }}
                        </div>

                        <div class="col-span-6 md:col-span-1 flex items-center">
                    <span class="px-2 py-1 rounded text-sm font-bold
                        {{ [
                            'paid' => 'bg-green-500/20 text-green-400',
                            'unpaid' => 'bg-red-500/20 text-red-400'
                        ][$invoice->status] }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                        </div>

                        <div class="col-span-6 md:col-span-2 flex items-center justify-end">
                    <span class="text-white font-medium group-hover:text-cyan-300 transition-colors">
                        ${{ number_format($invoice->total_amount, 2) }}
                    </span>
                        </div>
                    </a>
                @empty
                    <div class="p-6 text-center text-cyan-300">
                        No invoices found matching your criteria
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($invoices->hasPages())
                <div class="mt-6">
                    {{ $invoices->appends(request()->query())->links('vendor.pagination.glass') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .glass-form input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .glass-form input:focus {
            outline: none;
            border-color: rgba(6, 182, 212, 0.6);
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
        }

        @media (max-width: 768px) {
            .grid-cols-12 > div {
                col-span: 12;
            }

            .hidden-md {
                display: none;
            }

            .glass-form {
                width: 100%;
            }
        }
    </style>
@endsection
