<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <title>VendorsCity</title>



    <!-- Favicon -->

    <link rel="shortcut icon" href="{{ asset('public/admin/assets/img/favicon_new.png') }}">



    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}">



    <!-- Fontawesome CSS -->

    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/all.min.css') }}">



    <!-- Select2 CSS -->

    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/select2/css/select2.min.css') }}">



    <!-- Datatables CSS -->

    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/datatables/datatables.min.css') }}">



    <!-- Main CSS -->

    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/icons/ionic/ionicons.css') }}">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">

    <style>
        #set_order_model h3 {

            font-size: 18px;

        }



        #set_order_model .btn {

            padding: 0 8px !important;

        }



        #select_one_record h3 {

            font-size: 22px;

        }

        .custom-swal-popup {
            background-color: blue !important;
            /* Change background color */
            color: white !important;
            /* Change font color */
        }

        .custom-swal-title {
            color: white !important;
            /* Change font color of title */
        }
    </style>





    <!--[if lt IE 9]>

   <script src="assets/js/html5shiv.min.js"></script>

   <script src="assets/js/respond.min.js"></script>

  <![endif]-->

</head>

<body>



    <!-- Main Wrapper -->

    <div class="main-wrapper">



        <!-- Header -->

        <div class="header">

            @include('admin.includes.header')



        </div>

        <!-- /Header -->



        <!-- Sidebar -->

        <div class="sidebar" id="sidebar">



            @include('admin.includes.sidebarleft')



        </div>



        <!-- /Sidebar -->



        <!-- Page Wrapper -->

        <div class="page-wrapper">

            @yield('content')

        </div>



        <!-- /Page Wrapper -->



    </div>



    @include('admin.includes.footer')

    @yield('footer_js')
