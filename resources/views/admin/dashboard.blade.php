@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Cars</h5>
                <p class="card-text fs-4">{{ $totalCars }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Available Cars</h5>
                <p class="card-text fs-4">{{ $availableCars }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Rentals</h5>
                <p class="card-text fs-4">{{ $activeOrCompletedRentals }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Total Earnings</h5>
                <p class="card-text fs-4">${{ number_format($totalEarnings, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<h2 class="mt-4">Recent Activity (Placeholder)</h2>
<p>Future: Add charts or lists of recent rentals/new cars.</p>
@endsection