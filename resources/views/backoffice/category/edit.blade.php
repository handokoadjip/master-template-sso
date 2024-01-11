@extends('layouts.backoffice.dashboard')

@section('title', 'Ubah Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => ['kategori.update', $data['category']->kategori_id], 'method' => 'put']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                {{ Form::label('kategori_nama', 'Kategori', ['class' => 'form-label']) }}
                                {{ Form::text('kategori_nama', old('kategori_nama', $data['category']->kategori_nama), ['placeholder' => 'Kategori', 'class' => $errors->has('kategori_nama') ? 'form-control is-invalid' : 'form-control', 'autocomplete'=>'kategori_nama', 'autofocus'=>'autofocus']) }}
                                @error('kategori_nama')
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