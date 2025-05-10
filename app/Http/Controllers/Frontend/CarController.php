<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::where('availability', true); // Only generally available cars

        // Filters
        if ($request->filled('car_type')) {
            $query->where('car_type', $request->car_type);
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->filled('min_price')) {
            $query->where('daily_rent_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('daily_rent_price', '<=', $request->max_price);
        }

        // Sorting
        $sort_by = $request->get('sort_by', 'created_at');
        $sort_direction = $request->get('sort_direction', 'desc');
        if (in_array($sort_by, ['name', 'brand', 'daily_rent_price', 'created_at']) && in_array($sort_direction, ['asc', 'desc'])) {
             $query->orderBy($sort_by, $sort_direction);
        } else {
            $query->latest(); // Default sort
        }

        $cars = $query->paginate(9)->withQueryString(); // withQueryString to keep filters in pagination links

        // For filter dropdowns
        $carTypes = Car::select('car_type')->distinct()->pluck('car_type');
        $brands = Car::select('brand')->distinct()->pluck('brand');

        return view('frontend.cars.index', compact('cars', 'carTypes', 'brands'));
    }

    public function show(Car $car)
    {
        if (!$car->availability) {
            // Optionally, you might still want to show it but indicate it's not rentable
            // return redirect()->route('cars.index')->with('error', 'This car is currently not available.');
        }
        // You might want to load related data or check specific availability for a default period
        return view('frontend.cars.show', compact('car'));
    }
}