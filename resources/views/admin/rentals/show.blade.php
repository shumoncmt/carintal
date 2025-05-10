@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Rental Details #{{ $rental->id }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.rentals.edit', $rental) }}" class="btn btn-sm btn-outline-primary me-2">
            <i class="fas fa-edit"></i> Edit Status
        </a>
        <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Rentals
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Rental Information
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Customer Details:</h5>
                <p><strong>Name:</strong> {{ $rental->user->name }}</p>
                <p><strong>Email:</strong> {{ $rental->user->email }}</p>
                <p><strong>Phone:</strong> {{ $rental->user->phone_number ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <h5>Car Details:</h5>
                <p><strong>Name:</strong> {{ $rental->car->name }}</p>
                <p><strong>Brand:</strong> {{ $rental->car->brand }} {{ $rental->car->model }}</p>
                <p><strong>Type:</strong> {{ $rental->car->car_type }}</p>
                <p><strong>Daily Rate:</strong> ${{ number_format($rental->car->daily_rent_price, 2) }}</p>
            </div>
        </div>
        <hr>
        <h5>Booking Details:</h5>
        <p><strong>Rental Period:</strong> {{ $rental->start_date->format('M d, Y') }} to {{ $rental->end_date->format('M d, Y') }}</p>
        <p><strong>Duration:</strong> {{ $rental->start_date->diffInDays($rental->end_date) + 1 }} days</p>
        <p><strong>Total Cost:</strong> ${{ number_format($rental->total_cost, 2) }}</p>
        <p><strong>Status:</strong>
            <span class="badge
                @if($rental->status == 'Ongoing') bg-primary
                @elseif($rental->status == 'Completed') bg-success
                @elseif($rental->status == 'Canceled') bg-danger
                @else bg-secondary
                @endif">
                {{ $rental->status }}
            </span>
        </p>
        <p><strong>Booked On:</strong> {{ $rental->created_at->format('M d, Y H:i A') }}</p>
    </div>
</div>
@endsection