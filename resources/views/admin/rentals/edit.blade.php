@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Rental #{{ $rental->id }}</h1>
    <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Rentals
    </a>
</div>

<div class="card">
    <div class="card-header">Rental Details</div>
    <div class="card-body">
        <p><strong>Customer:</strong> {{ $rental->user->name }} ({{ $rental->user->email }})</p>
        <p><strong>Car:</strong> {{ $rental->car->name }} - {{ $rental->car->brand }} {{ $rental->car->model }}</p>
        <p><strong>Rental Period:</strong> {{ $rental->start_date->format('M d, Y') }} to {{ $rental->end_date->format('M d, Y') }}</p>
        <p><strong>Total Cost:</strong> ${{ number_format($rental->total_cost, 2) }}</p>
        <p><strong>Booked On:</strong> {{ $rental->created_at->format('M d, Y H:i A') }}</p>
    </div>
</div>

<form action="{{ route('admin.rentals.update', $rental) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="status" class="form-label">Rental Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="Ongoing" {{ old('status', $rental->status) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="Completed" {{ old('status', $rental->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Canceled" {{ old('status', $rental->status) == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            {{-- Add other editable fields if necessary --}}
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Update Rental Status</button>
    </div>
</form>
@endsection