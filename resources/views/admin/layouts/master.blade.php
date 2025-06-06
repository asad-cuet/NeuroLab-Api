<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="Free minimal portfolio web site template,minmal portfolio,porfolio,bootstrap template,html template,photography " />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- site title -->
    <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>

    <link rel="icon" href="{{ asset(getSetting('favicon', 'assets/images/favicon.png')) }}" type="image/x-icon">


    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">


    <!-- build:css -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/metismenujs/dist/metismenujs.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <!-- <link href="assets/vendors/flatpickr/flatpickr.min.css" rel="stylesheet/text" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    
    {{-- sweetalert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    
    <style>
        .swal2-container {
            z-index: 99999!important;
        }
    </style>

    
    {{-- select --}}
    <link href="/assets/vendor/tomselect/css/tom-select.bootstrap5.min.css" rel="stylesheet" type="text/css">

    <!-- data-table -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @yield('css')
</head>

<body>
    <div class="body-wrapper">
        <!-- Sidenav start -->
        <!-- ======== sidebar-nav start =========== -->
        @include('admin.components.sidebar')

        <div class="overlay"></div>
        <!-- ======== sidebar-nav end =========== -->
        <!-- Sidenav end -->


        <!-- template main content -->
        <main class="main-wrapper" role="main">

            <!-- ========== header start ========== -->
            @include('admin.components.header')
            <!-- ========== header end ========== -->

            <!-- ========== section start ========== -->
            <section class="page-container">
                <div class="container-fluid">
                    @yield('container')
                </div>
                <!-- end container -->
            </section>
            <!-- ========== section end ========== -->

            <!-- template's footer -->
            <!-- ================> footer section start here <================== -->
            {{-- @include('admin.components.footer') --}}
            <!-- ================> footer section end here <================== -->
        </main>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- vendor plugins -->
    <script src="https://kit.fontawesome.com/1c5d30a313.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
  <script src="{{ asset('assets/vendor/tomselect/js/tom-select.complete.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="assets/js/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery"></script>
  <script src="https://cdn.jsdelivr.net/npm/metismenu"></script>

  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
  <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

  <script src="{{ asset('assets/js/nestable.js') }}"></script>
  <script src="{{ asset('assets/js/dropzone-config.js') }}"></script>
  <script src="https://unpkg.com/dropzone/dist/dropzone-min.js"></script>

    
    <!-- Template js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
    
    @if (session('success'))
        <script>
            SwalNotification('Sucess', "{{ session('success') }}", 'success');
        </script>
    @endif

    @if (session('error'))
        <script>
            SwalNotification('Error', "{{ session('error') }}", 'error');
        </script>
    @endif

    @if (session('warning'))
        <script>
            SwalNotification('Warning', "{{ session('warning') }}", 'warning');
        </script>
    @endif

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            //pusher initializing
            Pusher.logToConsole = true;
            var pusher = new Pusher('{{env("PUSHER_APP_KEY")}}', {
                cluster: '{{env("PUSHER_APP_CLUSTER")}}',
                authEndpoint: '{{ url("/admin/broadcasting/auth") }}',
                auth: {
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
                }
            });

            
            //calling channel
            var channel = pusher.subscribe('private-admin.{{Auth::guard("admin")->user()->id}}');
            channel.bind('admin-notification-event', function(data) {
                console.log('response',data);
                $('.notification-box').load(location.href+" .notification-box");
            });
        });
    </script> --}}


    @yield('js')

</body>

</html>
