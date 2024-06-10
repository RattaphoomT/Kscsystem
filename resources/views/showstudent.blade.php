@extends('layout')

@section('title')
    ข้อมูลนักเรียน | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">
        ข้อมูลนักเรียน</h4>
@endsection

@section('nonconten')
@endsection


@section('conten')
    <div class="container">
        <h3 class="text-center">ข้อมูลนักเรียน #{{ $show->user_id }}</h3>
        <hr>


        <div class="row">
            <div class="col-sm-4">
                <h5>ชื่อเล่น : {{ $show->nick_name }}</h5>
                <h5>อายุ : {{ $show->Agee }} ปี</h5>
                <h5>โรงเรียน : {{ $show->school }}</h5>
            </div>
            <div class="col-sm-4">
                <div class="col">
                    <h5>ชื่อจริง : {{ $show->first_name }}</h5>
                    <h5>นามสกุล : {{ $show->last_name }}</h5>
                    <h5 class="position-relative">รูปเเบบการเรียน :
                        @if ($show->user_type && $show->user_type->learn_type_name == 'คู่')
                            <span
                                class="badge bg-success p-1">{{ $show->user_type ? $show->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @elseif($show->user_type && $show->user_type->learn_type_name == 'เดี่ยว')
                            <span
                                class="badge bg-warning p-1 position-relative">{{ $show->user_type ? $show->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @elseif($show->user_type && $show->user_type->learn_type_name == 'กลุ่ม')
                            <span
                                class="badge bg-danger p-1 position-relative">{{ $show->user_type ? $show->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @else
                            <span
                                class="badge bg-primary p-1">{{ $show->user_type ? $show->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @endif
                    </h5>
                </div>
            </div>

            <div class="col-sm-4">
                @php
                    use Carbon\Carbon;

                    Carbon::setLocale('th');
                    $updateAt = Carbon::parse($show->update_at);
                    $now = Carbon::now();
                    $diffForHumans = $updateAt->diffForHumans($now, [
                        'parts' => 3,
                        'join' => true,
                        'short' => true,
                    ]);
                @endphp

                <h5>วันที่สมัครเรียน : {{ $show->regis_at }}</h5>
                <h5>เเก้ไขข้อมูลล่าสุดเมื่อ : {{ $diffForHumans }}</h5>
                <h5>วันเกิด : {{ $show->birthday }}</h5>

                <h5>เพศ :
                    @if ($show->gender == '1')
                        <i class="mdi mdi-gender-male" style="color: rgb(103, 103, 255)"></i>ชาย
                    @else
                        <i class="mdi mdi-gender-female" style="color: rgb(250, 176, 188)"></i>หญิง
                    @endif
                </h5>

            </div>
        </div>
        <hr>

        <h4><i class="uil-users-alt"></i> ข้อมูลผู้ปกครอง</h4>
        <div class="row">

            <div class="col-sm-3">
                <h5>ชื่อผู้ปกครอง : {{ $show->parent_name }}</h5>
                <h5>เบอร์ติดต่อ : {{ $show->mobile_phone }}</h5>
                <h5>ไอดีไลน์ : {{ $show->id_line }}</h5>
            </div>

        </div>

        <h4 class="mt-3"><i class=" uil-file-alt"></i> ประวัติการเรียน ( {{ $show->nick_name }} )</h4>
        <hr>

        <table class="table table-centered mb-0 table-sm-12" id="basic-datatable" style="width: 100%">
            <thead class="table-dark">
                <tr>
                    <th style="width: 10%" class="text-center">ครั้งที่มาเรียน</th>
                    <th class="d-none d-sm-table-cell text-center" style="width: 10%">ไอดีเรียน</th>
                    <th style="width: 10%" class="text-center">ครูผู้สอน</th>
                    <th style="width: 10%">การเรียน</th>
                    <th style="width: 30%" class="text-center">พัฒนาการ</th>
                    <th style="width: 30%" class="text-center">เรียนเมื่อ</th>
                </tr>
            </thead>
            <tbody>
                @if ($show->learn->isNotEmpty())
                    @php $index = 1; @endphp
                    @foreach ($show->learn as $learn_type_id)
                        <tr>
                            <td class="text-center">{{ $index }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $learn_type_id->learn_id }}</td>
                            <td class="text-center">{{ $learn_type_id->user_teach->nick_name }}</td>
                            <td>
                                @if ($learn_type_id->learn_type->learn_type_name == 'เดี่ยว')
                                    <span
                                        class="badge bg-warning p-1 position-relative">{{ $learn_type_id->learn_type->learn_type_name }}</span>
                                @elseif($learn_type_id->learn_type->learn_type_name == 'คู่')
                                    <span
                                        class="badge bg-success p-1 position-relative">{{ $learn_type_id->learn_type->learn_type_name }}</span>
                                @elseif($learn_type_id->learn_type->learn_type_name == 'กลุ่ม')
                                    <span
                                        class="badge bg-danger p-1 position-relative">{{ $learn_type_id->learn_type->learn_type_name }}</span>
                                @else
                                    <span
                                        class="badge bg-primary p-1 position-relative">{{ $learn_type_id->learn_type->learn_type_name }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $learn_type_id->note }}
                            </td>
                            <td class="text-center">{{ $learn_type_id->learn_at }}</td>
                        </tr>
                        @php $index++; @endphp
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
    </div>
@endsection
