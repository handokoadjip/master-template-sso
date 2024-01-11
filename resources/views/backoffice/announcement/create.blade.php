@extends('layouts.backoffice.dashboard')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'pengumuman.store', 'method' => 'post']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                {{ Form::label('pengumuman_kategori_id', 'Kategori', ['class' => 'form-label']) }}
                                {{ Form::select('pengumuman_kategori_id', $data['categories'], null, ['placeholder' => 'Pilih Kategori', 'class' => $errors->has('pengumuman_kategori_id') ? 'form-select select2 is-invalid' : 'form-select select2', 'autocomplete'=>'pengumuman_kategori_id']) }}
                                @error('pengumuman_kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-4">
                                {{ Form::label('pengumuman_isi', 'Kategori', ['class' => 'form-label']) }}
                                {{ Form::textarea('pengumuman_isi', null, ['placeholder' => 'Kategori', 'class' => $errors->has('pengumuman_isi') ? 'form-control is-invalid' : 'form-control', 'autocomplete'=>'pengumuman_isi', 'autofocus'=>'autofocus']) }}
                                @error('pengumuman_isi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{ Form::submit('Simpan', ['class' => 'btn btn-success waitme']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection