<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('admin/template/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/template/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin/template/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('admin/template/images/favicon.png') }}" />
    <!-- font-awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- boostrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <h3 class="text-white">Foodie Land</h3>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{ Auth::user()->profile == null ? asset('default/default-profilepicture.jpg') : asset('profile/' . Auth::user()->profile) }}"
                                alt="profile" />
                            <span class="nav-profile-name">
                                {{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a href="{{ route('profile#editPage') }}" class="dropdown-item">
                                <i class="typcn typcn-cog-outline text-primary"></i>
                                Edit Proflie
                            </a>

                            @if (Auth::user()->role == 'superadmin')
                                <a href="{{ route('account#newAccountPage') }}" class="dropdown-item">
                                    <i class="typcn typcn-user-add text-primary"></i>
                                    Add New Admin Account
                                </a>

                                <a href="{{ route('account#adminList') }}" class="dropdown-item">
                                    <i class="typcn typcn-user text-primary"></i>
                                    Admin List
                                </a>

                                <a href="{{ route('account#userList') }}" class="dropdown-item">
                                    <i class="typcn typcn-user-outline text-primary"></i>
                                    User List
                                </a>
                            @endif

                            <a href="{{ route('profile#changePasswordPage') }}" class="dropdown-item">
                                <i class=" typcn typcn-lock-closed text-primary"></i>
                                Change Password
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="typcn typcn-power text-primary"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-date dropdown">
                        <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
                            <h6 class="date mb-0" id="today-date"></h6>
                            <i class="typcn typcn-calendar"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item ml-0">
                        <h4 class="mb-0">Dashboard</h4>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close typcn typcn-times"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin#dashboard') }}">
                            <i class="typcn typcn-device-desktop menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category#List') }}">
                            <i class="typcn typcn-th-large-outline menu-icon"></i>
                            <span class="menu-title">Category</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product#page') }}">
                            <i class="typcn typcn-th-small-outline menu-icon"></i>
                            <span class="menu-title">Add Products</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product#list') }}">
                            <i class="typcn typcn-business-card menu-icon"></i>
                            <span class="menu-title">Product List</span>
                        </a>
                    </li>

                    @if (Auth::user()->role == 'superadmin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('payment#list')}}">
                                <i class="typcn typcn-credit-card menu-icon"></i>
                                <span class="menu-title">Payment Method</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin#saleInfo')}}">
                            <i class="typcn typcn-chart-line-outline menu-icon"></i>
                            <span class="menu-title">Sale Information</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin#orderList')}}">
                            <i class="typcn typcn-document-text menu-icon"></i>
                            <span class="menu-title">Order Board</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile#changePasswordPage') }}">
                            <i class="typcn typcn-lock-closed-outline menu-icon"></i>
                            <span class="menu-title">Change Password</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link" type="submit">
                                <i class="typcn typcn-power-outline menu-icon"></i>
                                <span class="menu-title">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            @yield('content')

            @include('sweetalert::alert')

            <!-- partial:partials/_footer.html -->
            {{-- <footer class="footer">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="https://www.bootstrapdash.com/" class="text-muted" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center text-muted">Free <a href="https://www.bootstrapdash.com/" class="text-muted" target="_blank">Bootstrap dashboard</a> templates from Bootstrapdash.com</span>
                    </div>
                </div>
            </div>
        </footer> --}}
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- base:js -->
    <script src="{{ asset('admin/template/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="{{ asset('admin/template/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('admin/template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/template/js/hoverable-collapse.js') }}"></script>
    {{-- <script src="{{ asset('admin/template/js/template/.js') }}"></script> --}}
    <script src="{{ asset('admin/template/js/settings.js') }}"></script>
    <script src="{{ asset('admin/template/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('admin/template/js/dashboard.js') }}"></script>
    <!-- End custom js for this page-->
    {{-- sweetalert js --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- boostrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

    @yield('script-section')

    <script>
        function LoadFile(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            }
        }

        function updateTodayDate() {
            const dateElement = document.getElementById('today-date');
            const now = new Date();
            const options = {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            };
            const formatted = now.toLocaleDateString('en-US', options);
            dateElement.textContent = `Today : ${formatted}`;
        }
        updateTodayDate();
        setInterval(updateTodayDate, 60 * 1000); // update every minute
    </script>
</body>

</html>
