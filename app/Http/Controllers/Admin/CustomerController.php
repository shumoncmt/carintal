<?php

// app/Http/Controllers/Admin/CustomerController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // For password updates

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        // Admin might create customer accounts
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email_verified_at' => now(), // Admin created, assume verified
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(User $customer) // Route model binding uses 'customer'
    {
        if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')->with('error', 'User is not a customer.');
        }
        $customer->load('rentals.car'); // Load rental history
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
         if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')->with('error', 'User is not a customer.');
        }
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
         if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')->with('error', 'User is not a customer.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone_number', 'address']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $customer)
    {
        if ($customer->role !== 'customer') {
            return redirect()->route('admin.customers.index')->with('error', 'User is not a customer.');
        }
        // Consider what happens to their rentals. Soft delete might be better.
        // Or prevent deletion if active rentals exist.
        if ($customer->rentals()->where('status', 'Ongoing')->exists()) {
             return redirect()->route('admin.customers.index')->with('error', 'Customer has ongoing rentals. Cannot delete.');
        }
        $customer->rentals()->delete(); // Or handle differently
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
