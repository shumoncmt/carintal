<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; // For Part 3
use App\Mail\RentalBookedAdminNotification; // For Part 3
use App\Mail\RentalBookedCustomerNotification; // For Part 3
use App\Models\User; // For Part 3 (to get admin email)


class RentalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);

        if (!$car->availability) {
            return back()->with('error', 'This car is currently not available for booking.')->withInput();
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Check if car is already booked for the selected period
        if ($car->isBooked($startDate, $endDate)) {
            return back()->with('error', 'This car is already booked for the selected dates. Please choose different dates.')->withInput();
        }

        $numberOfDays = $endDate->diffInDays($startDate) + 1;
        $totalCost = $numberOfDays * $car->daily_rent_price;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_cost' => $totalCost,
            'status' => 'Ongoing', // Or 'Pending Confirmation' if you have such a flow
        ]);

        // --- Part 3: Email Notification ---
        try {
            // Notify Customer
            Mail::to(Auth::user()->email)->send(new RentalBookedCustomerNotification($rental));

            // Notify Admin(s)
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                Mail::to($admin->email)->send(new RentalBookedAdminNotification($rental, Auth::user()));
            }
        } catch (\Exception $e) {
            // Log mail sending error, but don't fail the booking
            \Log::error('Mail sending failed for rental ID ' . $rental->id . ': ' . $e->getMessage());
        }
        // --- End Part 3 Email ---


        return redirect()->route('my-bookings')->with('success', 'Car booked successfully! A confirmation email has been sent.');
    }

    public function myBookings()
    {
        $bookings = Auth::user()->rentals()->with('car')
                        ->latest() // Show most recent first
                        ->paginate(10);
        return view('frontend.bookings.my_bookings', compact('bookings'));
    }

    public function cancelBooking(Rental $rental)
    {
        // Ensure the booking belongs to the authenticated user
        if ($rental->user_id !== Auth::id()) {
            return redirect()->route('my-bookings')->with('error', 'Unauthorized action.');
        }

        // Check if the rental has not started yet
        if (Carbon::parse($rental->start_date)->isPast() && $rental->status !== 'Canceled') {
             return redirect()->route('my-bookings')->with('error', 'Cannot cancel a rental that has already started or is completed.');
        }

        if ($rental->status == 'Canceled') {
             return redirect()->route('my-bookings')->with('info', 'This rental is already canceled.');
        }

        $rental->update(['status' => 'Canceled']);

        // Optional: Send cancellation confirmation email
        // Mail::to(Auth::user()->email)->send(new RentalCanceledNotification($rental));

        return redirect()->route('my-bookings')->with('success', 'Booking canceled successfully.');
    }
}
