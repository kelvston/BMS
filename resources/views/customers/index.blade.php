@extends('layouts.app')

@section('title', 'Customer Management')

@section('content')
    <div class="glass-container rounded-xl shadow-2xl overflow-hidden backdrop-blur-lg border border-white/10">
        <div class="p-6 flex justify-between items-center bg-gradient-to-r from-cyan-900/30 to-indigo-900/20">
            <h1 class="text-2xl font-bold text-white">Customer Management</h1>
            <a href="{{ route('customers.create') }}"
               class="glow-btn bg-cyan-600/30 hover:bg-cyan-600/40 px-4 py-2 rounded-lg transition-all">
                + Add New Customer
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-cyan-800/30">
                <thead class="bg-gradient-to-r from-cyan-900/40 to-indigo-900/20">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-cyan-300">Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-cyan-300">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-cyan-300">Phone</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-cyan-300">Added By</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-cyan-300">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-cyan-800/20">
                @foreach($customers as $customer)
                    <tr class="hover:bg-cyan-900/10 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-cyan-100">{{ $customer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-cyan-100">{{ $customer->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-cyan-100">{{ $customer->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-cyan-200">{{ $customer->addedBy->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-4">
                                <a href="{{ route('customers.edit', $customer) }}"
                                   class="text-cyan-300 hover:text-cyan-100 transition-colors px-2 py-1 rounded-md hover:bg-cyan-900/20">
                                    Edit
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-400 hover:text-red-300 transition-colors px-2 py-1 rounded-md hover:bg-red-900/20"
                                            onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .glass-container {
            background: rgba(16, 24, 39, 0.6);
            backdrop-filter: blur(12px);
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
            transform: translateY(-1px);
        }

        table {
            border-spacing: 0 8px;
            border-collapse: separate;
        }

        th {
            backdrop-filter: blur(12px);
        }

        tr {
            background: rgba(255, 255, 255, 0.02);
        }
    </style>
@endsection
