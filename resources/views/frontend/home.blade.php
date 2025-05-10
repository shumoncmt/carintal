@extends('layouts.app')

@section('title', 'Welcome to CarGo Rentals')

@section('content')
<!-- Hero Section -->
<div class="container-fluid bg-light py-5 mb-5 text-center" style="background-image: url('{{ asset('images/hero-bg.jpg') }}'); background-size:cover; background-position: center; min-height: 400px; display: flex; align-items: center; justify-content: center;">
    <div class="p-5 rounded" style="background-color: rgba(0,0,0,0.5);">
        <h1 class="display-4 fw-bold text-white">Find Your Perfect Ride</h1>
        <p class="fs-5 text-white-50">Rent a car for your next adventure with ease and confidence.</p>
        <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg">Browse Cars</a>
    </div>
</div>
{{-- You can download a generic car rental hero image and place it in public/images/hero-bg.jpg --}}


<div class="container">
    <!-- Featured Cars Section -->
    <section class="featured-cars py-5">
        <h2 class="text-center mb-4">Featured Cars</h2>
        @if($featuredCars->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($featuredCars as $car)
                @include('frontend.cars._car_card', ['car' => $car])
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('cars.index') }}" class="btn btn-outline-primary">View All Cars</a>
        </div>
        @else
        <p class="text-center">No featured cars available at the moment. Check back soon!</p>
        @endif
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us py-5 bg-white">
        <h2 class="text-center mb-5">Why Choose Us?</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-car fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Wide Selection</h5>
                        <p class="card-text">Choose from a diverse fleet of well-maintained vehicles.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                 <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-dollar-sign fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Competitive Pricing</h5>
                        <p class="card-text">Get the best rates with no hidden fees. By Cash mode.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                 <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Excellent Support</h5>
                        <p class="card-text">24/7 customer support for a hassle-free experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection