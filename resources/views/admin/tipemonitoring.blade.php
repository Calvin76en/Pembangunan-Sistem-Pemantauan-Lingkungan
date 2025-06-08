@extends('layout.admin.dash')

@section('content')
<!-- Breadcrumb Section dengan tampilan yang konsisten -->
<div class="d-flex flex-column gap-2 py-4 print-hidden">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-2">
                <!-- <i class="bi bi-eye-fill text-primary me-2"></i> -->
                Mengelola Tipe Pemantauan
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mengelola Tipe Pemantauan</li>
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
                    <!-- <i class="bi bi-list-check text-secondary me-2"></i> -->
                    Daftar Tipe Pemantauan
                </h5>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table id="rowBorder" class="table table-hover" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th style="width: 20%">ID Tipe Pemantauan</th>
                        <th style="width: 60%">Nama Tipe Pemantauan</th>
                        <th class="text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monitoringTypes as $type)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-medium">{{ $type->monitoring_id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                
                                <span>{{ $type->monitoring_types }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                data-bs-target="#editMonitoringModal{{ $type->monitoring_id }}" title="Edit Tipe Pemantauan">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Tipe Pemantauan -->
                    <div class="modal fade" id="editMonitoringModal{{ $type->monitoring_id }}" tabindex="-1" 
                        aria-labelledby="editMonitoringModalLabel{{ $type->monitoring_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.updatetipemonitoring', $type->monitoring_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-warning bg-opacity-10 border-0">
                                        <h5 class="modal-title fw-bold" id="editMonitoringModalLabel{{ $type->monitoring_id }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit Tipe Pemantauan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-eye text-muted me-1"></i>Nama Tipe Pemantauan
                                            </label>
                                            <input type="text" class="form-control @error('monitoring_types') is-invalid @enderror" 
                                                name="monitoring_types" value="{{ $type->monitoring_types }}" required>
                                            @error('monitoring_types')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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

<!-- Custom Styles (Konsisten dengan halaman lainnya) -->
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