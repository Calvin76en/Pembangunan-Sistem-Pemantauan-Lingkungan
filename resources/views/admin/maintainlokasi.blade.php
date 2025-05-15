@extends('layout.admin.dash')

@section('content')
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <ul class="flex flex-wrap items-center gap-2 mb-3 font-normal text-15">
        <li class="text-slate-700 dark:text-zink-100">
            Maintain Lokasi
        </li>
    </ul>
</div>

{{-- Card --}}
<div class="card" id="">
    <div class="card-body">
        <div class="flex items-center gap-3 mb-4">
            <h6 class="text-15 grow">Total Lokasi (<b class="total-Employs">{{ $locations->count() }}</b>)</h6>
            <div class="shrink-0">
                <button data-bs-toggle="modal" data-bs-target="#addLocationModal" type="button" class="btn btn-primary">
                    <i class="bi bi-plus"></i> <span class="align-middle">Tambah Lokasi</span>
                </button>
            </div>
        </div>
        <table id="rowBorder" style="width:100%">
            <thead>
                <tr>
                    <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-b border-slate-200 dark:border-zink-500">NO</th>
                    <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-b border-slate-200 dark:border-zink-500">ID Lokasi</th>
                    <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-b border-slate-200 dark:border-zink-500">Nama Lokasi</th>
                    <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-b border-slate-200 dark:border-zink-500">Tipe Pemantauan</th>
                    <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-b border-slate-200 dark:border-zink-500">Status</th>
                    <th class="px-3.5 py-2.5 first:pl-5 last:pr-8 font-semibold border-b border-slate-200 dark:border-zink-500">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-zink-500">
                @foreach ($locations as $location)
                <tr>
                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        <h6 class="transition-all duration-150 ease-linear text-custom-500 hover:text-custom-600">{{ $loop->iteration }}</h6>
                    </td>
                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        <h6 class="grow">{{ $location->location_id }}</h6>
                    </td>
                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        <h6 class="grow">{{ $location->location_name }}</h6>
                    </td>
                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        <h6 class="grow">{{ $location->monitoring_types }}</h6>
                    </td>

                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        @if($location->status == 1)
                        <span class="px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">Aktif</span>
                        @else
                        <span class="px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        <div class="flex gap-3">
                            <button type="button" class="btn btn-warning btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editLocationModal{{ $location->location_id }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Modal Edit Location -->
                <div class="modal fade" id="editLocationModal{{ $location->location_id }}" tabindex="-1" aria-labelledby="editLocationModalLabel{{ $location->location_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.updatelokasi', $location->location_id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Changed to PUT method -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editLocationModalLabel{{ $location->location_id }}">Edit Lokasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">ID Lokasi</label>
                                        <input type="text" class="form-control" name="location_id" value="{{ $location->location_id }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lokasi</label>
                                        <input type="text" class="form-control" name="location_name" value="{{ $location->location_name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tipe Pemantauan</label>
                                        <select class="form-select" name="monitoring_id" required>
                                            @foreach ($monitoringTypes as $type)
                                            <option value="{{ $type->monitoring_id }}" {{ $type->monitoring_id == $location->monitoring_id ? 'selected' : '' }}>
                                                {{ $type->monitoring_types }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status" required>
                                            <option value="1" {{ $location->status == 1 ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ $location->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                        </select>
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

<!-- Modal Tambah Location -->
<div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.storelokasi') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addLocationModalLabel">Tambah Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lokasi</label>
                        <input type="text" class="form-control" name="location_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Pemantauan</label>
                        <select class="form-select" name="monitoring_id" required>
                            <option value="">--Pilih Tipe Pemantauan--</option>
                            @foreach ($monitoringTypes as $type)
                            <option value="{{ $type->monitoring_id }}">{{ $type->monitoring_types }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah Lokasi</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- External Resources -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection