@extends('layouts.app')
@section('title', 'Detail TPS')
@section('content')
    @include('layouts.sidebar')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card product-details-card mb-3" style="background: none;">
                <div class="card-body">
                    <div id="tps-info"></div>

                    <style>
                        .custom-badge-success {
                            background-color: rgba(119, 165, 255, 0.2);
                            color: #175ADE;
                            border: 2px solid #77A5FF;
                            font-size: 1rem;
                            padding: 0.25rem 0.75rem;
                        }

                        .custom-badge-pending {
                            background-color: rgba(255, 165, 165, 0.2);
                            color: #FF5C5C;
                            border: 2px solid #FF5C5C;
                            font-size: 1rem;
                            padding: 0.25rem 0.75rem;
                        }
                    </style>

                    <hr style="border: 1px solid #666;">

                    <div class="row mt-3">
                        <div id="tps-details"></div>
                    </div>

                    <hr style="border: 1px solid #666;">


                    <div class="card product-details-card mb-3" style="border: 1px solid #E1E7EF; border-radius: 12px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 style="font-size: 16px; color: #175ADE;">Data Saksi</h6>
                            </div>

                            <div id="saksiCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                  
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card product-details-card mb-3" style="border: 1px solid #E1E7EF; border-radius: 12px;" id="tps-container">
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="element-heading mt-3">
                                        <h6>DPT</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="single-gallery-item">
                                                <img id="dpt-photo" src="" alt="Data DPT"
                                                    class="clickable-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="element-heading mt-3">
                                        <h6>C6</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="single-gallery-item">
                                                <img id="c6-photo" src="" alt="Data C6"
                                                    class="clickable-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <div class="element-heading mt-3">
                                        <h6>C1</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="single-gallery-item">
                                                <img id="c1-photo" src="" alt="Data C1"
                                                    class="clickable-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <div class="element-heading mt-3">
                                        <h6>CPLANO</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="single-gallery-item">
                                                <img id="cplano-photo" src="" alt="Data CPLANO"
                                                    class="clickable-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" style="border: 1px solid #E1E7EF; border-radius: 8px; padding: 10px;">
                        <div class="card-body">
                            <h4 style="font-weight: bold; font-size: 18px;">Paslon</h4>

                            <div id="candidate-container">
                            </div>
                        </div>
                    </div>

                    <style>
                        .candidate {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            border-bottom: 1px dashed #77A5FF;
                            padding: 10px 0;
                        }

                        .candidate:last-child {
                            border-bottom: none;
                        }

                        .name {
                            font-weight: bold;
                            color: #000;
                            font-size: 16px;
                            width: 50%;
                        }

                        .votes {
                            font-size: 16px;
                            color: #175ADE;
                            font-weight: bold;
                        }

                        .votes img {
                            margin-right: 5px;
                        }
                    </style>
                </div>


            </div>
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
                        const decryptedDataString = decryptData(userId, username, encryptedResponseBase64);
                        if (decryptedDataString) {
                            try {
                                const decryptedData = JSON.parse(
                                    decryptedDataString);
                                console.log('Decrypted user profile data:', decryptedData);

                                if (decryptedData.role_id === 4) {
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
            const apiUrl = `{{ env('API_URL') }}/v1/tps/detail/coordinator/${{!! json_encode($a) !!}}`;
    
            fetchTpsDetails(apiUrl, token);
        });
    
        function fetchTpsDetails(apiUrl, token) {
            fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const tps = data.data.tps;
                const tpsUsers = data.data.tps_user || [];

                const tpsData = data.data.tps_data || {};
                const { 
                    dpt_photo, 
                    c6_photo, 
                    c1_photo, 
                    cplano_photo 
                } = tpsData;

                const defaultImage = 'https://cdn-icons-png.flaticon.com/512/15639/15639068.png';

                $('#dpt-photo').attr('src', dpt_photo || defaultImage);
                $('#c6-photo').attr('src', c6_photo || defaultImage);
                $('#c1-photo').attr('src', c1_photo || defaultImage);
                $('#cplano-photo').attr('src', cplano_photo || defaultImage);

                const paslons = data.data.paslons || [];

                paslons.sort((a, b) => {
                    if (a.total_votes === 0 && b.total_votes === 0) {
                        return a.position - b.position;
                    } else {
                        return b.total_votes - a.total_votes;
                    }
                });
                updatePaslonCandidates(paslons)


                updateTpsInfo(tps);
                updateTpsDetails(tps, tpsUsers);
                handleSaksiCarousel(tpsUsers);
                updateAdditionalTpsInfo(tps);
            })
            .catch(error => {
                console.error('Error fetching the API:', error);
                $('#tps-container').html('<p style="color: red;">Error loading TPS data. Please try again later.</p>');
            });
        }

        function updatePaslonCandidates(paslons) {
    const candidateContainer = $('#candidate-container');
    candidateContainer.empty();

    // Remove duplicate paslons based on both mayor_name and deputy_mayor_name
    const uniquePaslons = Array.from(new Set(paslons.map(paslon => `${paslon.mayor_name}-${paslon.deputy_mayor_name}`)))
        .map(nameCombo => paslons.find(paslon => `${paslon.mayor_name}-${paslon.deputy_mayor_name}` === nameCombo));

    // Cek apakah ada paslon dengan total_votes > 0
    const hasNonZeroVotes = uniquePaslons.some(paslon => paslon.total_votes > 0);

    if (hasNonZeroVotes) {
        // Urutkan berdasarkan total_votes jika ada yang terisi
        uniquePaslons.sort((a, b) => b.total_votes - a.total_votes);
    } else {
        // Jika semua total_votes adalah 0, urutkan berdasarkan position
        uniquePaslons.sort((a, b) => a.position - b.position);
    }

    // Render each paslon
    uniquePaslons.forEach(paslon => {
        const { mayor_name, deputy_mayor_name, total_votes, position } = paslon;
        const votesText = total_votes > 0 ? `${total_votes.toLocaleString()}` : '0';
        const votesStyle = total_votes > 0 ? 'color: #FF4500; font-weight: bold; font-size: 14px;' : 'color: #FF5C5C;';
        
        const candidateMarkup = `
            <div class="candidate">
                <span class="name" style="font-size: 12px;">${mayor_name} dan ${deputy_mayor_name}</span>
                <span class="votes" style="${votesStyle}">
                    <span style="font-weight: bold;">${votesText}</span>
                </span>
            </div>
        `;
        candidateContainer.append(candidateMarkup);
    });
}




        function updateTpsInfo(tps) {
            const tpsNumber = tps?.tps_number || 'N/A';
            const status = tps?.status || 0;
            const statusText = status === 1 ? 'Selesai' : 'Belum';
            const badgeClass = status === 1 ? 'custom-badge-success' : 'custom-badge-pending';
    
            const tpsInfo = `
                <div class="d-flex justify-content-between align-items-center">
                    <h4>🗳️ TPS #${tpsNumber}</h4>
                    <span class="badge rounded-pill ${badgeClass}">${statusText}</span>
                </div>
            `;
            $('#tps-info').html(tpsInfo);
        }
    
        function updateTpsDetails(tps, tpsUsers) {
            const totalSaksi = tpsUsers.length;
            const location = `${tps?.village || ''}, ${tps?.district || ''}, ${tps?.city || ''}`;
            const saksiStatusText = totalSaksi === 0 ? 'Belum ada saksi' : `Saksi sudah ada (${totalSaksi})`;
            const saksiTextColor = totalSaksi === 0 ? '#FF5C5C' : '#6C00EB';
    
            const tpsDetails = `
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="p-2">
                            <span style="font-size: 14px;">Lokasi</span>
                            <p style="font-weight: bold; color: #000;">${location}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2">
                            <span style="font-size: 14px;">Total saksi: ${totalSaksi}</span>
                            <p style="font-weight: bold; color: ${saksiTextColor}">${saksiStatusText}</p>
                        </div>
                    </div>
                </div>
            `;
            $('#tps-details').html(tpsDetails);
        }
    
        function handleSaksiCarousel(tpsUsers) {
            const totalSaksi = tpsUsers.length;
            if (totalSaksi > 0) {
                let carouselItems = '';
                let indicators = '';
    
                tpsUsers.forEach((user, index) => {
                    const isActive = index === 0 ? 'active' : '';
                    carouselItems += `
                        <div class="carousel-item ${isActive}">
                            <div class="row mt-2">
                                <span style="color: #B5B5B5; font-size: 14px;">Nama Saksi:</span>
                                <p style="color: #175ADE; font-weight: bold;">${user.full_name}</p>
                                <span style="color: #B5B5B5; font-size: 14px;">Nomor Handphone:</span>
                                <p style="color: #000000">
                                    <a href="https://wa.me/${user.phone_number}" target="_blank" style="text-decoration: none; color: inherit;">
                                        ${user.phone_number}
                                        <i class="bi bi-whatsapp" style="color: #25D366; font-size: 1.25rem;"></i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    `;
    
                    indicators += `
                        <button type="button" data-bs-target="#saksiCarousel" data-bs-slide-to="${index}" class="${isActive}" aria-current="true" aria-label="Saksi ${index + 1}"></button>
                    `;
                });
    
                $('.carousel-inner').html(carouselItems);
                $('.carousel-indicators').html(indicators);
            } else {
                $('#saksiCarousel').hide();
            }
        }

        function updateAdditionalTpsInfo(tps) {
            const coordinates = `${tps?.latitude || 'N/A'}, ${tps?.longitude || 'N/A'}`;
            const detailedLocation = tps?.address || 'N/A';
            const totalVotes = tps?.total_votes || 'N/A';
            const damagedVotes = tps?.damaged_votes || 'N/A';
            const validVotes = tps?.valid_votes || 'N/A';
            const invalidVotes = tps?.invalid_votes || 'N/A';
    
            const tpsCard = `
                <div class="card product-details-card mb-3" style="border: 1px solid #E1E7EF; border-radius: 12px;">
                    <div class="card-body">
                        <h5 style="font-weight: bold; font-size: 18px; margin-bottom: 15px;">TPS ${tps?.tps_number || 'N/A'}</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <span style="color: #B5B5B5; font-size: 14px;">Alamat</span>
                                    <p style="font-size: 16px; color: #000000;">${tps?.village || ''}, ${tps?.district || ''}, ${tps?.city || ''}</p>
                                </div>
                                <div class="mb-3">
                                    <span style="color: #B5B5B5; font-size: 14px;">Koordinat</span>
                                    <p style="font-size: 16px; color: #000000;">${coordinates}</p>
                                </div>
                                <div class="mb-3">
                                    <span style="color: #B5B5B5; font-size: 14px;">Detail Lokasi</span>
                                    <p style="font-size: 16px; color: #000000;">${detailedLocation}</p>
                                </div>
                                <div class="mb-3">
                                    <span style="color: #B5B5B5; font-size: 14px;">Total Surat Suara</span>
                                    <p style="font-size: 16px; color: #000000;">${totalVotes}</p>
                                </div>
                                <div class="mb-3">
                                    <span style="color: #B5B5B5; font-size: 14px;">Total Surat Suara Rusak</span>
                                    <p style="font-size: 16px; color: #000000;">${damagedVotes}</p>
                                </div>
                                <div class="mb-3">
                                    <span style="color: #B5B5B5; font-size: 14px;">Total Surat Suara Sah</span>
                                    <p style="font-size: 16px; color: #000000;">${validVotes}</p>
                                </div>
                                <div class="mb-3">
                                    <span style="color: #B5B5B5; font-size: 14px;">Total Surat Suara Tidak Sah</span>
                                    <p style="font-size: 16px; color: #000000;">${invalidVotes}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#tps-container').html(tpsCard);
        }
    </script>
@endsection
