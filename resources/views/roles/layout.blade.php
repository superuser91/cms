<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Bảng điều khiển</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"
        crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('vendor/admin-lte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @stack('head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <!-- Wrapper -->
    <div class="wrapper">
        <div class="content-wrapper px-1 px-md-2">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid px-0">
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content pb-3">
                <div class="container-fluid px-0">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

    </div>
    <!-- ./wrapper -->
    @stack('scripts')
</body>

</html>
