@extends('layout')

@section('title')
    จัดการข้อมมูลนักเรียน | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">จัดการข้อมมูลนักเรียน</h4>
@endsection

@section('nonconten')
@endsection


@section('conten')
    <a href="{{ route('addstudent') }}" class="btn btn-success mb-3">เพิ่มนักเรียน</a>


    <table class="table table-centered mb-0" id="basic-datatable" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th style="width: 5%" class="text-center">#ID</th>
                <th style="width: 10%">ชื่อเล่น</th>
                <th style="width: 15%">ชื่อจริง</th>
                <th class="d-none d-sm-table-cell" style="width: 10%">นามสกุล</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 7%">เรียน</th>
                <th style="width: 10%">รูปแบบการเรียน</th>
                <th class="d-none d-sm-table-cell" style="width: 8%">เพศ</th>
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
                        <td>{{ $user->nick_name }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td class="d-none d-sm-table-cell">{{ $user->last_name }}</td>

                        <td class="d-none d-sm-table-cell text-center">
                            @if ($user->course->isNotEmpty())
                                @php
                                    $course = $user->course->first();
                                    $learnCount = $course->learn->count();
                                @endphp
                                @if ($learnCount > 0)
                                    {{ $learnCount }}/{{ $course->learn_amount }}
                                @else
                                    0/{{ $course->learn_amount }}
                                @endif
                            @else
                                ไม่มีคอร์ส
                            @endif
                        </td>

                        <td class="text-center">
                            @if ($user->course->isNotEmpty() && isset($user->course->first()->learn_type))
                                @if ($user->course->first()->learn_type->learn_type_name == 'คู่')
                                    <span class="badge bg-success p-1">{{ $user->course->first()->learn_type->learn_type_name }}</span>
                                @elseif ($user->course->first()->learn_type->learn_type_name == 'เดี่ยว')
                                    <span class="badge bg-warning p-1">{{ $user->course->first()->learn_type->learn_type_name }}</span>
                                @elseif ($user->course->first()->learn_type->learn_type_name == 'กลุ่ม')
                                    <span class="badge bg-danger p-1">{{ $user->course->first()->learn_type->learn_type_name }}</span>
                                @else
                                    <span class="badge bg-primary p-1">{{ $user->course->first()->learn_type->learn_type_name }}</span>
                                @endif
                            @else
                                <span class="badge bg-primary p-1">ไม่ระบุ</span>
                            @endif
                        </td>

                        <td class="d-none d-sm-table-cell">
                            @if ($user->gender == '1')
                                <h5><i class="mdi mdi-gender-male" style="color: rgb(103, 103, 255)"></i> ชาย</h5>
                            @else
                                <h5><i class="mdi mdi-gender-female" style="color: rgb(250, 176, 188)"></i> หญิง</h5>
                            @endif
                        </td>

                        <td class="table-action d-flex justify-content-center">
                            <a href="{{ route('studentshow', $user->user_id) }}" class="action-icon"><i
                                    class="mdi mdi-eye"></i></a>
                            <a href="{{ route('editstudent', $user->user_id) }}" class="action-icon"><i
                                    class="mdi mdi-pencil"></i></a>
                            <a href="#" class="action-icon delete-btn" data-id="{{ $user->user_id }}"><i
                                    class="mdi mdi-delete"></i></a>

                            {{-- <a href="{{ route('pdf.student', $user->user_id) }}" class=" btn btn-success">export</a> --}}

                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection
