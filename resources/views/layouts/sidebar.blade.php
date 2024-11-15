 <div class="header-area" id="headerArea">
     <div class="container">
         <div
             class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
             <div class="logo-wrapper">
                 <h3 class="mt-2">SIREKAP</h3>
             </div>
             <div class="btn btn-danger btn-sm">
                 <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" fill="none" viewBox="0 0 24 24">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                 </svg>
             </div>
         </div>
     </div>
 </div>

 <script>
     document.querySelector('.btn-danger').addEventListener('click', function() {
         // Hapus semua item dari localStorage
         localStorage.clear();

         // Redirect ke halaman login atau lakukan tindakan lain setelah logout
         window.location.href = '/login';
     });
 </script>
