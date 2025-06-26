@extends('user.layouts.master')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="mb-4 text-primary">Contact Us</h2>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{route('user#contact')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Title</label>
                            <input type="text" class="form-control" id="subject" placeholder="Title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" name="message" id="message" rows="5" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3 text-secondary">Contact Information</h5>
                    <p><i class="fa fa-map-marker-alt me-2 text-primary"></i>1429 Netus Rd, NY 48247</p>
                    <p><i class="fa fa-envelope me-2 text-primary"></i>Example@gmail.com</p>
                    <p><i class="fa fa-phone me-2 text-primary"></i>+0123 4567 8910</p>
                </div>
            </div>
        </div>
    </div>

@endsection
