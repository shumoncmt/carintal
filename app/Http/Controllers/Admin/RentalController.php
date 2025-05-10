<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user', 'car'])->latest()->paginate(10);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load(['user', 'car']);
        return view('admin.rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $rental->load(['user', 'car']);
        return view('admin.rentals.edit', compact('rental'));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'status' => 'required|string|in:Ongoing,Completed,Canceled',
            // Add other fields if admin needs to edit them, e.g., dates, cost (carefully)
        ]);

        $rental->update($request->only('status'));

        // Optionally, if status changes to Completed, update car availability if needed,
        // or send notification.

        return redirect()->route('admin.rentals.index')->with('success', 'Rental updated successfully.');
    }

    public function destroy(Rental $rental)
    {
        // Add logic here, e.g., can admin delete any rental?
        // Maybe only "Canceled" ones or for archival.
        // For now, direct delete.
        $rental->delete();
        return redirect()->route('admin.rentals.index')->with('success', 'Rental deleted successfully.');
    }
}