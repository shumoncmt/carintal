<x-mail::message>
# New Car Rental Booking Received

Hello Admin,

A new car rental booking has been made on {{ config('app.name') }}.

**Customer Details:**
- **Name:** {{ $customer->name }}
- **Email:** {{ $customer->email }}
- **Phone:** {{ $customer->phone_number ?? 'N/A' }}

**Booking Details:**
- **Booking ID:** #{{ $rental->id }}
- **Car:** {{ $rental->car->name }} ({{ $rental->car->brand }} {{ $rental->car->model }})
- **Rental Period:** {{ $rental->start_date->format('M d, Y') }} to {{ $rental->end_date->format('M d, Y') }}
- **Total Cost:** ${{ number_format($rental->total_cost, 2) }}

You can view the full booking details in the admin panel:

<x-mail::button :url="$rentalAdminUrl">
View Booking in Admin
</x-mail::button>

Please review and take any necessary actions.

Regards,<br>
{{ config('app.name') }} System
</x-mail::message>