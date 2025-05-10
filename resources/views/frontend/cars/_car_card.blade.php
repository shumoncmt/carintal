{{-- resources/views/frontend/cars/_car_card.blade.php --}}
<div class="col">
    <div class="card h-100 shadow-sm">
        @if($car->image)
            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->name }}" style="height: 200px; object-fit: cover;">
        @else
            <img src="https://via.placeholder.com/400x200.png?text=No+Image" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
        @endif
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $car->name }}</h5>
            <p class="card-text text-muted">{{ $car->brand }} - {{ $car->model }} ({{ $car->year }})</p>
            <ul class="list-unstyled mt-2 mb-3">
                <li><i class="fas fa-car-side me-2 text-primary"></i>Type: {{ $car->car_type }}</li>
                <li><i class="fas fa-palette me-2 text-primary"></i>Availability:
                    <span class="badge {{ $car->availability ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }}">
                        {{ $car->availability ? 'Available' : 'Not Available Now' }}
                    </span>
                     {{-- Note: This 'availability' is the general car status. Specific date availability is checked on booking. --}}
                </li>
            </ul>
            <div class="mt-auto">
                <p class="card-text h5 text-primary">${{ number_format($car->daily_rent_price, 2) }} <small class="text-muted">/ day</small></p>
                <a href="{{ route('cars.show', $car) }}" class="btn btn-primary w-100">View Details & Book</a>
            </div>
        </div>
    </div>
</div>