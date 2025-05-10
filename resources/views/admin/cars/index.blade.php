@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Cars</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.cars.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus"></i> Add New Car
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Type</th>
                <th>Price/Day</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cars as $car)
            <tr>
                <td>{{ $car->id }}</td>
                <td>
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" width="80">
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $car->name }}</td>
                <td>{{ $car->brand }}</td>
                <td>{{ $car->model }}</td>
                <td>{{ $car->car_type }}</td>
                <td>${{ number_format($car->daily_rent_price, 2) }}</td>
                <td>
                    <span class="badge {{ $car->availability ? 'bg-success' : 'bg-danger' }}">
                        {{ $car->availability ? 'Available' : 'Not Available' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this car?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No cars found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $cars->links() }}
@endsection