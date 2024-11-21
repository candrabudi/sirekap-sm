@extends('layouts.app')
@section('title', 'Laporkan TPS')
@section('content')
    @include('layouts.sidebar')
    <div class="page-content-wrapper py-3">
        <div class="container mb-3">
            <div class="element-heading">
                <h6 id="headingReport">Laporkan Data <b>TPS 001</b></h6>
            </div>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="alert custom-alert-one alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-x-circle"></i>
                        Pastikan data yang diinput sudah benar, karna hanya bisa melakukan 1x submit laporan tps!
                    </div>
                    <form action="#" method="POST" id="tpsForm">
                        <input type="hidden" id="tpsID" value="">
                        <div class="form-group">
                            <label class="form-label" for="tps">TPS</label>
                            <input class="form-control" id="tps" type="text" placeholder="TPS 001" value="TPS 0001"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="coordinates">Titik Koordinat</label>
                            <input class="form-control" id="coordinates" type="text" placeholder="Coordinates" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="locationDetails">Detail Lokasi</label>
                            <input class="form-control" id="locationDetails" type="text" placeholder="Detail Lokasi"
                                readonly>
                        </div>


                        @php
                            $photos = [
                                ['label' => 'FOTO DPT', 'name' => 'dpt_photo', 'id' => 1],
                                ['label' => 'FOTO C6', 'name' => 'c6_photo', 'id' => 2],
                                ['label' => 'FOTO C1', 'name' => 'c1_photo', 'id' => 3],
                                ['label' => 'FOTO CPLANO', 'name' => 'cplano_photo', 'id' => 4],
                            ];
                        @endphp

                        <div class="row mb-4">
                            @foreach ($photos as $photo)
                                <div class="col-6 mt-3">
                                    <div class="element-heading mb-3">
                                        <span>{{ $photo['label'] }}</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="image-upload-box" id="uploadArea{{ $photo['id'] }}"
                                            style="border: 2px dashed #ccc; cursor: pointer; border-radius: 8px; text-align: center; padding: 5px; width: 100%; height: 200px; background-color: #f7f7f7; position: relative;">
                                            <img id="previewImage{{ $photo['id'] }}" class="d-none"
                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; position: absolute; top: 0; left: 0;" />
                                            <img id="uploadIcon{{ $photo['id'] }}" class="w-75"
                                                src="{{ asset('img/icon-image-upload.svg') }}" alt="Upload Icon"
                                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            <span id="uploadText{{ $photo['id'] }}" class="mb-4"
                                                style="font-size: 12px; position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);">Upload
                                                Foto</span>
                                        </div>
                                        <input class="form-control d-none" name="{{ $photo['name'] }}"
                                            id="customFile{{ $photo['id'] }}" type="file" accept="image/*"
                                            capture="camera">
                                        <button type="button" class="btn btn-sm btn-secondary mt-2 d-none"
                                            id="previewButton{{ $photo['id'] }}" type="button">Preview</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <h4 class="mb-2">Voting Paslon</h4>
                        <div class="row" id="paslon-container">
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label" for="totalVotesInput">Input Juml. surat suara</label>
                            <input class="form-control" id="totalVotesInput" type="number" placeholder="Input jumlah suara"
                                oninput="calculateTotal()" onkeydown="preventInvalidInput(event)" oninput="removeInvalidCharacters(this)">
                        </div>
                        
                        <div class="form-group mt-3">
                            <label class="form-label" for="calculatedResult">Juml. surat suara + Juml. surat suara x 2,5%</label>
                            <input class="form-control" id="calculatedResult" type="number" placeholder="Hasil perhitungan" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="damagedBallots">Surat suara rusak</label>
                            <input class="form-control" id="damagedBallots" type="number" placeholder="Total surat suara rusak"
                                onkeydown="preventInvalidInput(event)" oninput="removeInvalidCharacters(this)">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="validVotes">Surat suara sah</label>
                            <input class="form-control" id="validVotes" type="number" placeholder="Total surat suara sah"
                                onkeydown="preventInvalidInput(event)" oninput="removeInvalidCharacters(this)">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="invalidVotes">Surat suara tidak sah</label>
                            <input class="form-control" id="invalidVotes" type="number" placeholder="Total surat suara tidak sah"
                                onkeydown="preventInvalidInput(event)" oninput="removeInvalidCharacters(this)">
                        </div>
                        
                        <script>
                        // Fungsi untuk mencegah karakter "-" dan "e"
                        function preventInvalidInput(event) {
                            if (event.key === '-' || event.key === 'e' || event.key === '+' || event.key === '.') {
                                event.preventDefault();
                            }
                        }
                        
                        // Fungsi untuk menghapus karakter non-digit
                        function removeInvalidCharacters(input) {
                            input.value = input.value.replace(/[^0-9]/g, '');
                        }
                        </script>
                        

                        <p class="text-danger mt-2 mb" style="font-size: 12px;">
                            Pastikan data yang diinput sudah benar, karna hanya bisa melakukan 1x submit laporan tps!
                        </p>
                        <button class="btn w-100 d-flex align-items-center justify-content-center mt-2"
                            style="background: #6C00EB; border-radius: 50px;color: #FFFFFF;" type="button"
                            id="submitFormBtn">
                            Simpan
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Konfirmasi Data</h6>
                    <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin dengan data yang telah Anda masukkan?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button id="confirmSubmitBtn" class="btn btn-sm btn-success" type="button">Ya, Kirim Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalPreviewImage" class="w-100" src="" alt="Image Preview">
                </div>
            </div>
        </div>
    </div>


    @include('layouts.menu')
    <style>
        .modal-dialog-centered {
            max-width: 90vw;
            max-height: 90vh;
        }

        #modalImagePreview {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>

    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Preview Foto Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImagePreview" style="max-width: 100%; max-height: 100%;" />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"
        integrity="sha512-a+SUDuwNzXDvz4XrIcXHuCf089/iJAoN4lmrXJg18XnduKK6YlDHNRalv4yd1N40OKI80tFidF+rqTFKGPoWFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.js"></script>

    <script>
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
            const token = localStorage.getItem('token');
            const userId = localStorage.getItem('user_id');
            const username = localStorage.getItem('username');

            if (token && userId && username) {
                validateToken(token, userId, username);
            } else {
                alert('No valid authentication token found. Please log in.');
                window.location.href = '/login';
            }

            if (!navigator.geolocation) {
                alert("Lokasi tidak tersedia di perangkat ini. Silakan aktifkan lokasi.");
                $(".homepage").hide();
                const offlineMessage = `
                    <div class="container">
                        <div class="card text-center px-3">
                            <div class="card-body">
                                <i class="bi display-1 bi-wifi-off text-danger mb-2"></i>
                                <h5>Tidak ada koneksi internet!</h5>
                                <p class="mb-0">Sepertinya Anda sedang offline, silakan periksa koneksi internet Anda. Halaman ini tidak mendukung saat Anda offline!</p>
                            </div>
                        </div>
                    </div>
                `;
                $(".page-content-wrapper").html(offlineMessage);
                return;
            }

            navigator.geolocation.getCurrentPosition(function(position) {
                console.log('Lokasi pengguna: ', position.coords.latitude, position.coords.longitude);
            }, function(error) {
                if (error.code === error.PERMISSION_DENIED) {
                    $(".homepage").hide();

                    const permissionMessage = `
                        <div class="container">
                            <div class="card text-center px-3">
                                <div class="card-body">
                                    <i class="bi display-1 bi-geo-alt text-danger mb-2"></i>
                                    <h5>Permission Ditolak</h5>
                                    <p class="mb-0">Anda perlu mengaktifkan izin lokasi untuk melanjutkan menggunakan halaman ini.</p>
                                </div>
                            </div>
                        </div>
                    `;
                    $(".page-content-wrapper").html(permissionMessage);
                    $("#enable-location").on('click', function() {
                        alert(
                            "Kami akan meminta izin lokasi Anda sekarang. Silakan izinkan untuk melanjutkan."
                        );
                        navigator.geolocation.getCurrentPosition(function(position) {
                            console.log('Lokasi pengguna: ', position.coords.latitude,
                                position.coords.longitude);
                            location.reload();
                        }, function(error) {
                            alert("Gagal mendapatkan lokasi. Silakan coba lagi.");
                        });
                    });
                } else {
                    alert("Gagal mendapatkan lokasi. Silakan coba lagi.");
                }
            });
        });

        function validateToken(token, userId, username) {
            const apiUrl = '{{ env('API_URL') }}/v2/user/get-profile';
            const headers = {
                'api_key': 'EhJ4FDZr2jn9zlBtC3zxWaWAzKoIJiL6',
                'user_id': userId,
                'Authorization': `Bearer ${token}`
            };

            axios.get(apiUrl, {
                    headers: headers
                })
                .then(function(response) {
                    if (response.data.status === "success") {
                        const encryptedResponseBase64 = response.data.data;
                        localStorage.setItem('encryptedProfileData', encryptedResponseBase64);
                        const decryptedData = decryptData(userId, username, encryptedResponseBase64);
                        if (decryptedData) {
                            try {
                                callTpsApi(token);
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

        function decryptData(userId, username, encryptedResponse) {
            const input = username + userId;

            const sha256Hash = CryptoJS.SHA256(input).toString(CryptoJS.enc.Hex);
            const md5Hash = CryptoJS.MD5(input).toString(CryptoJS.enc.Hex);

            const keyHex = sha256Hash.substring(0, 32);
            const ivHex = md5Hash.substring(0, 16);

            const keyBase64 = btoa(keyHex);
            const ivBase64 = btoa(ivHex);
            const key = CryptoJS.enc.Base64.parse(keyBase64);
            const iv = CryptoJS.enc.Base64.parse(ivBase64);

            const decryptedData = CryptoJS.AES.decrypt({
                ciphertext: CryptoJS.enc.Base64.parse(encryptedResponse)
            }, key, {
                iv: iv,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            });

            return decryptedData.toString(CryptoJS.enc.Utf8);
        }

        function callTpsApi(token) {
            const tpsApiUrl = '{{ env('API_URL') }}/v1/tps/by-user';
            const tpsHeaders = {
                'Authorization': `Bearer ${token}`
            };

            axios.get(tpsApiUrl, {
                    headers: tpsHeaders
                })
                .then(function(response) {
                    console.log('TPS API response:', response.data);

                    const {
                        tps,
                        paslon,
                        tps_data
                    } = response.data.data;

                    if (tps.status === 1) {
                        window.location.href = '/report/success';
                        return;
                    }

                    localStorage.setItem('tpsData', JSON.stringify(response.data.data));

                    const tpsID = document.getElementById('tpsID');
                    const tpsNumber = document.getElementById('tps');
                    const totalVotesInput = document.getElementById('totalVotesInput');
                    const calculatedResult = document.getElementById('calculatedResult');
                    const damagedBallots = document.getElementById('damagedBallots');
                    const invalidVotes = document.getElementById('invalidVotes');
                    const headingReport = document.getElementById('headingReport');
                    headingReport.innerHTML = "Laporkan Data <b>TPS " + tps.tps_number + "</b>";
                    if (tpsID || tpsNumber) {
                        let totalVotes = tps_data.total_ballots;
                        let reducedVotes = totalVotes - (totalVotes * 0.025);
                        reducedVotes = Math.round(reducedVotes);
                        tpsID.value = tps.id;
                        tpsNumber.value = "TPS " + tps.tps_number
                        totalVotesInput.value = reducedVotes;
                        calculatedResult.value = tps_data.total_ballots
                        invalidVotes.value = tps_data.invalid_votes
                        validVotes.value = tps_data.valid_votes
                        damagedBallots.value = tps_data.damaged_ballots
                    } else {
                        console.warn('Input field for TPS ID not found.');
                    }

                    const paslonContainer = document.getElementById('paslon-container');
                    if (paslonContainer) {
                        paslonContainer.innerHTML = '';

                        paslon.forEach((paslon, index) => {
                            const paslonDiv = document.createElement('div');
                            paslonDiv.classList.add('col-6');

                            paslonDiv.innerHTML = `
            <div class="element-heading" style="border: 2px solid #ccc; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                <img src="${paslon.foto_paslon}" alt="Foto Paslon ${paslon.nama_wali_kota}" 
                    style="width: 100%; height: auto; margin-bottom: 10px; border-bottom: 2px solid #ccc; padding-bottom: 10px;">
                <label class="form-label" for="paslon_${index}">${paslon.nama_wali_kota}</label>
                <div class="form-group">
                    <input class="form-control" id="paslon_${index}" type="number"
                        placeholder="Masukan suara untuk ${paslon.nama_wali_kota}" value="${paslon.total_votes}">
                </div>
            </div>
        `;

                            // Ambil elemen input setelah ditambahkan ke DOM
                            const inputElement = paslonDiv.querySelector(`#paslon_${index}`);

                            // Event listener untuk mencegah karakter "-" dan "e"
                            inputElement.addEventListener('keydown', function(event) {
                                if (event.key === '-' || event.key === 'e' || event.key === '+' || event
                                    .key === '.') {
                                    event.preventDefault();
                                }
                            });

                            // Event listener untuk memastikan input hanya angka positif
                            inputElement.addEventListener('input', function(event) {
                                // Hapus karakter yang tidak diinginkan (non-digit)
                                this.value = this.value.replace(/[^0-9]/g, '');
                            });

                            paslonContainer.appendChild(paslonDiv);
                        });
                    } else {
                        console.warn('Paslon container not found.');
                    }



                })
                .catch(function(error) {
                    console.error('Error calling TPS API:', error);
                });
        }
    </script>

    <script>
        function checkFormValidity() {
            const textInputs = document.querySelectorAll('input[type="text"]');
            const numberInputs = document.querySelectorAll('input[type="number"]');

            let allFilled = true;

            // Cek setiap input bertipe text dan number apakah ada yang kosong
            textInputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    allFilled = false;
                }
            });

            numberInputs.forEach(function(input) {
                if (input.value.trim() === '' || isNaN(input.value) || input.value < 0) {
                    allFilled = false;
                }
            });
            document.getElementById('submitFormBtn').disabled = !allFilled;
        }

        document.querySelectorAll('input[type="text"], input[type="number"]').forEach(function(input) {
            input.addEventListener('input', checkFormValidity);
        });

        document.addEventListener('DOMContentLoaded', function() {
            checkFormValidity();
        });

        function isPositiveNumber(value) {
            return !isNaN(value) && value >= 0;
        }

        document.getElementById('submitFormBtn').addEventListener('click', function() {
            const modalElement = document.getElementById('staticBackdrop');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });

        document.getElementById('confirmSubmitBtn').addEventListener('click', function() {
            const tpsID = document.getElementById('tpsID').value;
            const coordinates = document.getElementById('coordinates').value;
            const locationDetails = document.getElementById('locationDetails').value;
            const totalVotes = document.getElementById('totalVotesInput').value;
            const damagedBallots = document.getElementById('damagedBallots').value;
            const validVotes = document.getElementById('validVotes').value;
            const invalidVotes = document.getElementById('invalidVotes').value;

            const paslon = [];
            const paslonInputs = document.querySelectorAll('[id^="paslon_"]');
            paslonInputs.forEach(function(input, index) {
                const id = input.getAttribute('id').split('_')[1];
                paslon.push({
                    id: id,
                    total_votes: input.value
                });
            });

            let errorMessage = '';
            if (tpsID === '' || coordinates === '' || locationDetails === '') {
                errorMessage += 'Field TPS ID, Koordinat, dan Detail Lokasi harus diisi.\n';
            }
            if (!isPositiveNumber(totalVotes)) {
                errorMessage += 'Total Suara harus berupa angka positif.\n';
            }
            if (!isPositiveNumber(damagedBallots)) {
                errorMessage += 'Surat Suara Rusak harus berupa angka positif.\n';
            }
            if (!isPositiveNumber(validVotes)) {
                errorMessage += 'Suara Sah harus berupa angka positif.\n';
            }
            if (!isPositiveNumber(invalidVotes)) {
                errorMessage += 'Suara Tidak Sah harus berupa angka positif.\n';
            }
            paslon.forEach(function(item, index) {
                if (!isPositiveNumber(item.total_votes)) {
                    errorMessage += `Jumlah suara untuk paslon ${index + 1} harus berupa angka positif.\n`;
                }
            });

            if (errorMessage !== '') {
                alert(errorMessage);
                return;
            }

            const formData = new FormData();
            formData.append('coordinate_location', coordinates);
            formData.append('detail_location', locationDetails);
            formData.append('total_ballots', totalVotes);
            formData.append('damaged_ballots', damagedBallots);
            formData.append('valid_votes', validVotes);
            formData.append('invalid_votes', invalidVotes);

            paslon.forEach(function(item, index) {
                formData.append(`paslon[${index}][id]`, parseInt(item.id) + 1);
                formData.append(`paslon[${index}][total_votes]`, item.total_votes);
            });

            const token = localStorage.getItem('token');

            axios.post(`{{ env('API_URL') }}/v1/tps/by-user/store/${tpsID}`, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    if (response.data.status === 'success') {
                        // Show SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Dikirim',
                            text: 'Data Anda telah berhasil disimpan!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'staticBackdrop'));
                                modal.hide();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menyimpan data, coba lagi!',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(function(error) {
                    console.error('Error submitting the form: ', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat menyimpan data.',
                        confirmButtonText: 'OK'
                    });
                });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tpsData = JSON.parse(localStorage.getItem('tpsData'));
            const tpsID = tpsData.tps.id;
            const apiUrl = `{{ env('API_URL') }}/v1/tps/by-user/store/${tpsID}`;
            const token = localStorage.getItem('token');

            const fields = [{
                    name: 'dpt_photo',
                    previewImageId: 'previewImage1',
                    uploadAreaId: 'uploadArea1',
                    uploadIconId: 'uploadIcon1',
                    uploadTextId: 'uploadText1',
                    previewButtonId: 'previewButton1',
                    customFileId: 'customFile1'
                },
                {
                    name: 'c6_photo',
                    previewImageId: 'previewImage2',
                    uploadAreaId: 'uploadArea2',
                    uploadIconId: 'uploadIcon2',
                    uploadTextId: 'uploadText2',
                    previewButtonId: 'previewButton2',
                    customFileId: 'customFile2'
                },
                {
                    name: 'c1_photo',
                    previewImageId: 'previewImage3',
                    uploadAreaId: 'uploadArea3',
                    uploadIconId: 'uploadIcon3',
                    uploadTextId: 'uploadText3',
                    previewButtonId: 'previewButton3',
                    customFileId: 'customFile3'
                },
                {
                    name: 'cplano_photo',
                    previewImageId: 'previewImage4',
                    uploadAreaId: 'uploadArea4',
                    uploadIconId: 'uploadIcon4',
                    uploadTextId: 'uploadText4',
                    previewButtonId: 'previewButton4',
                    customFileId: 'customFile4'
                }
            ];

            function uploadImage(file, fieldName) {
                const formData = new FormData();
                formData.append(fieldName, file);

                fetch(apiUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Authorization': `Bearer ${token}`,
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Upload successful:', data);
                    })
                    .catch(error => console.error('Upload failed:', error));
            }

            function handleFileInputChange(event, field) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewImage = document.getElementById(field.previewImageId);
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('d-none');
                        previewImage.style.objectFit = 'cover'; // Ensures no space in the image preview
                        document.getElementById(field.uploadIconId).classList.add('d-none');
                        document.getElementById(field.uploadTextId).classList.add('d-none');
                        document.getElementById(field.previewButtonId).classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                    uploadImage(file, field.name);
                }
            }

            // Open modal to show image preview
            function openImageModal(imageSrc) {
                const modalImage = document.getElementById('modalPreviewImage');
                modalImage.src = imageSrc;
                const myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                myModal.show();
            }

            fields.forEach((field, index) => {
                document.getElementById(field.uploadAreaId).addEventListener('click', function() {
                    document.getElementById(field.customFileId).click();
                });

                document.getElementById(field.customFileId).addEventListener('change', function(e) {
                    handleFileInputChange(e, field);
                });

                // Check if the image URL exists and show the preview button
                document.getElementById(field.previewButtonId).addEventListener('click', function() {
                    const previewImage = document.getElementById(field.previewImageId);
                    if (previewImage.src) {
                        openImageModal(previewImage.src);
                    }
                });
            });

            const tpsApiUrl = '{{ env('API_URL') }}/v1/tps/by-user';
            const tpsHeaders = {
                'Authorization': `Bearer ${token}`
            };

            axios.get(tpsApiUrl, {
                    headers: tpsHeaders
                })
                .then(function(response) {
                    const {
                        tps_data
                    } = response.data.data;

                    fields.forEach(field => {
                        if (tps_data[field.name]) {
                            const previewImage = document.getElementById(field.previewImageId);
                            previewImage.src = tps_data[field.name];
                            previewImage.classList.remove('d-none');
                            previewImage.style.objectFit =
                                'cover'; // Ensures no space in the image preview
                            document.getElementById(field.uploadIconId).classList.add('d-none');
                            document.getElementById(field.uploadTextId).classList.add('d-none');
                            // Show preview button if image URL exists
                            document.getElementById(field.previewButtonId).classList.remove('d-none');
                        }
                    });
                })
                .catch(function(error) {
                    console.error('Error calling TPS API:', error);
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    document.getElementById('coordinates').value = latitude + ', ' + longitude;
                    var apiKey = '3df4ea2d85f14fafb5c630c45b49fae6';
                    var geocodeUrl =
                        `https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=${apiKey}`;

                    fetch(geocodeUrl)
                        .then(response => response.json())
                        .then(data => {
                            if (data.results && data.results[0]) {
                                var location = data.results[0].components;
                                document.getElementById('locationDetails').value = location.village +
                                    ', ' + location.suburb + ', ' + location.residential + ', ' +
                                    location.city + ', ' + location.postcode + ', ' + location.country;
                            } else {
                                alert('Location details not found.');
                            }
                        })
                        .catch(error => {
                            alert('Error fetching location details: ' + error);
                        });
                }, function(error) {
                    alert('Error getting location: ' + error.message);
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });
    </script>
@endsection
