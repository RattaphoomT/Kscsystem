<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/img/ksc.jpg') }}" style="border-radius: 10%">

    <!-- โหลด CSS ของ Select2 จาก CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">



    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">


    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&family=Prompt&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: "IBM Plex Sans Thai", sans-serif;
        }
    </style>

</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>

    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="#" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('/img/ksc.jpg') }}" alt="" height="60" style="border-radius: 20%">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('/img/ksc.jpg') }}" alt="" height="55" style="border-radius: 20%">
                </span>
            </a>

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('/img/ksc.jpg') }}" alt="" height="60" style="border-radius: 20%">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('/img/ksc.jpg') }}" alt="" height="55" style="border-radius: 20%">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">
                    @if (Auth::user()->user_status_user_status_id == 1)
                        <li class="side-nav-title side-nav-item h6">ผู้ดูเเลระบบ</li>

                        <li class="side-nav-item">
                            <a href="{{ route('adminindex') }}" class="side-nav-link">
                                <i class="uil-home-alt"></i>
                                <span> รายงานผลภาพรวม </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('studentmange') }}" class="side-nav-link">
                                <i class="uil-user"></i>
                                <span> จัดการข้อมูลนักเรียน </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('teachermanage') }}" class="side-nav-link">
                                <i class="uil-users-alt"></i>
                                <span> จัดการข้อมูลครู </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('addrecord') }}" class="side-nav-link">
                                <i class="uil-file-edit-alt"></i>
                                <span> บันทึกการสอน </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('showrecord') }}" class="side-nav-link">
                                <i class="uil-clipboard-alt"></i>
                                <span> รายงานผลการสอน </span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->user_status_user_status_id == 2)
                        <li class="side-nav-title side-nav-item">นักเรียน</li>

                        <li class="side-nav-item">
                            <a href="{{ route('student.dashboard') }}" class="side-nav-link">
                                <i class="uil-file-edit-alt"></i>
                                <span> บันทึกการเรียน </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="https://kku.world/eaato" class="side-nav-link">
                                <i class="uil-forwaded-call"></i>
                                <span> สนใจต่อคอร์ส </span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->user_status_user_status_id == 3)
                        <li class="side-nav-title side-nav-item">ครูผู้สอน</li>

                        <li class="side-nav-item">
                            <a href="{{ route('recordteacher') }}" class="side-nav-link">
                                <i class="uil-file-edit-alt"></i>
                                <span> บันทึกการสอน </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('teacher.dashboard') }}" target="_blank" class="side-nav-link">
                                <i class="uil-file-alt"></i>
                                <span> ประวัติการสอน </span>
                            </a>
                        </li>
                    @endif
                </ul>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">

                        {{-- <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                <span class="noti-icon-badge"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="javascript: void(0);" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>

                                <div style="max-height: 230px;" data-simplebar="">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">1 min ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                        <p class="notify-details">New user registered.
                                            <small class="text-muted">5 hours ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="assets/images/users/avatar-2.jpg"
                                                class="img-fluid rounded-circle" alt="">
                                        </div>
                                        <p class="notify-details">Cristina Pride</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Hi, How are you? What about our next meeting</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">4 days ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="assets/images/users/avatar-4.jpg"
                                                class="img-fluid rounded-circle" alt="">
                                        </div>
                                        <p class="notify-details">Karen Robinson</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Wow ! this admin looks good and awesome design</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <p class="notify-details">Carlos Crouch liked
                                            <b>Admin</b>
                                            <small class="text-muted">13 days ago</small>
                                        </p>
                                    </a>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    View All
                                </a>

                            </div>
                        </li> --}}



                        <li class="notification-list">
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{ asset('img/ksc.jpg') }}" alt="user-image" class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">{{ Auth::user()->first_name }}
                                        {{ Auth::user()->last_name }}</span>
                                    <span
                                        class="account-position">{{ Auth::user()->user_status->user_status_name }}</span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">ยินดีต้นรับคุณ {{ Auth::user()->nick_name }}</h6>
                                </div>


                                <!-- item-->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>

                                <a href="#" class="dropdown-item notify-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>ออกจากระบบ</span>
                                </a>
                            </div>
                        </li>

                    </ul>

                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>

                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-left">
                                    <ol class="breadcrumb m-0">
                                        @yield('breadcrumb')
                                    </ol>
                                </div>
                                <h4 class="page-title">@yield('contentitle')</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        @yield('nonconten')
                    </div>

                    <!-- start conten -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    @yield('conten')
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end conten -->

                </div> <!-- container -->






            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © RTP - KSC Management system by RTP
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="https://kku.world/eaato">ฝ่ายสนับสนุน</a>
                                <a href="{{ route('contact') }}">ติดต่อเรา</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="end-bar">

        <div class="rightbar-title">
            <a href="javascript:void(0);" class="end-bar-toggle float-end">
                <i class="dripicons-cross noti-icon"></i>
            </a>
            <h5 class="m-0">ตั้งค่าการเเสดงผล</h5>
        </div>

        <div class="rightbar-content h-100" data-simplebar="">

            <div class="p-3">

                <!-- Settings -->
                <h5 class="mt-3">Mode</h5>
                <hr class="mt-1">

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light"
                        id="light-mode-check" checked="">
                    <label class="form-check-label" for="light-mode-check">Light Mode</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark"
                        id="dark-mode-check">
                    <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                </div>


                <!-- Width -->
                <h5 class="mt-4">Width</h5>
                <hr class="mt-1">
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="width" value="fluid" id="fluid-check"
                        checked="">
                    <label class="form-check-label" for="fluid-check">Fluid</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="width" value="boxed" id="boxed-check">
                    <label class="form-check-label" for="boxed-check">Boxed</label>
                </div>


                <!-- Left Sidebar-->
                <h5 class="mt-4">Left Sidebar</h5>
                <hr class="mt-1">
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="theme" value="default"
                        id="default-check">
                    <label class="form-check-label" for="default-check">Default</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="theme" value="light" id="light-check"
                        checked="">
                    <label class="form-check-label" for="light-check">Light</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="theme" value="dark" id="dark-check">
                    <label class="form-check-label" for="dark-check">Dark</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="fixed" id="fixed-check"
                        checked="">
                    <label class="form-check-label" for="fixed-check">Fixed</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="condensed"
                        id="condensed-check">
                    <label class="form-check-label" for="condensed-check">Condensed</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="scrollable"
                        id="scrollable-check">
                    <label class="form-check-label" for="scrollable-check">Scrollable</label>
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-primary" id="resetBtn">คืนค่าเดิม</button>
                </div>
            </div> <!-- end padding-->

        </div>
    </div>

    <div class="rightbar-overlay"></div>

    <!-- อนิเมชันโหลด -->
    <div id="loadingAnimation"
        style="display: none; position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999; /* ทำให้แอนิเมชันอยู่เหนือส่วนอื่นของหน้า */">
        <img src="{{ asset('img/load.gif') }}" alt="Loading...">
    </div>

    <!-- /End-bar -->

    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <!-- Todo js -->
    <script src="{{ asset('assets/js/ui/component.todo.js') }}"></script>

    <!-- demo:js -->
    <script src="{{ asset('assets/js/pages/demo.widgets.js') }}"></script>
    <!-- demo end -->





    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <!-- DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>




    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Datepicker Thai Extension -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-datepicker-th/1.0.4/jquery-ui-datepicker-th.min.js">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>

    <!-- โหลด JS ของ Select2 จาก CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    @if (Session::has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire(
                    'แจ้งเตือนการทำรายการ!',
                    '{{ Session::get('success') }}',
                    'success'
                )
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const userId = this.dataset.id;

                    Swal.fire({
                        title: 'ยืนยันการลบ นักเรียน หรือไม่',
                        text: "เมื่อลบแล้วไม่สามารถกู้คืนได้",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/delete/student/${userId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            }).then(response => {
                                return response.json().then(data => {
                                    if (response.ok) {
                                        Swal.fire(
                                            'ลบแล้ว!',
                                            'นักเรียนถูกลบเรียบร้อยแล้ว.',
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'ผิดพลาด!',
                                            data.message ||
                                            'เกิดข้อผิดพลาดในการลบนักเรียน.',
                                            'error'
                                        );
                                    }
                                });
                            }).catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'ผิดพลาด!',
                                    'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์.',
                                    'error'
                                );
                            });
                        }
                    });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-learn-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const learnId = this.dataset.id;

                    Swal.fire({
                        title: 'ยืนยันการลบรายการเรียนหรือไม่',
                        text: "เมื่อลบแล้วไม่สามารถกู้คืนได้",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/delete/record/${learnId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            }).then(response => {
                                return response.json().then(data => {
                                    if (response.ok) {
                                        Swal.fire(
                                            'ลบแล้ว!',
                                            'รายการเรียนถูกลบเรียบร้อยแล้ว.',
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'ผิดพลาด!',
                                            data.message ||
                                            'เกิดข้อผิดพลาดในการลบรายการเรียน.',
                                            'error'
                                        );
                                    }
                                });
                            }).catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'ผิดพลาด!',
                                    'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์.',
                                    'error'
                                );
                            });
                        }
                    });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-teacher').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const teacherId = this.dataset.id;

                    Swal.fire({
                        title: 'ยืนยันการลบครูหรือไม่',
                        text: "เมื่อลบแล้วไม่สามารถกู้คืนได้",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/delete/teacher/${teacherId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            }).then(response => {
                                return response.json().then(data => {
                                    if (response.ok) {
                                        Swal.fire(
                                            'ลบแล้ว!',
                                            'ครูถูกลบเรียบร้อยแล้ว.',
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'ผิดพลาด!',
                                            data.message ||
                                            'เกิดข้อผิดพลาดในการลบครู.',
                                            'error'
                                        );
                                    }
                                });
                            }).catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'ผิดพลาด!',
                                    'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์.',
                                    'error'
                                );
                            });
                        }
                    });
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            let table = $('#basic-datatable').DataTable({
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "ทั้งหมด"]
                ],
                "language": {
                    "lengthMenu": "แสดง _MENU_ รายการ",
                    "zeroRecords": "ไม่พบข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "infoEmpty": "ไม่มีรายการที่แสดง",
                    "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
                    "search": "ค้นหา:",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    }
                }
            });
        });

        document.getElementById('load').addEventListener('submit', function() {
            document.getElementById('loadingAnimation').style.display = 'block';
        });

        $(function() {
            $("#birthday").datepicker({
                dateFormat: "dd-mm-yy", // รับรูปแบบวันที่เป็น DD-MM-YYYY
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                isBuddhist: true,
                defaultDate: "-20y",
                dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์"],
                dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                ],
                monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                    "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                ]
            });

            $("#teach_at").datepicker({
                dateFormat: "dd-mm-yy", // รับรูปแบบวันที่เป็น DD-MM-YYYY
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                isBuddhist: true,
                defaultDate: "-20y",
                dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์"],
                dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                ],
                monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                    "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                ],
                onSelect: function(dateText) {
                    $("#learn_at").val(dateText);
                }
            });


            $("#learn_at").datepicker({
                dateFormat: "dd-mm-yy", // รับรูปแบบวันที่เป็น DD-MM-YYYY
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                isBuddhist: true,
                defaultDate: "-20y",
                dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์"],
                dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                ],
                monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                    "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                ]
            });

            $('#birthday').change(function() {
                var dob = $(this).val();
                if (dob) {
                    var age = calculateAge(dob);
                    $('#age').val(age); // ตั้งค่าค่าอายุใน input hidden
                }
            });

            function calculateAge(dob) {
                var parts = dob.split("-");
                var day = parseInt(parts[0], 10);
                var month = parseInt(parts[1], 10) - 1; // เดือนใน JavaScript เริ่มต้นที่ 0
                var year = parseInt(parts[2], 10);

                var birthDate = new Date(year, month, day);
                var today = new Date();
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }
        });

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "กรุณาเลือก...",

            });
        });
    </script>


    


    @yield('scripts')

</body>

</html>
