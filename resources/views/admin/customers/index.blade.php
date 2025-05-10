@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Customers</h1>
     <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.customers.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-user-plus"></i> Add New Customer
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone_number ?? 'N/A' }}</td>
                <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer? This may also affect their rental history.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No customers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $customers->links() }}
@endsection