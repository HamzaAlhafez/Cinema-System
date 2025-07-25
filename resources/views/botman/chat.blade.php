
@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="chat-icon-circle me-3">
                            <i class="fas fa-comments fa-2x"></i>
                        </div>
                        <h1 class="mb-0 display-5 fw-bold">Live Support Chat</h1>
                    </div>
                </div>
                
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="chat-icon-container mb-4">
                            <div class="chat-icon-bg">
                                <i class="fas fa-headset fa-4x text-primary"></i>
                            </div>
                        </div>
                        <h2 class="text-gradient-primary mb-3">Welcome to our Support Chat</h2>
                        <p class="lead text-muted">Click the chat icon at the bottom right to start a conversation with our support team</p>
                    </div>
                    
                    <div class="features p-4 rounded-3 mb-5">
                        <h3 class="text-center mb-4 fw-bold">How Can We Help You?</h3>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="feature-card text-center p-4 h-100 shadow-sm">
                                    <div class="feature-icon mb-3">
                                        <i class="fas fa-question-circle fa-2x text-info"></i>
                                    </div>
                                    <h4 class="mb-3">Technical Support</h4>
                                    <p>Get answers to your technical questions and troubleshooting assistance</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card text-center p-4 h-100 shadow-sm">
                                    <div class="feature-icon mb-3">
                                        <i class="fas fa-ticket-alt fa-2x text-success"></i>
                                    </div>
                                    <h4 class="mb-3">Ticket Management</h4>
                                    <p>Open and track support tickets for any issues you're experiencing</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card text-center p-4 h-100 shadow-sm">
                                    <div class="feature-icon mb-3">
                                        <i class="fas fa-calendar-check fa-2x text-warning"></i>
                                    </div>
                                    <h4 class="mb-3">Bookings & Appointments</h4>
                                    <p>Manage your cinema bookings, reservations, and appointments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="support-info bg-light p-4 rounded-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-3">Need Immediate Assistance?</h4>
                                <div class="d-flex">
                                    <div class="me-4">
                                        <i class="fas fa-phone me-2 text-primary"></i>(+963) 953248544


</div>
                                    <div>
                                        <i class="fas fa-envelope me-2 text-primary"></i>support@cinema.com
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <button class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-download me-2"></i> FAQs
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-light text-center py-3">
                    <p class="mb-0">
                        <i class="fas fa-clock me-1 text-primary"></i> 
                        Available 24/7 | 
                        <i class="fas fa-stopwatch me-1 text-primary"></i> 
                        Average response time: under 3 minutes
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var botmanWidget = {
        frameEndpoint: "{{ url('/botman/chat') }}",
        chatServer: "{{ url('/botman') }}",
        title: 'Support Chat',
        mainColor: '#408591',
        bubbleBackground: '#408591',
        introMessage: 'Hello! How can I assist you today?',
        desktopHeight: 500,
        desktopWidth: 400,
        aboutLink: 'https://cinema-system.com',
        aboutText: 'Cinema Support System',
        autoOpen: true,
        mobileHeight: '70%',
        mobileWidth: '90%'
    };
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
