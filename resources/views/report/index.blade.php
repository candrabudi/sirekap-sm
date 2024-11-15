@extends('layouts.app')

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

                        <div class="row">
                            @foreach ($photos as $photo)
                                <div class="col-6 mt-3">
                                    <div class="element-heading mb-3">
                                        <span>{{ $photo['label'] }}</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="image-upload-box" id="uploadArea{{ $photo['id'] }}"
                                            style="border: 2px dashed #ccc; padding: 30px; cursor: pointer; border-radius: 8px; text-align: center;"
                                            data-bs-toggle="modal" data-bs-target="#uploadModal"
                                            data-photo-id="{{ $photo['id'] }}">
                                            <img id="previewImage{{ $photo['id'] }}" class="d-none"
                                                style="max-width: 100%; height: 78px; border-radius: 8px;" />
                                            <img id="uploadIcon{{ $photo['id'] }}" class="w-75"
                                                src="{{ asset('img/icon-image-upload.svg') }}" alt="Upload Icon">
                                            <span id="uploadText{{ $photo['id'] }}" class="mb-4"
                                                style="font-size: 12px;">Upload Foto</span>
                                        </div>
                                        <input class="form-control d-none" name="{{ $photo['name'] }}"
                                            id="customFile{{ $photo['id'] }}" type="file" accept="image/*">
                                        <button type="button" class="btn btn-secondary mt-2 d-none"
                                            id="previewButton{{ $photo['id'] }}" type="button">Preview</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="modal" tabindex="-1" id="uploadModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pilih Metode Upload</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <button type="button" class="btn btn-primary w-100" id="uploadFromFolder">Upload
                                            dari
                                            Folder</button>
                                        <button type="button" class="btn btn-secondary w-100 mt-3"
                                            id="uploadFromCamera">Gunakan
                                            Kamera</button>
                                        <div class="mt-3 d-none" id="cameraSection">
                                            <video id="cameraPreview"
                                                style="max-width: 100%; height: auto; border-radius: 8px;" autoplay></video>
                                            <button type="button" class="btn btn-danger w-100 mt-3" id="takePhoto">Ambil
                                                Foto</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="paslon-container">
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label" for="totalVotesInput">Input Juml. surat suara</label>
                            <input class="form-control" id="totalVotesInput" type="text" placeholder="Input jumlah suara"
                                oninput="calculateTotal()">
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label" for="calculatedResult">Juml. surat suara + Juml. surat suara x
                                2,5%</label>
                            <input class="form-control" id="calculatedResult" type="text"
                                placeholder="Hasil perhitungan" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tps">Surat suara rusak</label>
                            <input class="form-control" id="damagedBallots" type="text"
                                placeholder="Total surat suara rusak">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tps">Surat suara tidak sah</label>
                            <input class="form-control" id="invalidVotes" type="text"
                                placeholder="Total surat suara tidak sah">
                        </div>

                        <button class="btn w-100 d-flex align-items-center justify-content-center"
                            style="background: #6C00EB; border-radius: 50px;color: #FFFFFF;" type="button"
                            id="submitFormBtn">
                            Simpan
                        </button>
                    </form>

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
        });

        function validateToken(token, userId, username) {
            const apiUrl = 'https://api.nxwtomoka.site/api/v2/user/get-profile';
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
                            callTpsApi(token);
                            console.log('Decrypted user profile data:', decryptedData);
                        } else {
                            alert('Failed to decrypt user profile data.');
                        }
                    } else {
                        alert('Token is not valid or user profile could not be fetched.');
                        window.location.href = '/login';
                    }
                })
                .catch(function(error) {
                    console.error(error);
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
            const tpsApiUrl = 'https://api.nxwtomoka.site/api/v1/tps/by-user';
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
                        paslon
                    } = response.data.data;

                    if (tps.status === 1) {
                        window.location.href = '/report/success';
                        return;
                    }

                    localStorage.setItem('tpsData', JSON.stringify(response.data.data));

                    const tpsID = document.getElementById('tpsID');
                    const tpsNumber = document.getElementById('tps');
                    const headingReport = document.getElementById('headingReport');
                    headingReport.innerHTML = "Laporkan Data <b>TPS " + tps.tps_number + "</b>";
                    if (tpsID || tpsNumber) {
                        tpsID.value = tps.id;
                        tpsNumber.value = "TPS " + tps.tps_number
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
                        <div class="element-heading">
                            <label class="form-label" for="paslon_${index}">${paslon.nama_wali_kota}</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="paslon_${index}" type="text"
                                placeholder="Masukan suara untuk ${paslon.nama_wali_kota}" value="${paslon.total_votes}">
                        </div>
                    `;

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
        document.getElementById('submitFormBtn').addEventListener('click', function() {
            const tpsID = document.getElementById('tpsID').value;
            const coordinates = document.getElementById('coordinates').value;
            const locationDetails = document.getElementById('locationDetails').value;
            const totalVotes = document.getElementById('totalVotesInput').value;
            const damagedBallots = document.getElementById('damagedBallots').value;
            const invalidVotes = document.getElementById('invalidVotes').value;

            const paslon = [];
            const paslonInputs = document.querySelectorAll('[id^="paslon_"]');
            paslonInputs.forEach(function(input, index) {
                const id = input.getAttribute('id').split('_')[1]; // Extract paslon index
                paslon.push({
                    id: id,
                    total_votes: input.value
                });
            });

            const formData = new FormData();
            formData.append('coordinate_location', coordinates);
            formData.append('detail_location', locationDetails);
            formData.append('total_ballots', totalVotes);
            formData.append('damaged_ballots', damagedBallots);
            formData.append('valid_votes', invalidVotes);

            paslon.forEach(function(item, index) {
                formData.append(`paslon[${index}][id]`, parseInt(item.id) + 1);
                formData.append(`paslon[${index}][total_votes]`, item.total_votes);
            });


            const token = localStorage.getItem('token');

            axios.post(`https://api.nxwtomoka.site/api/v1/tps/by-user/store/${tpsID}`, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    if (response.data.status === 'success') {
                        alert('Data has been successfully saved.');
                        console.log(response.data);
                    } else {
                        alert('Failed to save data.');
                    }
                })
                .catch(function(error) {
                    console.error('Error submitting the form: ', error);
                    alert('There was an error saving the data.');
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tpsData = JSON.parse(localStorage.getItem('tpsData'));
            const tpsID = tpsData.tps.id;
            const apiUrl = `https://api.nxwtomoka.site/api/v1/tps/by-user/store/${tpsID}`;
            const token = localStorage.getItem('token');

            // Data related to input
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
                        const modal = bootstrap.Modal.getInstance(document.getElementById('uploadModal'));
                        modal.hide();
                    })
                    .catch(error => console.error('Upload failed:', error));
            }


            function handleFileInputChange(event, field) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(field.previewImageId).src = e.target.result;
                        document.getElementById(field.previewImageId).classList.remove('d-none');
                        document.getElementById(field.uploadIconId).classList.add('d-none');
                        document.getElementById(field.uploadTextId).classList.add('d-none');
                        document.getElementById(field.previewButtonId).classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                    uploadImage(file, field.name);
                }
            }

            const tpsApiUrl = 'https://api.nxwtomoka.site/api/v1/tps/by-user';
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
                            document.getElementById(field.uploadIconId).classList.add('d-none');
                            document.getElementById(field.uploadTextId).classList.add('d-none');
                        }
                    });
                })
                .catch(function(error) {
                    console.error('Error calling TPS API:', error);
                });

            function openUploadModal(field) {
                const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
                modal.show();

                document.getElementById('uploadFromFolder').addEventListener('click', function() {
                    document.getElementById(field.customFileId).click();
                    document.getElementById('cameraPreview').classList.add('d-none');
                });

                document.getElementById('uploadFromCamera').addEventListener('click', function() {
                    const cameraPreview = document.getElementById('cameraPreview');
                    const fileInput = document.getElementById(field.customFileId);
                    fileInput.classList.add('d-none');
                    cameraPreview.classList.remove('d-none');

                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({
                                video: true
                            })
                            .then(function(stream) {
                                cameraPreview.srcObject = stream;
                                cameraPreview.play();
                            })
                            .catch(function(error) {
                                alert('Camera access failed: ' + error);
                            });
                    }
                });
            }

            fields.forEach((field, index) => {
                document.getElementById(field.uploadAreaId).addEventListener('click', function() {
                    openUploadModal(field);
                });

                document.getElementById(field.customFileId).addEventListener('change', function(e) {
                    handleFileInputChange(e, field);
                });

                document.getElementById(field.previewButtonId).addEventListener('click', function() {
                    handleImagePreview(field.previewImageId);
                });
            });

            const modalElement = document.getElementById('uploadModal');
            modalElement.addEventListener('hidden.bs.modal', function() {
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            let selectedPhotoId = null;
            let cameraStream = null;

            document.querySelectorAll('[data-bs-target="#uploadModal"]').forEach(function(uploadArea) {
                uploadArea.addEventListener('click', function() {
                    selectedPhotoId = this.getAttribute('data-photo-id');
                });
            });

            document.getElementById('takePhoto').addEventListener('click', function() {
                const video = document.getElementById('cameraPreview');
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                canvas.toBlob(function(blob) {
                    const file = new File([blob], `photo_${selectedPhotoId}.jpg`, {
                        type: 'image/jpeg'
                    });

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(`previewImage${selectedPhotoId}`).src = e.target
                            .result;
                        document.getElementById(`previewImage${selectedPhotoId}`).classList
                            .remove('d-none');
                        document.getElementById(`uploadIcon${selectedPhotoId}`).classList.add(
                            'd-none');
                        document.getElementById(`uploadText${selectedPhotoId}`).classList.add(
                            'd-none');
                        document.getElementById(`previewButton${selectedPhotoId}`).classList
                            .remove('d-none');
                    };
                    reader.readAsDataURL(file);

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById(`customFile${selectedPhotoId}`).files = dataTransfer
                        .files;

                    if (cameraStream) {
                        cameraStream.getTracks().forEach(track => track.stop());
                    }
                    document.getElementById('cameraSection').classList.add('d-none');
                });
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
