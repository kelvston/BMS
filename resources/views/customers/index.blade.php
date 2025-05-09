@extends('layouts.app')

@section('title', 'Customer Management')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Customer Management</h1>
        <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add New Customer
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Added By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($customers as $customer)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->addedBy->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('customers.edit', $customer) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection