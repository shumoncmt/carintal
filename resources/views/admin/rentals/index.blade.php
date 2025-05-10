@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Rentals</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Car</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rentals as $rental)
            <tr>
                <td>{{ $rental->id }}</td>
                <td>{{ $rental->user->name }}</td>
                <td>{{ $rental->car->name }} ({{ $rental->car->brand }})</td>
                <td>{{ $rental->start_date->format('Y-m-d') }}</td>
                <td>{{ $rental->end_date->format('Y-m-d') }}</td>
                <td>${{ number_format($rental->total_cost, 2) }}</td>
                <td>
                    <span class="badge
                        @if($rental->status == 'Ongoing') bg-primary
                        @elseif($rental->status == 'Completed') bg-success
                        @elseif($rental->status == 'Canceled') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ $rental->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.rentals.edit', $rental) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.rentals.destroy', $rental) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this rental record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No rentals found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $rentals->links() }}
@endsection