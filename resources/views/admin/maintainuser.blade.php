@extends('layout.admin.dash')

@section('content')
<!-- Breadcrumb Section dengan tampilan yang lebih menarik -->
<div class="d-flex flex-column gap-2 py-4 print-hidden">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-2">
                <!-- <i class="bi bi-people-fill text-primary me-2"></i> -->
                Mengelola Pengguna
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mengelola Pengguna</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Card dengan shadow dan border yang lebih menarik --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">
                    <!-- <i class="bi bi-person-lines-fill text-secondary me-2"></i> -->
                    Daftar Pengguna
                </h5>
            </div>
            <div>
                <button data-bs-toggle="modal" data-bs-target="#addUserModal" type="button"
                    class="btn btn-primary shadow-sm">
                    <i class="bi bi-person-plus-fill"></i> 
                    <span class="align-middle">Tambah Pengguna</span>
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
                        <th style="width: 15%">NIK</th>
                        <th style="width: 20%">Nama</th>
                        <th style="width: 25%">Email</th>
                        <th style="width: 15%">Role</th>
                        <th class="text-center" style="width: 10%">Status</th>
                        <th class="text-center" style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-medium">{{ $user->NIK_user }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!-- <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle me-2">
                                    <span class="text-primary fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div> -->
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <i class="bi bi-envelope text-muted me-1"></i>
                            {{ $user->email }}
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $user->role_name }}</span>
                        </td>
                        <td class="text-center">
                            @if($user->status == 1)
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
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->NIK_user }}" title="Edit Pengguna">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit User -->
                    <div class="modal fade" id="editUserModal{{ $user->NIK_user }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->NIK_user }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.updateuser', $user->NIK_user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-warning bg-opacity-10 border-0">
                                        <h5 class="modal-title fw-bold" id="editUserModalLabel{{ $user->NIK_user }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit Pengguna
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="NIK_user" value="{{ $user->NIK_user }}">

                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-person text-muted me-1"></i>Nama
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-envelope text-muted me-1"></i>Email
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-shield text-muted me-1"></i>Role
                                            </label>
                                            @if($user->role_id == 1)
                                                {{-- Jika user adalah admin, tampilkan role sebagai readonly --}}
                                                <input type="hidden" name="role" value="{{ $user->role_id }}">
                                                <input type="text" class="form-control" value="Admin" readonly disabled>
                                                <small class="text-muted">
                                                    <i class="bi bi-info-circle me-1"></i>Role admin tidak dapat diubah
                                                </small>
                                            @else
                                                {{-- Jika bukan admin, tampilkan dropdown normal --}}
                                                <select class="form-select" name="role" required>
                                                    @foreach ($roles as $role)
                                                        @if($role->id_role != 1) {{-- Exclude admin role from selection --}}
                                                            <option value="{{ $role->id_role }}" {{ $user->role_id == $role->id_role ? 'selected' : '' }}>
                                                                {{ ucfirst($role->role_name) }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-toggle-on text-muted me-1"></i>Status
                                            </label>
                                            <select class="form-select" name="status" required>
                                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-key text-muted me-1"></i>Password
                                            </label>
                                            <input type="password" class="form-control" name="password">
                                            <small class="text-muted">
                                                <i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin mengubah password
                                            </small>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold" id="addUserModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.storeuser') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">
                            <i class="bi bi-person text-muted me-1"></i>Nama
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">
                            <i class="bi bi-envelope text-muted me-1"></i>Email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">
                            <i class="bi bi-key text-muted me-1"></i>Password
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-medium">
                            <i class="bi bi-shield text-muted me-1"></i>Role
                        </label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id_role }}" {{ old('role') == $role->id_role ? 'selected' : '' }}>
                                {{ ucfirst($role->role_name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if(count($roles) < 3)
                        <small class="text-warning">
                            <i class="bi bi-info-circle me-1"></i>Admin sudah ada, hanya bisa menambahkan role lain
                        </small>
                        @endif
                    </div>

                    <!-- No need to select status, automatically set to 1 (Aktif) -->
                    <input type="hidden" name="status" value="1">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Tambah Pengguna
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

<!-- Custom Styles -->
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

        // If there are validation errors, show the add user modal after closing error modal
        @if($errors->any())
        document.getElementById('errorModal').addEventListener('hidden.bs.modal', function() {
            var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
            addUserModal.show();
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