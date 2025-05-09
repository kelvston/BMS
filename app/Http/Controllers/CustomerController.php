<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
  // Store new customer
  use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    // Display list of customers
    public function index()
    {
        $customers = Customer::with('addedBy')->get();
        return view('customers.index', compact('customers'));
    }

    // Show customer creation form
    public function create()
    {
        return view('customers.create');
    }

  

public function store(CustomerRequest $request)
{
    Customer::create($request->validated() + ['added_by' => auth()->id()]);
    return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
}

public function update(CustomerRequest $request, Customer $customer)
{
    $customer->update($request->validated());
    return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
}

    // Show customer edit form
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update customer
    // public function update(Request $request, Customer $customer)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:customers,email,'.$customer->id,
    //         'phone' => 'required|unique:customers,phone,'.$customer->id,
    //         'company_name' => 'nullable|string',
    //         'address' => 'nullable|string'
    //     ]);

    //     $customer->update($validated);
    //     return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    // }

    // Delete customer
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}