@extends('layouts.frontoffice.auth')

@section('title', 'Redirect to SSO UNTIRTA')

@section('content')
<div class="countainer">
    <div class="row justify-content-center align-items-center min-vh-100 bg-pattern-1">
        <div class="col-lg-4">
            <div class="card rounded-10px">
                <div class="card-body p-5">
                    <figure class="d-flex justify-content-center align-items-center mb-5">
                        <img class="img-fluid me-3" style="width: 80px; height: 80px;" src="{{ asset('vendor/portal-mahasiswa/_assets/images/logo.png') }}" alt="Logo">
                        <figcaption>
                            <h1 class="text-secondary m-0" style="line-height: 35px;"> <strong class="text-primary">Portal</strong> <br> Mahasiswa
                            </h1>
                        </figcaption>
                    </figure>

                    <div class="mb-5">
                        <div class="card rounded-0 my-5 bg-secondary border-l-10px-primary">
                            <div class="card-body p-4">
                                <p class="m-0 text-white">Anda belum login</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        Anda akan dialihkan ke <a class="text-decoration-none" href="{{ $data['redirect_url'] }}">SSO UNTIRTA</a> dalam <span id="seconds">6</span> detik.
                        <div class="spinner-border text-warning mx-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Countdown timer for redirecting to another URL after several seconds

    var seconds = 5; // seconds for HTML
    var foo; // variable for clearInterval() function

    function redirect() {
        document.location.href = `{{ $data['redirect_url'] }}`;
    }

    function updateSecs() {
        document.getElementById("seconds").innerHTML = seconds;
        seconds--;
        if (seconds == -1) {
            clearInterval(foo);
            redirect();
        }
    }

    function countdownTimer() {
        foo = setInterval(function() {
            updateSecs()
        }, 1000);
    }

    countdownTimer();
</script>
@endpush