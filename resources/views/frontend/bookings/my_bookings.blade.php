@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Rental History</h1>

    @if($bookings->count() > 0)
        <div class="table-responsive shadow-sm">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Car</th>
                        <th>Image</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Booked On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>#{{ $booking->id }}</td>
                        <td>
                            <a href="{{ route('cars.show', $booking->car) }}">{{ $booking->car->name }}</a><br>
                            <small class="text-muted">{{ $booking->car->brand }} {{ $booking->car->model }}</small>
                        </td>
                        <td>
                            @if($booking->car->image)
                                <img src="{{ asset('storage/' . $booking->car->image) }}" alt="{{ $booking->car->name }}" width="100" class="img-thumbnail">
                            @else
                                <img src="https://via.placeholder.com/100x60.png?text=No+Image" alt="No image" width="100" class="img-thumbnail">
                            @endif
                        </td>
                        <td>{{ $booking->start_date->format('M d, Y') }}</td>
                        <td>{{ $booking->end_date->format('M d, Y') }}</td>
                        <td>${{ number_format($booking->total_cost, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($booking->status == 'Ongoing') bg-primary
                                @elseif($booking->status == 'Completed') bg-success
                                @elseif($booking->status == 'Canceled') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td>{{ $booking->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($booking->status == 'Ongoing' && \Carbon\Carbon::parse($booking->start_date)->isFuture())
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                </form>
                            @elseif($booking->status == 'Canceled')
                                <span class="text-muted">-</span>
                            @else
                                 <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            You have no bookings yet. <a href="{{ route('cars.index') }}">Find a car to rent!</a>
        </div>
    @endif
</div>
@endsection