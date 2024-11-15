@extends('layouts.app')
@section('title', 'Login Laporan')
@section('content')
    <div id="hero-block" class="hero-block-wrapper bg-primary">
        <div class="hero-block-styles">
            <div class="hb-styles1" style="background-image: url('img/core-img/dot.png')"></div>
            <div class="hb-styles2"></div>
            <div class="hb-styles3"></div>
        </div>

        <div class="custom-container">
            <div class="hero-block-content">
                <img class="mb-4" src="img/bg-img/19.png" alt="">
                <h2 class="display-4 text-white mb-3">Input Laporan Hasil Pilkada</h2>
                <p class="text-white">Gunakan aplikasi "REKAP DATA" untuk memasukkan dan melaporkan hasil pemilihan secara
                    akurat dan mudah.</p>

                <a class="btn btn-warning btn-lg w-100" id="mulai-sekarang-btn">Mulai Sekarang</a>
            </div>
        </div>
    </div>

    <div id="login-wrapper" style="display: none;">
        <div class="login-wrapper d-flex align-items-center justify-content-center">
            <div class="custom-container">
                <div class="text-center px-4">
                    <img class="login-intro-img" src="img/bg-img/36.png" alt="">
                </div>

                <div class="register-form mt-4">
                    <h6 class="mb-3 text-center">Masuk untuk melakukan rekap data</h6>

                    <form id="login-form">
                        <div class="form-group">
                            <input class="form-control" type="text" id="username" placeholder="Username" required>
                        </div>

                        <div class="form-group position-relative">
                            <input class="form-control" id="psw-input" type="password" placeholder="Enter Password" required>
                            <div class="position-absolute" id="password-visibility">
                                <i class="bi bi-eye"></i>
                                <i class="bi bi-eye-slash"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#mulai-sekarang-btn').on('click', function() {
                // Hide the hero block
                $('#hero-block').hide();
                // Show the login form
                $('#login-wrapper').show();
            });

            // Handle login form submission
            $('#login-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Get form data
                const username = $('#username').val();
                const password = $('#psw-input').val();
                const userDevice = "g7_3s9fk0GRqxdab"; // Your device ID
                const fcmToken = "eZQ2Uf7hQeWam9inWFCAw_:APA91bGif9MwpT51EpLixXjZF4yC8alHqQ0fyDFiBdrVXO0adDwfBEGWk771aW34rSYAkLrGHIVfJiwXwKvd0wztz8jagvgWWFkNKsaXd8cPcIOI_2zsXN340POsb17h3zuFdvSNRumD";

                axios.post('{{ env('API_URL') }}/v1/login', {
                    username: username,
                    password: password,
                    user_device: userDevice,
                    fcm_token: fcmToken
                })
                .then(function(response) {
                    // Handle success
                    console.log(response.data);

                    // Save the login data to localStorage
                    if (response.data.status === "success") {
                        localStorage.setItem('user_id', response.data.data.user_id);
                        localStorage.setItem('username', response.data.data.username);
                        localStorage.setItem('token', response.data.data.token);
                        localStorage.setItem('expires_at', response.data.data.expires_at);
                        localStorage.setItem('is_officer', response.data.data.is_officer);

                        // Redirect to home after successful login
                        window.location.href = '/home'; // Redirect to home
                    } else {
                        alert("Login failed: " + response.data.message);
                    }
                })
                .catch(function(error) {
                    // Handle error
                    console.error(error);
                    alert("Login failed, please try again.");
                });
            });
        });
    </script>
@endsection
