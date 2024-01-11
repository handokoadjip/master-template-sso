@extends('layouts.backoffice.dashboard')

@section('title', 'Tambah Fitur')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'fitur.store', 'method' => 'post']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                {{ Form::label('fitur_kategori_id', 'Kategori', ['class' => 'form-label']) }}
                                {{ Form::select('fitur_kategori_id', $data['categories'], null, ['placeholder' => 'Pilih Kategori', 'class' => $errors->has('fitur_kategori_id') ? 'form-select select2 is-invalid' : 'form-select select2', 'autocomplete'=>'fitur_kategori_id']) }}
                                @error('fitur_kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                {{ Form::label('fitur_nama', 'Fitur', ['class' => 'form-label']) }}
                                {{ Form::text('fitur_nama', null, ['placeholder' => 'Fitur', 'class' => $errors->has('fitur_nama') ? 'form-control is-invalid' : 'form-control', 'autocomplete'=>'fitur_nama']) }}
                                @error('fitur_nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                {{ Form::label('fitur_tautan', 'Tautan', ['class' => 'form-label']) }}
                                {{ Form::text('fitur_tautan', null, ['placeholder' => 'Tautan', 'class' => $errors->has('fitur_tautan') ? 'form-control is-invalid' : 'form-control', 'autocomplete'=>'fitur_tautan']) }}
                                @error('fitur_tautan')
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

@push('script')
<script>
    $(document).ready(function() {

        $("#fitur_nama").keyup(function() {
            let menuLabel = $("#fitur_nama").val();

            let slug = menuLabel.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');

            $("#fitur_tautan").val(slug)
        })
    });
</script>
@endpush