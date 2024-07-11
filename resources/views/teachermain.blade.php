@extends('layout')

@section('title')
    ข้อมูลคุณครู | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">
        ข้อมูลคุณครู</h4>
@endsection

@section('nonconten')
@endsection

@section('conten')
    <div class="container">
        <h3 class="text-center">ข้อมูลคุณครู #{{ Auth::user()->user_id }}</h3>
        <hr>

        <div class="row">
            <div class="col-sm-4">
                <h5>ชื่อเล่น : {{ Auth::user()->nick_name }}</h5>
                <h5>อายุ : {{ Auth::user()->Agee }} ปี</h5>
            </div>
            <div class="col-sm-4">
                <div class="col">
                    <h5>ชื่อจริง : {{ Auth::user()->first_name }}</h5>
                    <h5>นามสกุล : {{ Auth::user()->last_name }}</h5>

                    <h5 class="position-relative">สถาณะ :
                        @if (Auth::user()->user_status && Auth::user()->user_status->user_status_name == 'คุณครู')
                            <span class="badge bg-success p-1">{{ Auth::user()->user_status->user_status_name }}</span>
                        @else
                            <span class="badge bg-secondary p-1">ไม่ระบุ</span>
                        @endif
                    </h5>
                </div>
            </div>

            <div class="col-sm-4">
                @php
                    use Carbon\Carbon;
                    Carbon::setLocale('th');
                    $updatedAt = Carbon::parse(Auth::user()->updated_at);
                    $now = Carbon::now();
                    $diffForHumans = $updatedAt->diffForHumans($now, [
                        'parts' => 3,
                        'join' => true,
                        'short' => true,
                    ]);
                @endphp

                <h5>วันที่ลงทะเบียน : {{ Auth::user()->regis_at }}</h5>
                <h5>เเก้ไขข้อมูลล่าสุดเมื่อ : {{ $diffForHumans }}</h5>
                <h5>วันเกิด : {{ Auth::user()->birthday }}</h5>

                <h5>เพศ :
                    @if (Auth::user()->gender == '1')
                        <i class="mdi mdi-gender-male" style="color: rgb(103, 103, 255)"></i>ชาย
                    @else
                        <i class="mdi mdi-gender-female" style="color: rgb(250, 176, 188)"></i>หญิง
                    @endif
                </h5>
            </div>
        </div>
        <hr>

        <h4><i class="uil-users-alt"></i> ช่องทางติดต่อ</h4>
        <div class="row">
            <div class="col-sm-3">
                <h5>ชื่อธนาคาร : {{ Auth::user()->bank_name }}</h5>
                <h5>เลขบัญชี : {{ Auth::user()->bank_number }}</h5>
                <h5>เบอร์ : {{ Auth::user()->mobile_phone }}</h5>
                <h5>ไอดีไลน์ : {{ Auth::user()->id_line }}</h5>
            </div>
        </div>

        <h4 class="mt-3"><i class=" uil-file-alt"></i> ประวัติการสอน ( {{ Auth::user()->nick_name }} )</h4>
        <hr>


        <table class="table table-centered mb-0 " id="basic-datatable" style="width: 100%">
            <thead class="table-dark">
                <tr>
                    <th style="width: 10%">ครั้งที่สอน</th>
                    <th class="d-none d-sm-table-cell" style="width: 10%">ไอดีการสอน</th>
                    <th style="width: 10%">ชื่อเล่น</th>
                    <th class="d-none d-sm-table-cell" style="width: 10%">ชื่อจริง</th>
                    <th style="width: 10%" class="text-center">การเรียน</th>
                    <th style="width: 30%" class="text-center">หมายเหตุ</th>
                    <th style="width: 20%" class="text-center">สอนเมื่อ</th>
                </tr>
            </thead>
            <tbody>
                @forelse (Auth::user()->teach as $index => $record)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="d-none d-sm-table-cell text-center">{{ $record->learn_id }}</td>
                        <td class="text-center">{{ $record->user_learn->nick_name }}</td>
                        <td class="text-center d-none d-sm-table-cell text-center">{{ $record->user_learn->first_name }}</td>
                        <td class="text-center">
                            @switch($record->learn_type->learn_type_name)
                                @case('เดี่ยว')
                                    <span class="badge bg-warning p-1">{{ $record->learn_type->learn_type_name }}</span>
                                @break
    
                                @case('คู่')
                                    <span class="badge bg-success p-1">{{ $record->learn_type->learn_type_name }}</span>
                                @break
    
                                @case('กลุ่ม')
                                    <span class="badge bg-danger p-1">{{ $record->learn_type->learn_type_name }}</span>
                                @break
    
                                @default
                                    <span class="badge bg-primary p-1">{{ $record->learn_type->learn_type_name }}</span>
                            @endswitch
                        </td>
                        <td class="text-center">{{ $record->note }}</td>
                        <td class="text-center">{{ $record->learn_at }}</td>
                    </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
    </div> 
@endsection
