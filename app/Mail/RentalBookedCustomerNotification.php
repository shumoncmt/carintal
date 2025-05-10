<?php

namespace App\Mail;

use App\Models\Rental;
use App\Models\User; // For customer details
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalBookedAdminNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Rental $rental;
    public User $customer;

    /**
     * Create a new message instance.
     */
    public function __construct(Rental $rental, User $customer)
    {
        $this->rental = $rental;
        $this->customer = $customer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Car Rental Booking: #' . $this->rental->id . ' by ' . $this->customer->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rentals.admin_booked',
            with: [
                'rentalAdminUrl' => route('admin.rentals.show', $this->rental->id), // URL to admin rental details
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}