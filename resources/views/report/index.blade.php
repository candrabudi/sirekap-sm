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
                            <input class="form-control" id="tps" type="text" placeholder="TPS 001"
                                value="TPS 0001" readonly>
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


                        <div class="row">
                            <div class="col-6 mt-3">
                                <div class="element-heading mb-3">
                                    <span>FOTO DPT</span>
                                </div>
                                <div class="form-group">
                                    <div class="image-upload-box" id="uploadArea1"
                                        style="border: 2px dashed #ccc; padding: 30px; cursor: pointer; border-radius: 8px; text-align: center;">
                                        <img id="previewImage1" class="d-none"
                                            style="max-width: 100%; height: 78px; border-radius: 8px;" />
                                        <img id="uploadIcon1" class="w-75" src="{{ asset('img/icon-image-upload.svg') }}"
                                            alt="Upload Icon">
                                        <span id="uploadText1" class="mb-4" style="font-size: 12px;">Upload Foto</span>
                                    </div>
                                    <input class="form-control d-none" name="dpt_photo" id="customFile1" type="file"
                                        accept="image/*">
                                    <button class="btn btn-secondary mt-2 d-none" id="previewButton1"
                                        type="button">Preview</button>
                                </div>
                            </div>

                            <div class="col-6 mt-3">
                                <div class="element-heading mb-3">
                                    <span>FOTO C6</span>
                                </div>
                                <div class="form-group">
                                    <div class="image-upload-box" id="uploadArea2"
                                        style="border: 2px dashed #ccc; padding: 30px; cursor: pointer; border-radius: 8px; text-align: center;">
                                        <img id="previewImage2" class="d-none"
                                            style="max-width: 100%; height: 78px; border-radius: 8px;" />
                                        <img id="uploadIcon2" class="w-75" src="{{ asset('img/icon-image-upload.svg') }}"
                                            alt="Upload Icon">
                                        <span id="uploadText2" class="mb-4" style="font-size: 12px;">Upload Foto</span>
                                    </div>
                                    <input class="form-control d-none" name="c6_photo" id="customFile2" type="file"
                                        accept="image/*">
                                    <button class="btn btn-secondary mt-2 d-none" id="previewButton2"
                                        type="button">Preview</button>
                                </div>
                            </div>

                            <div class="col-6 mt-3">
                                <div class="element-heading mb-3">
                                    <span>FOTO C1</span>
                                </div>
                                <div class="form-group">
                                    <div class="image-upload-box" id="uploadArea3"
                                        style="border: 2px dashed #ccc; padding: 30px; cursor: pointer; border-radius: 8px; text-align: center;">
                                        <img id="previewImage3" class="d-none"
                                            style="max-width: 100%; height: 78px; border-radius: 8px;" />
                                        <img id="uploadIcon3" class="w-75" src="{{ asset('img/icon-image-upload.svg') }}"
                                            alt="Upload Icon">
                                        <span id="uploadText3" class="mb-4" style="font-size: 12px;">Upload Foto</span>
                                    </div>
                                    <input class="form-control d-none" name="c1_photo" id="customFile3" type="file"
                                        accept="image/*">
                                    <button class="btn btn-secondary mt-2 d-none" id="previewButton3"
                                        type="button">Preview</button>
                                </div>
                            </div>

                            <div class="col-6 mt-3">
                                <div class="element-heading mb-3">
                                    <span>FOTO CPLANO</span>
                                </div>
                                <div class="form-group">
                                    <div class="image-upload-box" id="uploadArea4"
                                        style="border: 2px dashed #ccc; padding: 30px; cursor: pointer; border-radius: 8px; text-align: center;">
                                        <img id="previewImage4" class="d-none"
                                            style="max-width: 100%; height: 78px; border-radius: 8px;" />
                                        <img id="uploadIcon4" class="w-75"
                                            src="{{ asset('img/icon-image-upload.svg') }}" alt="Upload Icon">
                                        <span id="uploadText4" class="mb-4" style="font-size: 12px;">Upload Foto</span>
                                    </div>
                                    <input class="form-control d-none" name="cplano_photo" id="customFile4"
                                        type="file" accept="image/*">
                                    <button class="btn btn-secondary mt-2 d-none" id="previewButton4"
                                        type="button">Preview</button>
                                </div>
                            </div>
                        </div>


                        <div class="row" id="paslon-container">
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label" for="totalVotesInput">Input Juml. surat suara</label>
                            <input class="form-control" id="totalVotesInput" type="text"
                                placeholder="Input jumlah suara" oninput="calculateTotal()">
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


    <!-- Modal for upload options -->
    <div class="modal" tabindex="-1" id="uploadModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Metode Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary w-100" id="uploadFromFolder">Upload dari Folder</button>
                    <button class="btn btn-secondary w-100 mt-3" id="uploadFromCamera">Gunakan Kamera</button>
                </div>
            </div>
        </div>
    </div>

    <video id="cameraPreview" class="d-none" style="max-width: 100%; height: 78px; border-radius: 8px;" autoplay></video>

    <input class="form-control d-none" name="dpt_photo" id="customFile1" type="file" accept="image/*">
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

            function uploadImage(file, fieldName) {
                const formData = new FormData();
                formData.append(fieldName, file);

                const token = localStorage.getItem('token');

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
                    .catch(error => {
                        console.error('Upload failed:', error);
                    });
            }

            function handleFileInputChange(event, previewImageId, uploadIconId, uploadTextId, previewButtonId,
                fieldName) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(previewImageId).src = e.target.result;
                        document.getElementById(previewImageId).classList.remove('d-none');
                        document.getElementById(uploadIconId).classList.add('d-none');
                        document.getElementById(uploadTextId).classList.add('d-none');
                        document.getElementById(previewButtonId).classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);

                    uploadImage(file, fieldName);
                }
            }

            const tpsApiUrl = 'https://api.nxwtomoka.site/api/v1/tps/by-user';
            const tpsHeaders = {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            };

            axios.get(tpsApiUrl, {
                    headers: tpsHeaders
                })
                .then(function(response) {
                    console.log('TPS API response:', response.data);

                    const {
                        tps_data
                    } = response.data.data;

                    if (tps_data.dpt_photo) {
                        const previewImage = document.getElementById('previewImage1');
                        previewImage.src = tps_data.dpt_photo;
                        previewImage.classList.remove('d-none');
                        document.getElementById('uploadIcon1').classList.add('d-none');
                        document.getElementById('uploadText1').classList.add('d-none');
                    }

                    if (tps_data.c6_photo) {
                        const previewImage = document.getElementById('previewImage2');
                        previewImage.src = tps_data.c6_photo;
                        previewImage.classList.remove('d-none');
                        document.getElementById('uploadIcon2').classList.add('d-none');
                        document.getElementById('uploadText2').classList.add('d-none');
                    }

                    if (tps_data.c1_photo) {
                        const previewImage = document.getElementById('previewImage3');
                        previewImage.src = tps_data.c1_photo;
                        previewImage.classList.remove('d-none');
                        document.getElementById('uploadIcon3').classList.add('d-none');
                        document.getElementById('uploadText3').classList.add('d-none');
                    }

                    if (tps_data.cplano_photo) {
                        const previewImage = document.getElementById('previewImage4');
                        previewImage.src = tps_data.cplano_photo;
                        previewImage.classList.remove('d-none');
                        document.getElementById('uploadIcon4').classList.add('d-none');
                        document.getElementById('uploadText4').classList.add('d-none');
                    }
                })
                .catch(function(error) {
                    console.error('Error calling TPS API:', error);
                });

            const fieldNames = ['dpt_photo', 'c6_photo', 'c1_photo', 'cplano_photo'];

            function openUploadModal(index) {
                const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
                modal.show();

                document.getElementById('uploadFromFolder').addEventListener('click', function() {
                    document.getElementById(`customFile${index + 1}`).click();
                    document.getElementById('cameraPreview').classList.add('d-none');
                });

                document.getElementById('uploadFromCamera').addEventListener('click', function() {
                    const cameraPreview = document.getElementById('cameraPreview');
                    const fileInput = document.getElementById(`customFile${index + 1}`);
                    fileInput.classList.add('d-none'); // Hide the file input
                    cameraPreview.classList.remove('d-none'); // Show the camera preview

                    // Access camera
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

            ['uploadArea1', 'uploadArea2', 'uploadArea3', 'uploadArea4'].forEach((areaId, index) => {
                document.getElementById(areaId).addEventListener('click', function() {
                    openUploadModal(index);
                });
            });

            ['customFile1', 'customFile2', 'customFile3', 'customFile4'].forEach((fileId, index) => {
                document.getElementById(fileId).addEventListener('change', function(e) {
                    handleFileInputChange(e, `previewImage${index + 1}`, `uploadIcon${index + 1}`,
                        `uploadText${index + 1}`, `previewButton${index + 1}`, fieldNames[index]
                    );
                });
            });

            ['previewButton1', 'previewButton2', 'previewButton3', 'previewButton4'].forEach((buttonId, index) => {
                document.getElementById(buttonId).addEventListener('click', function() {
                    handleImagePreview(`previewImage${index + 1}`);
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
