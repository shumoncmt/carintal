@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="text-center mb-4">About {{ config('app.name', 'Car Rental') }}</h1>
            <p class="lead text-center">
                Welcome to {{ config('app.name', 'Car Rental') }}, your premier destination for convenient and affordable car rentals.
                We are dedicated to providing you with a seamless rental experience, offering a wide variety of vehicles to suit
                all your travel needs.
            </p>

            <hr class="my-5">

            <div class="row">
                <div class="col-md-6 mb-4">
                    <h3>Our Mission</h3>
                    <p>
                        Our mission is to offer high-quality, reliable vehicles at competitive prices, backed by exceptional customer service.
                        Whether you're planning a business trip, a family vacation, or just need a temporary ride, we strive to make your
                        car rental process simple, fast, and enjoyable.
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <h3>Our Fleet</h3>
                    <p>
                        We boast a diverse fleet of cars, ranging from economical compact cars for city driving, comfortable sedans for
                        business travel, spacious SUVs for family adventures, to luxury vehicles for special occasions. All our cars
                        are regularly maintained and inspected to ensure your safety and comfort.
                    </p>
                </div>
            </div>

            <div class="text-center mt-4">
                <img src="{{ asset('images/about-us-team.jpg') }}" alt="Our Team" class="img-fluid rounded shadow" style="max-height: 300px;">
                {{-- You can download a generic team/office image and place it in public/images/about-us-team.jpg --}}
                <p class="mt-2 text-muted">Our dedicated team is here to assist you.</p>
            </div>

            <h3 class="mt-5 text-center">Why Rent With Us?</h3>
            <ul class="list-group list-group-flush mt-3">
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Wide range of vehicles</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Competitive and transparent pricing</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Easy online booking process</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Flexible rental periods</li>
                <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Commitment to customer satisfaction</li>
            </ul>

            <div class="text-center mt-5">
                <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg">Explore Our Cars</a>
            </div>
        </div>
    </div>
</div>
@endsection