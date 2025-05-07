<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset("assets/vendor/bootstrap/css/bootstrap.min.css") }}">
    <link href="{{ asset("assets/vendor/fonts/circular-std/style.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/libs/css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/fontawesome/css/fontawesome-all.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/select2/css/select2.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/sweetalert2/sweetalert.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/charts/chartist-bundle/chartist.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/charts/morris-bundle/morris.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/charts/c3charts/c3.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/flag-icon-css/flag-icon.min.css") }}">
    <title> {{ env('APP_NAME') }} | @yield('title') </title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="{{ route("customer.index") }}">{{ env('APP_NAME') }}</a>
                <img src="{{ asset("assets/images/logo.png") }}" width="90px" height="90px" >
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item p-4">
                            <h4><i>Connected as : &nbsp;</i><b class="text text-primary">{{ Auth::user()->name }}</b></h4>
                        </li>
                        {{-- <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">John Abraham </span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset("assets/images/profile.png") }}" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name text-center"> {{ Auth::user()->name }}</h5>
                                </div>
                                <a class="dropdown-item" href="{{ route("users.profile") }}"><i class="fas fa-user mr-2"></i>Account</a>
                                <form action="{{ route("logout") }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item" ><i class="fas fa-power-off mr-2"></i>Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark no-print">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light" style="margin-top:50px">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse mt-3" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider ">
                                Menu
                            </li>
                            <hr class="text bg-white"/>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('agents.*')) active @endif" href="{{ route('agents.index') }}"><i class="fa fa-fw fas fa-warehouse"></i>Agents</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('service.*')) active @endif" href="{{ route('service.index') }}"><i class="fa fa-fw fas fa-box"></i>Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('customer.*')) active @endif" href="{{ route('customer.index') }}"><i class="fa fa-fw fas fa-users"></i>Clients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('payMode.*')) active @endif" href="{{ route('payMode.index') }}"><i class="far fa-money-bill-alt"></i>Moyen de Paiement</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('orders.*')) active @endif" href="{{ route('orders.index') }}"><i class="fa fa-fw fas fa-users"></i>Commandes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('kit.*')) active @endif" href="{{ route('kit.index') }}"><i class="fa fa-fw fas fa-users"></i>Kits</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('token.*')) active @endif" href="{{ route('token.index') }}"><i class="fa fa-fw fas fa-users"></i>Tokens</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('invoices.*')) active @endif" href="{{ route('invoices.index') }}"><i class="fa fa-fw fas fa-users"></i>Factures</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('users.*')) active @endif" href="{{ route('users.index') }}"><i class="fa fa-fw fas fa-cog"></i>Users</a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content ">
                {{-- @yield('content') --}}
                <div class="row mt-5">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            @yield("content")
                        </div>
                    </div>
                </div>

            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer no-print">
                <div class="container-fluid">
                    <div class="row">
                        <div class="d-flex justify-content-center col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                             Copyright © {{ date('Y') }} . All rights reserved. Dashboard made by  <a href="https://colorlib.com/wp/"> &nbsp; ITARA NEXUS</a>.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="{{ asset("assets/vendor/jquery/jquery-3.3.1.min.js")}}"></script>
    <!-- bootstap bundle js -->
    <script src="{{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.js")}}"></script>
    <script src="{{ asset("assets/vendor/select2/js/select2.min.js")}}"></script>
    <script src="{{ asset("assets/vendor/sweetalert2/sweetalert2.all.min.js")}}"></script>
    <script src="{{ asset("assets/vendor/sheetjs/xlsx.full.min.js")}}"></script>
    <!-- slimscroll js -->
    <script src="{{ asset("assets/vendor/slimscroll/jquery.slimscroll.js")}}"></script>
    <!-- main js -->
    <script src="{{ asset("assets/libs/js/main-js.js")}}"></script>
    <!-- chart chartist js -->
    <script src="{{ asset("assets/vendor/charts/chartist-bundle/chartist.min.js")}}"></script>
    <!-- sparkline js -->
    <script src="{{ asset("assets/vendor/charts/sparkline/jquery.sparkline.js")}}"></script>
    <!-- morris js -->
    <script src="{{ asset("assets/vendor/charts/morris-bundle/raphael.min.js")}}"></script>
    <!-- chart c3 js -->
    <script src="{{ asset("assets/vendor/charts/c3charts/c3.min.js")}}"></script>
    <script src="{{ asset("assets/vendor/charts/c3charts/d3-5.4.0.min.js")}}"></script>
    <script src="{{ asset("assets/vendor/charts/c3charts/C3chartjs.js")}}"></script>
    <script src="{{ asset("assets/libs/js/dashboard-ecommerce.js")}}"></script>
    <script>
        function ExportToExcel(id,name,dl){
            var elt = document.getElementById(id);
            var type = 'xlsx';
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return XLSX.writeFile(wb, name +'.xlsx');
            // return dl ?
            //     XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
            //     XLSX.writeFile(wb, name || ('MySheetName.' + (type || 'xlsx')));

        }

        $('.select2').select2();
    </script>

    @yield('js_content')
</body>

</html>
