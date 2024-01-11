@extends('layouts.backoffice.dashboard')

@section('title', 'Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title">Data @yield('title')</h3>
                    <!-- ------------------------------------------------ -->
                    <!-- Cek apakah pengguna dapat akses menu -->
                    <!-- ------------------------------------------------ -->
                    @if(PermissionMenu()[0]->groups->filter(function($item){ return $item->grup_id == Auth::user()->groups[0]->grup_id; })->flatten()[0]->pivot->grup_menu_item_tambah == 'ya')
                    <a class="btn btn-success waitme" href="{{ route('fitur.create') }}">Tambah Fitur</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>Kategori</th>
                                    <th>Fitur</th>
                                    <th>Tautan</th>
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
        fnInitComplete: function() {
            $("#overlay").hide();
        },
        ajax: "{{ route('fitur.index') }}",
        columns: [{
                "data": null,
                "sortable": false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'fitur_nama',
                name: 'fitur_nama'
            },
            {
                data: 'kategori_nama',
                name: 'kategori_nama'
            },
            {
                data: 'fitur_tautan',
                name: 'fitur_tautan',
                render: function(data, type, full, meta) {
                    return `{{ url('/${data}') }}`;
                }
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