@extends('layout')

@section('title')
    จัดการข้อมูลครู | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">จัดการข้อมูลครู</h4>
@endsection

@section('nonconten')
@endsection


@section('conten')
    <a href="{{ route('addteacher') }}" class="btn btn-success mb-3">เพิ่มคุณครู</a>
    
    
        <table class="table table-centered mb-0" id="basic-datatable" style="width: 100%">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%" class="text-center">#ID</th>
                    <th style="width: 13%">ชื่อ</th>
                    <th style="width: 13%">ชื่อจริง</th>
                    <th class="d-none d-sm-table-cell" style="width: 12%">นามสกุล</th>
                    <th class="d-none d-sm-table-cell" style="width: 5%">อายุ</th>
                    <th class="d-none d-sm-table-cell" style="width: 7%">สถาณะ</th>
                    <th style="width: 10%">เพศ</th>
                    <th style="width: 15%">จัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if ($user->user_status_user_status_id == '3')
                        <tr>
                            <td class="text-center">
                                <h5>{{ $user->user_id }}</h5>
                            </td>
                            <td>{{ $user->nick_name }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td class="d-none d-sm-table-cell">{{ $user->last_name }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $user->Agee }}</td>

                            <td class="d-none d-sm-table-cell" >
                                @if ( $user->user_status && $user->user_status->user_status_name == 'คุณครู' )
        
                                    <span class="badge bg-success p-1">{{ $user->user_status ? $user->user_status->user_status_name : 'ไม่ระบุ' }}</span>
                                
                                @endif
                            </td>

                            <td>
                                @if ($user->gender == '1')
                                    <h5><i class="mdi mdi-gender-male" style="color: rgb(103, 103, 255)"></i> ชาย</h5>
                                @else
                                    <h5><i class="mdi mdi-gender-female" style="color: rgb(250, 176, 188)"></i> หญิง</h5>
                                @endif
                            </td>

                            <td class="table-action">
                                <a href="{{ route('teachershow', $user->user_id) }}" class="action-icon"><i
                                        class="mdi mdi-eye"></i></a>
                                <a href="{{ route('editteacher', $user->user_id) }}" class="action-icon"><i class="mdi mdi-pencil"></i></a>

                                <a href="#" class="action-icon delete-teacher" data-id="{{ $user->user_id }}"><i class="mdi mdi-delete"></i></a>
                            </td>

                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    
@endsection
