<x-mail::message>
# Your Car Rental Booking is Confirmed!

Hi {{ $rental->user->name }},

Thank you for booking with {{ config('app.name') }}! Your car rental has been successfully confirmed.

**Booking Details:**
- **Booking ID:** #{{ $rental->id }}
- **Car:** {{ $rental->car->name }} ({{ $rental->car->brand }} {{ $rental->car->model }})
- **Rental Period:** {{ $rental->start_date->format('M d, Y') }} to {{ $rental->end_date->format('M d, Y') }}
- **Total Cost:** ${{ number_format($rental->total_cost, 2) }}
- **Payment Method:** By Cash on Pickup

Please ensure you have the total amount ready when you pick up the car.
You can view your booking details and manage your rentals by clicking the button below:

<x-mail::button :url="$rentalUrl">
View My Bookings
</x-mail::button>

We look forward to serving you!

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>