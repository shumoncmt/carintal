@extends('layouts.app')

@section('title', $car->name . ' - Car Details')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow-sm mb-4">
                @if($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->name }}" style="max-height: 450px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/800x450.png?text=No+Image" class="card-img-top" alt="No image available">
                @endif
                <div class="card-body">
                    <h2 class="card-title">{{ $car->name }}</h2>
                    <p class="text-muted fs-5">{{ $car->brand }} - {{ $car->model }} ({{ $car->year }})</p>
                    <hr>
                    <p><strong>Type:</strong> {{ $car->car_type }}</p>
                    <p><strong>Year:</strong> {{ $car->year }}</p>
                    <p><strong>General Status:</strong>
                        <span class="badge {{ $car->availability ? 'bg-success' : 'bg-danger' }}">
                            {{ $car->availability ? 'Available for Booking consideration' : 'Currently Not Available' }}
                        </span>
                    </p>
                    <p class="mt-3"><strong>Description:</strong></p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        (Replace with actual car description if you add it to the model/DB)
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Book This Car</h4>
                </div>
                <div class="card-body">
                    <p class="h3 text-primary mb-3">${{ number_format($car->daily_rent_price, 2) }} <small class="text-muted fs-6">/ day</small></p>

                    @if(!$car->availability)
                        <div class="alert alert-warning">This car is marked as generally unavailable by the admin. Booking might not be possible.</div>
                    @endif

                    @auth
                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Rental Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">Rental End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg" {{ !$car->availability ? 'disabled' : '' }}>Book Now (Pay on Pickup)</button>
                            </div>
                            <p class="text-muted text-center mt-2"><small>Payment will be collected upon car pickup.</small></p>
                        </form>
                    @else
                        <div class="alert alert-info">
                            Please <a href="{{ route('login', ['redirect' => url()->current()]) }}">login</a> or <a href="{{ route('register', ['redirect' => url()->current()]) }}">sign up</a> to book a car.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Basic date validation: end_date cannot be before start_date
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                endDateInput.min = this.value;
                if (endDateInput.value < this.value) {
                    endDateInput.value = this.value;
                }
            }
        });
    }
</script>
@endpush