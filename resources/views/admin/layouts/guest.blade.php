<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Free minimal portfolio web site template,minmal portfolio,porfolio,bootstrap template,html template,photography " />

    <!-- site title -->
    <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>

    <link rel="icon" href="{{ asset(getSetting('favicon', 'assets/images/favicon.png')) }}" type="image/x-icon">



    <!-- build:css -->
    <link rel="stylesheet" href="{{asset('assets/css/guest.css')}}">
    <!-- endbuild -->

    {{-- sweetalert --}}
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
</head>

<body>
    <!-- ========== section start ========== -->
    <main role="main">
        @yield('content')
    </main>
    <!-- ========== section end ========== -->

<!-- template's footer -->


    <!-- =========<< Js Script start here >>=========== -->
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <script>
        function SwalNotification(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,  // 'warning', 'error', 'success', 'info', 'question'
                confirmButtonText: 'OK'
            });
        }


            function SwalFlash(result, title, text, icon = 'success') {
            Swal.fire({
                toast: result,
                position: 'bottom-left',
                icon: icon, /// 'warning', 'error', 'success', 'info', 'question'
                title: title,
                text: text,
                showConfirmButton: false, // Hide the confirmation button
                timer: 3000 // Auto-close after 3 seconds
            });
        }

    </script>



    @if (session('success'))
    <script>
        SwalNotification('Success', "{{ session('success') }}", 'success');
    </script>
    @endif



    

    @if (session('status'))
    <script>
        SwalNotification('Success', "{{ session('status') }}", 'success');
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

    @yield('js')
</body>

</html>