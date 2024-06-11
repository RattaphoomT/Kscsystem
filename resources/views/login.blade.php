<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/img/ksc.jpg') }}" style="border-radius: 10%">


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
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('img/bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }

    </style>

</head>

<body>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12 col-lg-4">

                <div class="card" style="margin-top: 15%">
                    <img src="{{ asset('img/baner.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3 class="text-center">กรุณาเข้าสู่ระบบ</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="user_id" class="form-label">รหัสประจำตัว</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="กรอกรหัสประจำตัว 6 หลัก"
                                    required>
                            </div>

                            
                            <input type="hidden" id="password" name="password" value="12345678" required>
                            

                            <button type="submit" class="btn btn-primary text-center">เข้าสู่ระบบ</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

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

</body>

</html>
