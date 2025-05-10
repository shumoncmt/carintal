<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCars = Car::count();
        $availableCars = Car::where('availability', true)
                            // ->whereDoesntHave('rentals', function ($query) { // More complex availability
                            //     $query->where('end_date', '>=', now())
                            //           ->where('status', '!=', 'Canceled');
                            // })
                            ->count(); // Simplified for now
        $totalRentals = Rental::count();
        $totalEarnings = Rental::where('status', 'Completed')->sum('total_cost');
        // More specific: total rentals that are ongoing or completed
        $activeOrCompletedRentals = Rental::whereIn('status', ['Ongoing', 'Completed'])->count();


        return view('admin.dashboard', compact('totalCars', 'availableCars', 'totalRentals', 'totalEarnings', 'activeOrCompletedRentals'));
    }
}