@extends('layouts.backoffice.dashboard')

@section('title', 'Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route' => 'pengguna.index', 'method' => 'get']) }}
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="mb-4">Filter</h5>
                </div>
                <div class="col-md-8 pe-0">
                    <div class="mb-3">
                        {{ Form::text('pengguna_identitas', app('request')->input('pengguna_identitas'), ['placeholder' => 'NIP / NIM', 'class' => $errors->has('pengguna_identitas') ? 'form-control is-invalid' : 'form-control', 'autocomplete'=>'pengguna_identitas']) }}
                    </div>
                </div>
                <div class="col-md-8 pe-0">
                    <div class="mb-3">
                        {{ Form::text('pengguna_nama', app('request')->input('pengguna_nama'), ['placeholder' => 'Nama', 'class' => $errors->has('pengguna_nama') ? 'form-control is-invalid' : 'form-control', 'autocomplete'=>'pengguna_nama']) }}
                    </div>
                </div>
            </div>
            <button class="btn btn-primary px-4 waitme mb-5" type="submit">Filter</button>
            {{ Form::close() }}
        </div>


        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title">Data @yield('title')</h3>
                    <!-- ------------------------------------------------ -->
                    <!-- Cek apakah pengguna dapat akses menu -->
                    <!-- ------------------------------------------------ -->
                    @if(PermissionMenu()[0]->groups->filter(function($item){ return $item->grup_id == Auth::user()->groups[0]->grup_id; })->flatten()[0]->pivot->grup_menu_item_tambah == 'ya')
                    <a class="btn btn-success waitme" href="{{ route('pengguna.create') }}">Tambah Pengguna</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>NIP/NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telp</th>
                                    <th>Grup</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#table').DataTable({
        serverSide: true,
        searching: false,
        ordering: false,
        fnInitComplete: function() {
            $("#overlay").hide();
        },
        ajax: "{!! route('pengguna.index', ['pengguna_identitas' => app('request')->input('pengguna_identitas'), 'pengguna_nama' => app('request')->input('pengguna_nama')]) !!}",
        columns: [{
                "data": null,
                "sortable": false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return `<div class='text-center'>${meta.row + meta.settings._iDisplayStart + 1}</div>`;
                }
            },
            {
                data: 'pengguna_identitas',
                name: 'pengguna_identitas',
            },
            {
                data: 'pengguna_nama',
                name: 'pengguna_nama',
            },
            {
                data: 'pengguna_email',
                name: 'pengguna_email',
            },
            {
                "data": null,
                searchable: false,
                render: function(data, type, row, meta) {
                    return data.employee_biodata[0]?.pegawai_biodata_nomor_telepon ?? data.student_biodata[0]?.mahasiswa_biodata_nomor_telepon ?? '-';
                }
            },
            {
                data: 'groups_backoffice[0].grup_nama',
                name: 'groups_backoffice[0].grup_nama',
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            },
        ]
    });
</script>
@endpush