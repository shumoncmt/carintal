@extends('layouts.app')

@section('title', 'Our Cars for Rent')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Find Your Ideal Car</h1>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('cars.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="car_type" class="form-label">Car Type</label>
                        <select name="car_type" id="car_type" class="form-select">
                            <option value="">All Types</option>
                            @foreach($carTypes as $type)
                                <option value="{{ $type }}" {{ request('car_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="brand" class="form-label">Brand</label>
                        <select name="brand" id="brand" class="form-select">
                            <option value="">All Brands</option>
                            @foreach($brands as $brandName)
                                <option value="{{ $brandName }}" {{ request('brand') == $brandName ? 'selected' : '' }}>{{ $brandName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="min_price" class="form-label">Min Price/Day</label>
                        <input type="number" name="min_price" id="min_price" class="form-control" placeholder="e.g., 50" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="max_price" class="form-label">Max Price/Day</label>
                        <input type="number" name="max_price" id="max_price" class="form-control" placeholder="e.g., 200" value="{{ request('max_price') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
                 <div class="row g-3 align-items-end mt-2">
                    <div class="col-md-3">
                         <label for="sort_by" class="form-label">Sort By</label>
                        <select name="sort_by" id="sort_by" class="form-select">
                            <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Newest</option>
                            <option value="daily_rent_price" {{ request('sort_by') == 'daily_rent_price' ? 'selected' : '' }}>Price</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="brand" {{ request('sort_by') == 'brand' ? 'selected' : '' }}>Brand</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="sort_direction" class="form-label">Order</label>
                        <select name="sort_direction" id="sort_direction" class="form-select">
                            <option value="desc" {{ request('sort_direction', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                     <div class="col-md-2">
                        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if($cars->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($cars as $car)
                @include('frontend.cars._car_card', ['car' => $car])
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $cars->links() }} {{-- Pagination links --}}
        </div>
    @else
        <div class="alert alert-info text-center">
            No cars found matching your criteria. Try adjusting your filters.
        </div>
    @endif
</div>
@endsection