@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="text-center mb-4">Get In Touch</h1>
            <p class="lead text-center mb-5">
                Have questions or need assistance? We're here to help! Reach out to us through any of the methods below.
            </p>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Our Office</h5>
                            <p class="card-text">
                                123 Rental Car Street<br>
                                Cityville, State 12345<br>
                                Country
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-phone-alt fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Call Us</h5>
                            <p class="card-text">
                                <strong>Customer Service:</strong> +1 (555) 123-4567<br>
                                <strong>Support:</strong> +1 (555) 987-6543
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 offset-md-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Email Us</h5>
                            <p class="card-text">
                                <strong>General Inquiries:</strong> info@cargorental.example<br>
                                <strong>Bookings:</strong> bookings@cargorental.example
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simple Contact Form Placeholder (not functional without backend logic) -->
            <h3 class="text-center mt-5 mb-3">Send Us a Message</h3>
            <form action="#" method="POST"> {{-- Add action route if implementing form submission --}}
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                </div>
            </form>
            <p class="text-center text-muted mt-2"><small>Note: This form is a placeholder and not currently functional.</small></p>
        </div>
    </div>
</div>
@endsection