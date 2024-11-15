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
            <a href="/home" class="btn  w-100 p-2" style="background: #6C00EB; color: #FFF; border-radius: 50px;">Kembali
                ke
                Beranda</a>
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

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"
        integrity="sha512-a+SUDuwNzXDvz4XrIcXHuCf089/iJAoN4lmrXJg18XnduKK6YlDHNRalv4yd1N40OKI80tFidF+rqTFKGPoWFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to calculate the total and apply the 2.5% increase
        function calculateTotal() {
            const totalVotesInput = document.getElementById('totalVotesInput').value;
            const totalVotes = parseFloat(totalVotesInput);
            if (!isNaN(totalVotes)) {
                const result = totalVotes + (totalVotes * 0.025);
                const roundedResult = Math.ceil(result);
                document.getElementById('calculatedResult').value = roundedResult;
            } else {
                document.getElementById('calculatedResult').value = '';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Get the token, user_id, and username from localStorage
            const token = localStorage.getItem('token');
            const userId = localStorage.getItem('user_id');
            const username = localStorage.getItem('username');

            // Check if token, userId, and username are available
            if (token && userId && username) {
                validateToken(token, userId, username);
            } else {
                alert('No valid authentication token found. Please log in.');
                window.location.href = '/login';
            }
        });

        // Function to validate the token by making an API request
        function validateToken(token, userId, username) {
            const apiUrl = '{{ env('API_URL') }}/v2/user/get-profile';
            const headers = {
                'api_key': 'EhJ4FDZr2jn9zlBtC3zxWaWAzKoIJiL6',
                'user_id': userId,
                'Authorization': `Bearer ${token}`
            };

            axios.get(apiUrl, { headers: headers })
                .then(function(response) {
                    if (response.data.status === "success") {
                        const encryptedResponseBase64 = response.data.data;
                        localStorage.setItem('encryptedProfileData', encryptedResponseBase64);

                        const decryptedData = decryptData(userId, username, encryptedResponseBase64);

                        // Handle the decrypted data
                        if (decryptedData) {
                            try {
                                const decryptedJson = JSON.parse(decryptedData);
                                if (decryptedJson.role_id === 4) {
                                    document.getElementById('alphaMenu').style.display = 'block';
                                }
                            } catch (error) {
                                alert('Failed to parse decrypted data.');
                                console.error(error);
                            }
                        } else {
                            alert('Failed to decrypt user profile data.');
                        }
                    } else {
                        alert('Token is not valid or user profile could not be fetched.');
                        window.location.href = '/login';
                    }
                })
                .catch(function(error) {
                    console.error('Error fetching profile:', error);
                    alert('An error occurred while validating the token.');
                });
        }

        // Function to decrypt the data using AES
        function decryptData(userId, username, encryptedResponse) {
            try {
                const input = username + userId;

                const sha256Hash = CryptoJS.SHA256(input).toString(CryptoJS.enc.Hex);
                const md5Hash = CryptoJS.MD5(input).toString(CryptoJS.enc.Hex);

                const keyHex = sha256Hash.substring(0, 32);
                const ivHex = md5Hash.substring(0, 16);

                const keyBase64 = btoa(keyHex);
                const ivBase64 = btoa(ivHex);
                const key = CryptoJS.enc.Base64.parse(keyBase64);
                const iv = CryptoJS.enc.Base64.parse(ivBase64);

                const decryptedData = CryptoJS.AES.decrypt(
                    {
                        ciphertext: CryptoJS.enc.Base64.parse(encryptedResponse)
                    },
                    key,
                    {
                        iv: iv,
                        mode: CryptoJS.mode.CBC,
                        padding: CryptoJS.pad.Pkcs7
                    }
                );

                return decryptedData.toString(CryptoJS.enc.Utf8);
            } catch (error) {
                console.error('Decryption failed:', error);
                return null;
            }
        }
    </script>
@endsection
