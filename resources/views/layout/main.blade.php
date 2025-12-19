<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saigon Food Joint Stock Company</title>
    <link type="image/x-icon" rel="shortcut icon" href="/sgflogo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    {{--  CSRF cho AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--  Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- DataTables --}}
    <link href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    {{--  jQuery--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .error {
            color: #ff0055;
        }
    </style>
</head>
<body>


    {{--  Navigation bar --}}
    @include('layout.nav')

    {{--  Nội dung trang --}}
    @yield('content')

    {{--  Scripts riêng của từng trang --}}
    @yield('scripts')

    {{-- Inject biến userId vào trước Vite --}}
    <script>
        @auth
            window.userId = {{ Auth::id() }};
        @else
            window.userId = null;
        @endauth
    </script>

    {{-- VITE - Phải đặt TRƯỚC các thư viện khác --}}
    {{-- @vite('resources/js/app.js') --}}

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>

    {{--  jQuery Validate --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{--  DataTables --}}
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
