<!DOCTYPE html>
<!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        {{-- ++++++++++++ Tab Title ++++++++++++ --}}
        <title>
            @yield('tab_title')
        </title>
        <!-- =================== Font Awesome Icons =================== -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css')}}">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="{{ asset('assets/admin/fonts/SansPro/SansPro.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/mycustomstyle.css')}}">
        {{-- ++++++++++++++++++++++++++++ Toastr Package ++++++++++++++++++++++++++++ --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"
              integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
        {{-- +++++++++++++++ select2 selectbox +++++++++++++++ --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        {{-- ++++++++++++++ Css Links ++++++++++++++ --}}
        @yield('css')
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            {{-- +++++++++++++++++++++++ Start : Navbar +++++++++++++++++++++++ --}}
            @include('layouts.includes.navbar')
            {{-- +++++++++++++++++++++++ End : Navbar +++++++++++++++++++++++ --}}
            {{-- +++++++++++++++++++++++ Start : Sidebar +++++++++++++++++++++++ --}}
            @include('layouts.includes.sidebar')
            {{-- +++++++++++++++++++++++ End : Sidebar +++++++++++++++++++++++ --}}
            {{-- +++++++++++++++++++++++ Start : Content , footer +++++++++++++++++++++++ --}}
            <div>
                {{-- +++++++++++++++++++++++ Start : Content +++++++++++++++++++++++ --}}
                @include('layouts.includes.content')
                {{-- +++++++++++++++++++++++ End : Content +++++++++++++++++++++++ --}}
                {{-- +++++++++++++++++++++++ Start : Footer +++++++++++++++++++++++ --}}
                @include('layouts.includes.footer')
                {{-- +++++++++++++++++++++++ End : Footer +++++++++++++++++++++++ --}}
            </div>
            {{-- +++++++++++++++++++++++ End : Content , footer +++++++++++++++++++++++ --}}
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('assets/admin/dist/js/adminlte.min.js')}}"></script>
        {{-- ++++++++++ general.js File ++++++++++ --}}
        <script src="{{ asset('assets/admin/js/general.js') }}"></script>
        {{-- +++++++++++++++ select2 selectbox +++++++++++++++++ --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        {{-- ++++++++++ select2 ++++++++++ --}}
        <script>
            $(document).ready( function() { $('.select2').select2(); });
        </script>
        {{-- ++++++++++++++++++++++++++++ sweetalert Package ++++++++++++++++++++++++++++ --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
                integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- ======================= sweetalert Alerts ======================= --}}
        {{-- ///////// "success" Alert ///////// --}}
        @if (Session::has('success'))
            <script>
               swal('Message',"{{ Session::get('success') }}" , 'success' , {
                    button:true,
                    button:'Ok',
                    timer:3000,
                    dangerMode:false,

               });
            </script>
        @endif
        {{-- ///////// "warning" Alert ///////// --}}
        @if (Session::has('warning_msg'))
            <script>
                swal('Message',"{{ Session::get('warning_msg') }}" , 'warning' , {
                    button:true,
                    button:'Ok',
                    timer:3000,
                    dangerMode:false,
                });
            </script>
        @endif
        {{-- ///////// "error" Alert ///////// --}}
        @if (Session::has('error_msg'))
            <script>
                swal('Message',"{{ Session::get('error_msg') }}" , 'error' , {
                    button:true,
                    button:'Ok',
                    timer:3000,
                    dangerMode:false,
                });
            </script>
        @endif
        {{-- ++++++++++++++++++++++++++++ toastr js ++++++++++++++++++++++++++++ --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
                integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            toastr.options =
            {
                "progressBar" : true ,
                "closeButton" : true ,
                "positionClass": "toast-top-left",
            }
        </script>
        {{-- ///////// "success" Alert ///////// --}}
        @if (Session::has('record_added'))
            <script>
                toastr.success("{{ Session::get('record_added') }}");
            </script>
        @endif
        {{-- ///////// "warning" Alert ///////// --}}
        @if (Session::has('record_updated'))
            <script>
                toastr.warning("{{ Session::get('record_updated') }}");
            </script>
        @endif
        {{-- ///////// "error" Alert ///////// --}}
        @if (Session::has('record_deleted'))
            <script>
                toastr.error("{{ Session::get('record_deleted') }}");
            </script>
        @endif
        {{-- ++++++++++++++ Js Links ++++++++++++++ --}}
        @yield('script')
    </body>
</html>
