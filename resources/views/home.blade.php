@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card user-info-card mb-3">
                <div class="card-body d-flex align-items-center">
                    <div class="user-info">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-1" id="tpsName">TPS #0001</h5>
                        </div>
                        <p class="mb-0" id="addressTps">KEBON PEDES, TANAH SAREAL, BOGOR</p>
                    </div>
                </div>
            </div>

            <div id="alert-container"></div>
        </div>
        <div class="container mb-3">
            <div class="card comparison-table-two">
                <div class="card-body">
                    <table class="table mb-0" id="data_walkot">
                        <thead>
                            <tr>
                                <th>Calon Walikota</th>
                                <th width="120">Total Pemilih</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container mb-3">
            <div class="card comparison-table-two">
                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Surat Suara</th>
                                <th width="120">
                                    Total Data
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Total Surat Suara</th>
                                <td id="total_ballots"></td>
                            </tr>
                            <tr>
                                <th>Total Data Sah</th>
                                <td id="valid_votes"></td>
                            </tr>
                            <tr>
                                <th>Total Data Tidak Sah</th>
                                <td id="damaged_ballots"></td>
                            </tr>
                            <tr>
                                <th>Total Surat Rusak</th>
                                <td id="invalid_ballots"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="element-heading mt-3">
                                <h6>DATA DPT</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="single-gallery-item">
                                        <img id="dpt-photo" src="" alt="Data DPT" class="clickable-image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="element-heading mt-3">
                                <h6>DATA C6</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="single-gallery-item">
                                        <img id="c6-photo" src="" alt="Data C6" class="clickable-image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="element-heading mt-3">
                                <h6>DATA C1</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="single-gallery-item">
                                        <img id="c1-photo" src="" alt="Data C1" class="clickable-image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-3">
                            <div class="element-heading mt-3">
                                <h6>DATA CPLANO</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="single-gallery-item">
                                        <img id="cplano-photo" src="" alt="Data CPLANO" class="clickable-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <img id="modal-image" src="" alt="Selected Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <style>
            .single-gallery-item img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                border: 2px solid #333;
                border-radius: 8px;
                cursor: pointer;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                // When any image is clicked
                $('.clickable-image').on('click', function() {
                    var imgSrc = $(this).attr('src');
                    $('#modal-image').attr('src', imgSrc);
                    $('#imageModal').modal('show');
                });
            });
        </script>

    </div>
    @include('layouts.menu')
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"
        integrity="sha512-a+SUDuwNzXDvz4XrIcXHuCf089/iJAoN4lmrXJg18XnduKK6YlDHNRalv4yd1N40OKI80tFidF+rqTFKGPoWFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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

                        // Simpan data terenkripsi ke localStorage
                        localStorage.setItem('encryptedProfileData', encryptedResponseBase64);

                        // Dekripsi data
                        const decryptedDataString = decryptData(userId, username, encryptedResponseBase64);
                        if (decryptedDataString) {
                            try {
                                const decryptedData = JSON.parse(
                                decryptedDataString); // Ubah string hasil dekripsi menjadi JSON
                                console.log('Decrypted user profile data:', decryptedData);

                                // Cek apakah role_id adalah 4 (Alpha)
                                if (decryptedData.role_id === 4) {
                                    // Tampilkan menu TPS
                                    document.getElementById('alphaMenu').style.display = 'block';
                                }
                            } catch (error) {
                                console.error('Failed to parse decrypted data as JSON:', error);
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
    </script>

    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');
            const apiUrl = 'https://api.nxwtomoka.site/api/v1/tps/by-user';
            const defaultImage =
                'https://cdn-icons-png.flaticon.com/512/6598/6598519.png'; // Ganti dengan URL gambar default kamu

            fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        localStorage.setItem('district_id', data.data.tps.district_id);

                        document.getElementById('total_ballots').textContent =
                            (data.data.tps_data.total_ballots ?? 0).toLocaleString();

                        document.getElementById('valid_votes').textContent =
                            (data.data.tps_data.valid_votes ?? 0).toLocaleString();

                        document.getElementById('damaged_ballots').textContent =
                            (data.data.tps_data.damaged_ballots ?? 0).toLocaleString();

                        document.getElementById('invalid_ballots').textContent =
                            (data.data.tps_data.invalid_ballots ?? 0).toLocaleString();

                        document.getElementById('tpsName').textContent = "TPS #" + data.data.tps.tps_number;
                        document.getElementById('addressTps').textContent = data.data.tps.village + ", " + data
                            .data.tps.district + ", " + data.data.tps.city;

                        // Cek apakah setiap foto ada, jika tidak gunakan default image
                        document.getElementById('dpt-photo').src = data.data.tps_data.dpt_photo || defaultImage;
                        document.getElementById('c6-photo').src = data.data.tps_data.c6_photo || defaultImage;
                        document.getElementById('c1-photo').src = data.data.tps_data.c1_photo || defaultImage;
                        document.getElementById('cplano-photo').src = data.data.tps_data.cplano_photo ||
                            defaultImage;

                        displayStatusAlert(data.data.tps);
                        updatePageContent(data.data.paslon);
                    } else {
                        alert('No data found or invalid response');
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Failed to load data. Please try again.');
                });

            function updatePageContent(tpsData) {
                const tableBody = $('#data_walkot tbody');
                tableBody.empty();
                tableBody.attr('id', 'table-body');

                tpsData.forEach(item => {
                    const row = `
        <tr id="row-${item.id}">
            <th id="nama_wali_kota_${item.id}">${item.nama_wali_kota}</th>
            <td id="total_votes_${item.id}">${item.total_votes}</td>
        </tr>
    `;
                    tableBody.append(row);
                });
            }
        });
    </script>


    <script>
        function displayStatusAlert(tps) {
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = '';

            if (tps.status === 0) {
                alertContainer.innerHTML = `
            <div class="mb-3">
                <div class="alert custom-alert-three alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle"></i>
                    <div class="alert-text">
                        <h6>Belum melakukan laporan tps!</h6>
                        <span>Silahkan pergi ke halaman laporan untuk input data.</span>
                    </div>
                </div>
            </div>
        `;
            } else if (tps.status === 1) {
                alertContainer.innerHTML = `
            <div class="mb-3">
                <div class="alert custom-alert-three alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i>
                    <div class="alert-text">
                        <h6>Laporan TPS berhasil dilakukan!</h6>
                        <span>Terima kasih telah melakukan laporan.</span>
                    </div>
                </div>
            </div>
        `;
            }
        }

    </script>
@endsection
