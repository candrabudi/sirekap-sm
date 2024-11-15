@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div class="page-content-wrapper py-3">
        <div class="container mb-3">
            <div class="element-heading">
                <h6>Data TPS</h6>
            </div>
        </div>
        <div class="container mb-4">
            <div class="card">
                <div class="card-body">
                    <form class="mb-3 pb-4 border-bottom" action="#">
                        <div class="input-group">
                            <input class="form-control form-control-clicked" type="search" id="search"
                                placeholder="Search">
                            <button class="btn btn-dark" type="submit"><i class="bi bi-search fz-14"></i></button>
                        </div>
                    </form>

                    <form action="#" method="GET">
                        <div class="form-group">
                            <label class="form-label" for="village">Kelurahan</label>
                            <select class="form-select form-control-clicked" id="village" name="village"
                                aria-label="Default select example">
                                <option value="" selected>Pilih Kelurahan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select form-control-clicked" id="status" name="status"
                                aria-label="Default select example">
                                <option value="" selected>Pilih Status</option>
                                <option value="1">Selesai</option>
                                <option value="0">Belum Selesai</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container" id="tps-list">

        </div>

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
            const districtID = localStorage.getItem('district_id');
            const apiUrl = 'https://api.nxwtomoka.site/api/v1/tps/coordinator/list';
            const villageApiUrl =
            `https://api.nxwtomoka.site/api/v1/tps/villages?district_id=${districtID}`; // API endpoint to get villages

            // Fetch village data
            fetch(villageApiUrl, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.data) {
                        const villages = data.data;
                        villages.forEach(village => {
                            $('#village').append(
                                `<option value="${village.id}">${village.village_name}</option>`
                            );
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching village data:', error);
                });

            // Function to fetch and filter TPS list based on selected filters
            function fetchTpsList(villageId = '', status = '') {
                let filterUrl = apiUrl;
                if (villageId) filterUrl += `?village_id=${villageId}`;
                if (status !== '') filterUrl += villageId ? `&status=${status}` : `?status=${status}`;

                fetch(filterUrl, {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.data) {
                            const tpsList = data.data;
                            $('#tps-list').empty(); // Clear the previous list
                            tpsList.forEach(tps => {
                                let statusBadge = tps.status === 1 ?
                                    '<span class="m-1 badge rounded-pill custom-badge-success">Selesai</span>' :
                                    '<span class="m-1 badge rounded-pill custom-badge-pending">Belum Selesai</span>';

                                let tpsUserHtml = tps.tps_user.length > 0 ?
                                    '<p style="color: #6C00EB;font-weight: bold;">Saksi Sudah Ada</p>' :
                                    '<p style="color: #6C00EB;font-weight: bold;">Belum Ada Saksi</p>';

                                $('#tps-list').append(`
                                <div class="card product-details-card mb-3 direction-rtl" style="border: 4px solid #99BBFF; border-radius: 12px;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6>🗳️ TPS #${tps.tps_number}</h6>
                                            ${statusBadge}
                                        </div>
                                        <div class="row mt-2">
                                            <span style="color: #B5B5B5; font-size: 14px;">Lokasi</span>
                                            <p style="color: #000000">${tps.city}, ${tps.district}, ${tps.village}</p>
                                            <span style="color: #B5B5B5; font-size: 14px;">Total saksi: ${tps.tps_user.length}</span>
                                            <div class="d-flex justify-content-between align-items-center">
                                                ${tpsUserHtml}
                                                <a href="/tps/detail/${tps.id}">
                                                <p style="color: #6C00EB;font-weight: bold;">
                                                    Tap untuk detail 
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4" />
                                                    </svg>
                                                </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching the TPS data:', error);
                    });
            }

            // Initial load of TPS list
            fetchTpsList();

            // Fetch TPS list when village is changed
            $('#village').change(function() {
                const villageId = $(this).val();
                const status = $('#status').val();
                fetchTpsList(villageId, status);
            });

            // Fetch TPS list when status is changed
            $('#status').change(function() {
                const status = $(this).val();
                const villageId = $('#village').val();
                fetchTpsList(villageId, status);
            });

            // Search filter
            $('#search').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('#tps-list .card').each(function() {
                    const tpsName = $(this).find('h6').text().toLowerCase();
                    $(this).toggle(tpsName.indexOf(searchTerm) !== -1);
                });
            });
        });
    </script>


    <style>
        .custom-badge-success {
            background-color: rgba(119, 165, 255, 0.2);
            color: #175ADE;
            border: 2px solid #77A5FF;
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
        }

        .custom-badge-pending {
            background-color: #EFEFEF;
            color: #6D6D6D;
            border: 2px solid #C1C1C1;
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
        }
    </style>
@endsection
