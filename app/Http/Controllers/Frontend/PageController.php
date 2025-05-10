<?php

// app/Http/Controllers/Frontend/PageController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car; // For featured cars on homepage

class PageController extends Controller
{
    public function home()
    {
        // Example: Get a few recently added available cars for homepage
        $featuredCars = Car::where('availability', true)
                            ->latest()
                            ->take(6) // Show 6 featured cars
                            ->get();
        return view('frontend.home', compact('featuredCars'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}