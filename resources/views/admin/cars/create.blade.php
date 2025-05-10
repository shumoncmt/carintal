@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ isset($car) ? 'Edit Car' : 'Add New Car' }}</h1>
    <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Cars
    </a>
</div>

<form action="{{ isset($car) ? route('admin.cars.update', $car) : route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($car))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Car Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $car->name ?? '') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand', $car->brand ?? '') }}" required>
                            @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model', $car->model ?? '') }}" required>
                            @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label">Year of Manufacture</label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', $car->year ?? '') }}" required>
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="car_type" class="form-label">Car Type</label>
                            <input type="text" class="form-control @error('car_type') is-invalid @enderror" id="car_type" name="car_type" value="{{ old('car_type', $car->car_type ?? '') }}" placeholder="e.g., SUV, Sedan" required>
                            @error('car_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="daily_rent_price" class="form-label">Daily Rent Price ($)</label>
                        <input type="number" step="0.01" class="form-control @error('daily_rent_price') is-invalid @enderror" id="daily_rent_price" name="daily_rent_price" value="{{ old('daily_rent_price', $car->daily_rent_price ?? '') }}" required>
                        @error('daily_rent_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability Status</label>
                        <select class="form-select @error('availability') is-invalid @enderror" id="availability" name="availability" required>
                            <option value="1" {{ old('availability', $car->availability ?? '1') == '1' ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ old('availability', $car->availability ?? '1') == '0' ? 'selected' : '' }}>Not Available</option>
                        </select>
                        @error('availability') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Car Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage(event)">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if(isset($car) && $car->image)
                            <img id="imagePreview" src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="img-thumbnail mt-2" style="max-height: 150px;">
                        @else
                            <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail mt-2" style="max-height: 150px; display: none;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">{{ isset($car) ? 'Update Car' : 'Add Car' }}</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush