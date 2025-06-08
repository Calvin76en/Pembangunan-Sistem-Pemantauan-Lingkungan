@extends('layout.admin.dash')

@section('content')
<!-- Breadcrumb Section dengan tampilan yang konsisten -->
<div class="d-flex flex-column gap-2 py-4 print-hidden">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-2">
                <!-- <i class="bi bi-speedometer2 text-primary me-2"></i> -->
                Dashboard
            </h4>
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav> -->
        </div>
        <div class="text-end">
            <small class="text-muted">
                <i class="bi bi-calendar-date me-1"></i>
                <span id="current-date"></span>
                <!-- <i class="bi bi-clock ms-2 me-1"></i>
                <span id="current-time"></span> -->
            </small>
        </div>
    </div>
</div>



<!-- Container untuk 3 cards utama -->
<div class="container-fluid px-0">
    <div class="row g-4 justify-content-center">

        <!-- Lokasi Pemantauan Card -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow h-100 dashboard-card" onclick="window.location.href='{{ route('admin.maintainlokasi') }}'" style="cursor: pointer;">
                <div class="card-body text-center p-5">
                    <div class="icon-wrapper mb-4">
                        <div class="icon-circle mx-auto" style="background-color: rgba(211, 245, 238, 0.7);">
                            <i class="bi bi-geo-alt-fill" style="color: #2F6D6D; font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-3 display-4">{{ $monitoringTypes->sum('locations_count') }}</h2>
                    <h5 class="text-uppercase text-muted mb-3">Lokasi Pemantauan</h5>
                    
                </div>
            </div>
        </div>

        <!-- Total User Card -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow h-100 dashboard-card" onclick="window.location.href='{{ route('admin.maintainuser') }}'" style="cursor: pointer;">
                <div class="card-body text-center p-5">
                    <div class="icon-wrapper mb-4">
                        <div class="icon-circle mx-auto bg-success bg-opacity-10">
                            <i class="bi bi-people-fill text-success" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-3 display-4">{{ $totalUsers }}</h2>
                    <h5 class="text-uppercase text-muted mb-3">Total User</h5>
                    
                </div>
            </div>
        </div>

        <!-- Tipe Pemantauan Card -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow h-100 dashboard-card" onclick="window.location.href='{{ route('admin.tipemonitoring') }}'" style="cursor: pointer;">
                <div class="card-body text-center p-5">
                    <div class="icon-wrapper mb-4">
                        <div class="icon-circle mx-auto" style="background-color: rgba(32, 201, 151, 0.1); width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-shield-check" style="color: #20C997; font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-3 display-4">{{ $monitoringTypes->count() }}</h2>
                    <h5 class="text-uppercase text-muted mb-3">Tipe Pemantauan</h5>
                    
                </div>
            </div>
        </div>


    </div>

</div>

<!-- External Resources -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Styles -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .dashboard-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        cursor: pointer;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .dashboard-card:hover .icon-circle {
        transform: scale(1.1);
    }

    .icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .icon-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .card {
        border-radius: 15px;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        font-weight: bold;
    }

    /* Animation on load */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .alert {
        animation: fadeIn 0.8s ease-out;
    }

    .dashboard-card {
        animation: fadeInUp 0.6s ease-out;
        animation-fill-mode: both;
    }

    .col-12:nth-child(1) .dashboard-card {
        animation-delay: 0.1s;
    }

    .col-12:nth-child(2) .dashboard-card {
        animation-delay: 0.2s;
    }

    .col-12:nth-child(3) .dashboard-card {
        animation-delay: 0.3s;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    .bi-circle-fill {
        animation: pulse 2s ease-in-out infinite;
    }

    .display-4 {
        font-size: 3rem !important;
        font-weight: 700 !important;
    }

    .alert {
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .alert:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08) !important;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .bi-speedometer2 {
        animation: float 3s ease-in-out infinite;
    }
</style>

<script>
    // Add specific tooltips for each card
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltip untuk card Lokasi Pemantauan
        var lokasiCard = document.querySelector('[onclick*="maintainlokasi"]');
        if (lokasiCard) {
            lokasiCard.setAttribute('title', 'Klik untuk mengelola lokasi pemantauan');
        }

        // Tooltip untuk card Total User
        var userCard = document.querySelector('[onclick*="maintainuser"]');
        if (userCard) {
            userCard.setAttribute('title', 'Klik untuk mengelola data pengguna');
        }

        // Tooltip untuk card Tipe Pemantauan
        var monitoringCard = document.querySelector('[onclick*="tipemonitoring"]');
        if (monitoringCard) {
            monitoringCard.setAttribute('title', 'Klik untuk mengelola tipe pemantauan');
        }

        // Add click feedback
        var cards = document.querySelectorAll('.dashboard-card');
        cards.forEach(function(card) {
            card.addEventListener('mousedown', function() {
                this.style.transform = 'scale(0.98)';
            });
            card.addEventListener('mouseup', function() {
                this.style.transform = '';
            });
        });

        // Display current date and time
        function updateDateTime() {
            var now = new Date();
            var dateOptions = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            var timeOptions = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };

            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    });
</script>

@endsection