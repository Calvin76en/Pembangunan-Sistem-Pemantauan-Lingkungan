@extends('layout.admin.dash')

@section('content')
<!-- Breadcrumb Section dengan tampilan yang konsisten -->
<div class="d-flex flex-column gap-2 py-4 print-hidden">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-2">
                <!-- <i class="bi bi-geo-alt-fill text-primary me-2"></i> -->
                Mengelola Lokasi
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mengelola Lokasi</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Card dengan shadow dan border yang konsisten --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">
                    <!-- <i class="bi bi-pin-map-fill text-secondary me-2"></i> -->
                    Daftar Lokasi
                </h5>
            </div>
            <div>
                <button data-bs-toggle="modal" data-bs-target="#addLocationModal" type="button"
                    class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle-fill"></i> 
                    <span class="align-middle">Tambah Lokasi</span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table id="rowBorder" class="table table-hover" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th style="width: 15%">ID Lokasi</th>
                        <th style="width: 30%">Nama Lokasi</th>
                        <th style="width: 25%">Tipe Pemantauan</th>
                        <th class="text-center" style="width: 15%">Status</th>
                        <th class="text-center" style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $location)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-medium">{{ $location->location_id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                
                                <span>{{ $location->location_name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                <i class="bi bi-eye me-1"></i>{{ $location->monitoring_types }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($location->status == 1)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Aktif
                            </span>
                            @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i>Non-Aktif
                            </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                data-bs-target="#editLocationModal{{ $location->location_id }}" title="Edit Lokasi">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Location -->
                    <div class="modal fade" id="editLocationModal{{ $location->location_id }}" tabindex="-1" 
                        aria-labelledby="editLocationModalLabel{{ $location->location_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.updatelokasi', $location->location_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-warning bg-opacity-10 border-0">
                                        <h5 class="modal-title fw-bold" id="editLocationModalLabel{{ $location->location_id }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit Lokasi
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-geo text-muted me-1"></i>Nama Lokasi
                                            </label>
                                            <input type="text" class="form-control @error('location_name') is-invalid @enderror" 
                                                name="location_name" value="{{ $location->location_name }}" required>
                                            @error('location_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-eye text-muted me-1"></i>Tipe Pemantauan
                                            </label>
                                            <select class="form-select @error('monitoring_id') is-invalid @enderror" 
                                                name="monitoring_id" required>
                                                @foreach ($monitoringTypes as $type)
                                                <option value="{{ $type->monitoring_id }}" 
                                                    {{ $type->monitoring_id == $location->monitoring_id ? 'selected' : '' }}>
                                                    {{ $type->monitoring_types }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('monitoring_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-toggle-on text-muted me-1"></i>Status
                                            </label>
                                            <select class="form-select" name="status" required>
                                                <option value="1" {{ $location->status == 1 ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ $location->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Location -->
<div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold" id="addLocationModalLabel">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Lokasi Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.storelokasi') }}" method="POST" id="addLocationForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            <i class="bi bi-geo text-muted me-1"></i>Nama Lokasi
                        </label>
                        <input type="text" class="form-control @error('location_name') is-invalid @enderror" 
                            name="location_name" value="{{ old('location_name') }}" 
                            placeholder="Masukkan nama lokasi" required>
                        @error('location_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            <i class="bi bi-eye text-muted me-1"></i>Tipe Pemantauan
                        </label>
                        <select class="form-select @error('monitoring_id') is-invalid @enderror" 
                            name="monitoring_id" required>
                            <option value="">-- Pilih Tipe Pemantauan --</option>
                            @foreach ($monitoringTypes as $type)
                            <option value="{{ $type->monitoring_id }}" {{ old('monitoring_id') == $type->monitoring_id ? 'selected' : '' }}>
                                {{ $type->monitoring_types }}
                            </option>
                            @endforeach
                        </select>
                        @error('monitoring_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            <i class="bi bi-toggle-on text-muted me-1"></i>Status
                        </label>
                        <select class="form-select" name="status" required>
                            <option value="1" selected>Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Tambah Lokasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error Alert -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="errorModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Error
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="errorMessage">
                    @if($errors->any())
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                    @if(session('error'))
                    {{ session('error') }}
                    @endif
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Success Alert -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="bi bi-check-circle-fill me-2"></i>Berhasil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="successMessage" class="text-center py-3">
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0">
                        @if(session('success'))
                        {{ session('success') }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-success px-5" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- External Resources -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Styles (Konsisten dengan halaman user) -->
<style>
    .avatar-sm {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.75rem;
        vertical-align: middle;
    }
    
    .card {
        border-radius: 10px;
    }
    
    .btn {
        border-radius: 6px;
    }
    
    .modal-content {
        border-radius: 10px;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show error modal if there are validation errors
        @if($errors->any() || session('error'))
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();

        // If there are validation errors, show the add location modal after closing error modal
        @if($errors->any())
        document.getElementById('errorModal').addEventListener('hidden.bs.modal', function() {
            var addLocationModal = new bootstrap.Modal(document.getElementById('addLocationModal'));
            addLocationModal.show();
        });
        @endif
        @endif

        // Show success modal if there's a success message
        @if(session('success'))
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        @endif
    });

    // Auto-hide modals after 5 seconds
    setTimeout(function() {
        var errorModal = bootstrap.Modal.getInstance(document.getElementById('errorModal'));
        var successModal = bootstrap.Modal.getInstance(document.getElementById('successModal'));

        if (errorModal) {
            errorModal.hide();
        }
        if (successModal) {
            successModal.hide();
        }
    }, 5000);
</script>

@endsection