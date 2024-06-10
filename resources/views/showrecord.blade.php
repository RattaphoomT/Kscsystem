@extends('layout')

@section('title')
    รายงานผลการสอน | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">รายงานผลการสอน</h4>
@endsection

@section('nonconten')
@endsection


@section('conten')
    <a href="{{ route('addrecord') }}" class="btn btn-success mb-3">เพิ่มรายการสอน</a>


    <table class="table table-centered mb-0" id="basic-datatable" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th style="width: 5%" class="text-center">#ID</th>
                <th style="width: 10%" class="text-center">ชื่อนักเรียน</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 10%">ชื่อจริง</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 10%">นามสกุล</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 10%">เพศ</th>
                <th style="width: 10%">ชื่อครู</th>
                <th style="width: 10%">การเรียน</th>
                <th class="d-none d-sm-table-cell text-center" style="width: 20%">เรียนเมื่อ</th>
                <th style="width: 15%" class="text-center">จัดการข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($show as $item)
                <tr>
                    <td class="text-center">
                        <h5>{{ $item->learn_id }}</h5>
                    </td>
                    <td class="text-center">{{ $item->user_learn->nick_name }}</td>
                    <td class="d-none d-sm-table-cell text-center">{{ $item->user_learn->first_name }}</td>
                    <td class="d-none d-sm-table-cell text-center">{{ $item->user_learn->last_name }}</td>

                    <td class="d-none d-sm-table-cell">
                        @if ($item->user_learn->gender == '1')
                            <h5><i class="mdi mdi-gender-male" style="color: rgb(103, 103, 255)"></i> ชาย</h5>
                        @else
                            <h5><i class="mdi mdi-gender-female" style="color: rgb(250, 176, 188)"></i> หญิง</h5>
                        @endif
                    </td>

                    <td>{{ $item->user_teach->nick_name }}</td>

                    <td class="text-center">
                        @if ($item->learn_type->learn_type_name == 'คู่')
                            <span
                                class="badge bg-success p-1">{{ $item->learn_type ? $item->learn_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @elseif($item->learn_type->learn_type_name == 'เดี่ยว')
                            <span
                                class="badge bg-warning p-1">{{ $item->learn_type ? $item->learn_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @elseif($item->learn_type->learn_type_name == 'กลุ่ม')
                            <span
                                class="badge bg-danger p-1">{{ $item->learn_type ? $item->learn_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @else
                            <span
                                class="badge bg-primary p-1">{{ $item->learn_type ? $item->learn_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @endif
                    </td>

                    <td class="d-none d-sm-table-cell text-center">{{ $item->learn_at }}</td>

                    

                    

                    <td class="table-action text-center">
                        {{-- <a href="{{ route('studentshow', $user->user_id) }}" class="action-icon"><i
                                class="mdi mdi-eye"></i></a>
                        <a href="{{ route('editstudent', $user->user_id) }}" class="action-icon"><i
                                class="mdi mdi-pencil"></i></a> --}}
                        <a href="#" class="action-icon delete-learn-btn" data-id="{{ $item->learn_id }}"><i
                                class="mdi mdi-delete"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
