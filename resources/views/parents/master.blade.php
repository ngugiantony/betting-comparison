<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Odds Solver</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">

        <link rel="stylesheet" href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" type="text/css">

        <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" type="text/css" id="light-style">
        <link rel="stylesheet" href="{{ asset('assets/css/app-dark.min.css') }}" type="text/css" id="dark-style">

        @yield('styles')

    </head>

    <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            
            @include('parents.inc.left-nav')

            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    @include('parents.inc.navbar')
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    @yield('content')
                    <!-- container -->
                </div>
               
            </div>


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->


        <div class="rightbar-overlay"></div>



        <!-- bundle -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>


        <!-- Apex js -->

        <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>

        <!-- Todo js -->
        <script src="{{ asset('assets/js/ui/component.todo.js') }}"></script>

        <!-- demo app -->
        <script src="{{ asset('assets/js/pages/demo.dashboard-crm.js') }}"></script>
        <!-- end demo js-->


        <!-- third party js -->
        <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>

        @yield('scripts')

    </body>
</html>
