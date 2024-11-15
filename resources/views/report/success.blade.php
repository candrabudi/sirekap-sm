@extends('layouts.app')

@section('content')
    <div class="login-wrapper d-flex align-items-center justify-content-center"
        style="background: url({{ asset('img/particel.svg') }}); background-size: 140%;  background-position: 0px -100px; ">
        <div class="custom-container" style="background: rgba(255, 255, 255, 0.7); padding: 50px; border-radius: 10px;">
            <div class="text-center">
                <img class="mx-auto mb-4 d-block" src="{{ asset('img/icon-success.svg') }}" alt="">
                <h3>Submit Berhasil</h3>
                <p class="mb-4" style="color: #000;">Terima kasih telah membantu menjaga transparansi pemilu</p>
            </div>
            <button class="btn  w-100 p-2" style="background: #6C00EB; color: #FFF; border-radius: 50px;">Kembali ke
                Beranda</button>
        </div>
        <div class="backdrop"></div>
    </div>

    <style>
        .login-wrapper {
            position: relative;
            overflow: hidden;
        }

        .backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            opacity: 0.5;
            z-index: 1;
        }

        .custom-container {
            position: relative;
            z-index: 2;
        }
    </style>

    @include('layouts.menu')
@endsection
