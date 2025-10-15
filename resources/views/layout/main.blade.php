@include('layout.head')

  <body>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top">
      <div class="d-flex align-items-center justify-content-center h-100 w-100">
        <i class="fa fa-arrow-circle-o-up"></i>
      </div>
    </div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        @include('layout.navbar')

      <!-- Page Body Start-->
      <div class="page-body-wrapper">

        <!-- Page Sidebar Start-->
        @include('layout.sidebar')
        <!-- Page Sidebar Ends-->

        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            @yield('content')
          </div>
          <!-- Container-fluid Ends-->
        </div>

      </div>

      <div class="toast-container position-fixed top-0 end-0 p-3 toast-index toast-rtl">
          <div class="toast fade hide" id="toast-success" role="alert" aria-live="polite" aria-atomic="true">
              <div class="d-flex justify-content-between align-items-center alert-light-success">
                <div class="toast-body d-flex justify-content-between align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square close-search stroke-success"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                  <span class="ms-2">Success: We've updated your info</span>
                </div>
                <button class="btn-close me-2" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
          </div>
      </div>

      <div class="toast-container position-fixed top-0 end-0 p-3 toast-index toast-rtl">
          <div class="toast fade hide" id="toast-success2" role="alert" aria-live="polite" aria-atomic="true">
              <div class="d-flex justify-content-between align-items-center alert-light-success">
                <div class="toast-body d-flex justify-content-between align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square close-search stroke-success"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                  <span class="ms-2">Success: Email has been sent</span>
                </div>
                <button class="btn-close me-2" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
          </div>
      </div>

    @include('layout.modal')
    </div>

    @include('layout.footer')
    @yield('script')
  </body>
</html>
