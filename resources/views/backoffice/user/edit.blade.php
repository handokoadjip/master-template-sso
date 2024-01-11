@extends('layouts.backoffice.dashboard')

@section('title', 'Ubah Pengguna')

@section('content')
<div class="container-fluid">
    {{ Form::open(['route' => ['pengguna.update', $data['id']], 'method' => 'put']) }}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                </div>
                <div class="card-body">
                    {{ Form::hidden('pengguna_id', $data['id']) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                {{ Form::label('grup_id', 'Grup', ['class' => 'form-label']) }}
                                {{ Form::select('grup_id', $data['groups'], old('grup_id', @$data['user']->groups[0]->grup_id), ['placeholder' => 'Pilih Grup', 'class' => $errors->has('grup_id') ? 'form-select select2 is-invalid' : 'form-select select2', 'autocomplete'=>'grup_id']) }}
                                @error('grup_id')
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
    {{ Form::close() }}
</div>
@endsection