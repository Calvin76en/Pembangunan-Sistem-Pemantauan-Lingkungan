@extends('layout.admin.dash')

@section('content')
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <ul class="flex flex-wrap items-center gap-2 mb-3 font-normal text-15">
        <li class="text-slate-700 dark:text-zink-100">
            Maintain User
        </li>
    </ul>
</div>

{{-- Card --}}
<div class="card" id="">
    <div class="card-body">
        <div class="flex items-center gap-3 mb-4">
            <h6 class="text-15 grow">Total User (<b class="total-Employs">{{ $users->count() }}</b>)</h6>
            <div class="shrink-0">
                <button data-bs-toggle="modal" data-bs-target="#addUserModal" type="button"
                    class="btn btn-primary">
                    <i class="bi bi-plus"></i> <span class="align-middle">Tambah User</span>
                </button>
            </div>
        </div>

        <table id="rowBorder" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->NIK_user }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        @if($user->status == 1)
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-danger">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            <button type="button" 
                                class="btn btn-warning btn-sm mx-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editUserModal{{ $user->user_id }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Modal Edit User (dalam loop) -->
                <div class="modal fade" id="editUserModal{{ $user->user_id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->user_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.updateuser', $user->user_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel{{ $user->user_id }}">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="NIK_user" value="{{ $user->NIK_user }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select class="form-select" name="role" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->role }}" {{ $user->role == $role->role ? 'selected' : '' }}>
                                                    {{ ucfirst($role->role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status" required>
                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                        </select>
                                    </div>
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.storeuser') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="NIK_user" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="NIK_user" name="NIK_user" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->role }}">{{ ucfirst($role->role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- External Resources -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
