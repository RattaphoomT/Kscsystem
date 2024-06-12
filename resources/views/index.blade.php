@extends('layout')

@section('title')
    รายงานภาพรวม | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">รายงานภาพรวม</h4>
@endsection

@section('nonconten')
    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='uil-notes float-end'></i>
                <h4 class="text-uppercase mt-0">จำนวนนักเรียนทั้งหมด</h4>
                <h2 class="my-2 text-primary text-dismissible" id="active-users-count">
                    {{ $users->where('user_status_user_status_id', '2')->count() }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    {{-- <span class="text-nowrap">เมื่อ 5 ชัวโมงที่เเล้ว</span> --}}
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='uil-user float-end'></i>
                <h4 class="text-uppercase mt-0">เรียนเดี่ยว</h4>
                <h2 class="my-2 text-warning" id="active-users-count">
                    {{ $users->where('learn_type_learn_type_id', '2')->count() }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    {{-- <span class="text-nowrap">เมื่อ 1 ชัวโมงที่เเล้ว</span> --}}
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='uil-users-alt float-end'></i>
                <h4 class="text-uppercase mt-0">เรียนคู่</h4>
                <h2 class="my-2 text-success" id="active-users-count">
                    {{ $users->where('learn_type_learn_type_id', '1')->count() }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    {{-- <span class="text-nowrap">เมื่อ 20 นาทีที่เเล้ว</span> --}}
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='mdi mdi-account-group-outline float-end'></i>
                <h4 class="text-uppercase mt-0">เรียนกลุ่ม</h4>
                <h2 class="my-2 text-danger" id="active-users-count">
                    {{ $users->where('learn_type_learn_type_id', '3')->count() }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    {{-- <span class="text-nowrap">เมื่อไม่นานมานี้</span> --}}
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='mdi mdi-account-star float-end'></i>
                <h4 class="text-uppercase mt-0">เตรียมนักกีฬา</h4>
                <h2 class="my-2 text-primary" id="active-users-count">
                    {{ $users->where('learn_type_learn_type_id', '4')->count() }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    {{-- <span class="text-nowrap">เมื่อไม่นานมานี้</span> --}}
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-6 col-lg-6 col-sm-12 col-md-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='mdi mdi-swim float-end'></i>
                <h4 class="text-uppercase mt-0">นักกีฬา</h4>
                <h2 class="my-2 text-primary" id="active-users-count">
                    {{ $users->where('learn_type_learn_type_id', '5')->count() }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    {{-- <span class="text-nowrap">เมื่อไม่นานมานี้</span> --}}
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <h4 class="page-title">รายชื่อนักเรียนทั้งหมด</h4>
@endsection


@section('conten')
    <table class="table table-centered mb-0 " id="basic-datatable" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th style="width: 5%" class="text-center">#ID</th>
                <th style="width: 10%" class="text-center">ชื่อเล่น</th>
                <th style="width: 15%" class="text-center">ชื่อจริง</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 12%">นามสกุล</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 5%">อายุ</th>
                <th style="width: 10%" class="text-center">รูปแบบการเรียน</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 8%">เพศ</th>
                <th style="width: 15%" class="text-center">จัดการข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($user->user_status_user_status_id != '1' && $user->user_status_user_status_id != '3')
                    <tr>
                        <td class="text-center">
                            <h5>{{ $user->user_id }}</h5>
                        </td>
                        <td class="text-center">{{ $user->nick_name }}</td>
                        <td class="text-center">{{ $user->first_name }}</td>
                        <td class="d-none d-sm-table-cell text-center">{{ $user->last_name }}</td>
                        <td class="d-none d-sm-table-cell text-center">{{ $user->Agee }}</td>
                        <td class="text-center">
                            @if ($user->user_type && $user->user_type->learn_type_name == 'คู่')
                                <span
                                    class="badge bg-success p-1">{{ $user->user_type ? $user->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                            @elseif($user->user_type && $user->user_type->learn_type_name == 'เดี่ยว')
                                <span
                                    class="badge bg-warning p-1">{{ $user->user_type ? $user->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                            @elseif($user->user_type && $user->user_type->learn_type_name == 'กลุ่ม')
                                <span
                                    class="badge bg-danger p-1">{{ $user->user_type ? $user->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                            @else
                                <span
                                    class="badge bg-primary p-1">{{ $user->user_type ? $user->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                            @endif
                        </td>

                        <td class="d-none d-sm-table-cell text-center">
                            @if ($user->gender == '1')
                                <h5><i class="mdi mdi-gender-male" style="color: rgb(103, 103, 255)"></i> ชาย</h5>
                            @else
                                <h5><i class="mdi mdi-gender-female" style="color: rgb(250, 176, 188)"></i> หญิง</h5>
                            @endif
                        </td>

                        <td class="table-action text-center">
                            <a href="{{ route('studentshow', $user->user_id) }}" class="action-icon"><i
                                    class="mdi mdi-eye"></i></a>
                            <a href="{{ route('editstudent', $user->user_id) }}" class="action-icon"><i
                                    class="mdi mdi-pencil"></i></a>
                            <a href="#" class="action-icon delete-btn" data-id="{{ $user->user_id }}"><i
                                    class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection
