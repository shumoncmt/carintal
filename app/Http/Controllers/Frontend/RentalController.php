<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User; // Import User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Import Mail facade
use Carbon\Carbon;
use App\Mail\RentalBookedAdminNotification; // Import Admin Mailable
use App\Mail\RentalBookedCustomerNotification; // Import Customer Mailable
use Illuminate\Support\Facades\Log; // For logging errors

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
        $customer = Auth::user(); // Get the authenticated customer

        if (!$car->availability) {
            return back()->with('error', 'This car is currently not available for booking.')->withInput();
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        if ($car->isBooked($startDate, $endDate)) {
            return back()->with('error', 'This car is already booked for the selected dates. Please choose different dates.')->withInput();
        }

        $numberOfDays = $endDate->diffInDays($startDate) + 1;
        $totalCost = $numberOfDays * $car->daily_rent_price;

        $rental = Rental::create([
            'user_id' => $customer->id,
            'car_id' => $car->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_cost' => $totalCost,
            'status' => 'Ongoing',
        ]);

        // --- Email Notification ---
        try {
            // Notify Customer
            Mail::to($customer->email)->send(new RentalBookedCustomerNotification($rental));

            // Notify Admin(s)
            $adminUsers = User::where('role', 'admin')->get();
            if ($adminUsers->isNotEmpty()) {
                foreach ($adminUsers as $admin) {
                    Mail::to($admin->email)->send(new RentalBookedAdminNotification($rental, $customer));
                }
            } else {
                Log::warning('No admin users found to send booking notification for rental ID: ' . $rental->id);
            }

        } catch (\Exception $e) {
            // Log mail sending error, but don't fail the booking process for the user
            Log::error('Mail sending failed for rental ID ' . $rental->id . ': ' . $e->getMessage());
            // Optionally, you could add a session flash message to inform the user that email might be delayed
            // session()->flash('warning', 'Booking confirmed, but there was an issue sending the confirmation email. Please check your bookings page.');
        }
        // --- End Email ---

        return redirect()->route('my-bookings')->with('success', 'Car booked successfully! A confirmation email has been sent.');
    }

    // ... other methods (myBookings, cancelBooking)
    public function myBookings()
    {
        $bookings = Auth::user()->rentals()->with('car')
                        ->latest()
                        ->paginate(10);
        return view('frontend.bookings.my_bookings', compact('bookings'));
    }

    public function cancelBooking(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            return redirect()->route('my-bookings')->with('error', 'Unauthorized action.');
        }

        if (Carbon::parse($rental->start_date)->isPast() && $rental->status !== 'Canceled') {
             return redirect()->route('my-bookings')->with('error', 'Cannot cancel a rental that has already started or is completed.');
        }

        if ($rental->status == 'Canceled') {
             return redirect()->route('my-bookings')->with('info', 'This rental is already canceled.');
        }

        $rental->update(['status' => 'Canceled']);

        // Optional: Send cancellation confirmation email to customer and admin
        // try {
        //     Mail::to(Auth::user()->email)->send(new RentalCanceledCustomerNotification($rental));
        //     $adminUsers = User::where('role', 'admin')->get();
        //     foreach ($adminUsers as $admin) {
        //         Mail::to($admin->email)->send(new RentalCanceledAdminNotification($rental, Auth::user()));
        //     }
        // } catch (\Exception $e) {
        //     Log::error('Mail sending failed for rental cancellation ID ' . $rental->id . ': ' . $e->getMessage());
        // }

        return redirect()->route('my-bookings')->with('success', 'Booking canceled successfully.');
    }
}