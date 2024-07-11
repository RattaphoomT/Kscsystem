@extends('layout')

@section('title')
    ข้อมมูลนักเรียน | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">ข้อมูลนักเรียน</h4>
@endsection

@section('nonconten')
@endsection

@section('conten')
    <div class="container">
        <h3 class="text-center">ข้อมูลนักเรียน #{{ Auth::user()->user_id }}</h3>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <h5>ชื่อเล่น : {{ Auth::user()->nick_name }}</h5>
                <h5>อายุ : {{ Auth::user()->age }} ปี</h5>
                <h5>โรงเรียน : {{ Auth::user()->school }}</h5>
            </div>
            <div class="col-sm-4">
                <div class="col">
                    <h5>ชื่อจริง : {{ Auth::user()->first_name }}</h5>
                    <h5>นามสกุล : {{ Auth::user()->last_name }}</h5>
                    {{-- <h5 class="position-relative">รูปแบบการเรียน :
                        @if (Auth::user()->user_type && Auth::user()->user_type->learn_type_name == 'คู่')
                            <span
                                class="badge bg-success p-1">{{ Auth::user()->user_type ? Auth::user()->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @elseif(Auth::user()->user_type && Auth::user()->user_type->learn_type_name == 'เดี่ยว')
                            <span
                                class="badge bg-warning p-1 position-relative">{{ Auth::user()->user_type ? Auth::user()->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @elseif(Auth::user()->user_type && Auth::user()->user_type->learn_type_name == 'กลุ่ม')
                            <span
                                class="badge bg-danger p-1 position-relative">{{ Auth::user()->user_type ? Auth::user()->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @else
                            <span
                                class="badge bg-primary p-1">{{ Auth::user()->user_type ? Auth::user()->user_type->learn_type_name : 'ไม่ระบุ' }}</span>
                        @endif
                    </h5> --}}
                </div>
            </div>
            <div class="col-sm-4">
                @php
                    use Carbon\Carbon;
                    Carbon::setLocale('th');
                    $updateAt = Carbon::parse(Auth::user()->update_at);
                    $now = Carbon::now();
                    $diffForHumans = $updateAt->diffForHumans($now, [
                        'parts' => 3,
                        'join' => true,
                        'short' => true,
                    ]);
                @endphp
                <h5>วันที่สมัครเรียน : {{ Auth::user()->regis_at }}</h5>
                <h5>แก้ไขข้อมูลล่าสุดเมื่อ : {{ $diffForHumans }}</h5>
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
        <h4><i class="uil-users-alt"></i> ข้อมูลผู้ปกครอง</h4>
        <div class="row">
            <div class="col-sm-3">
                <h5>ชื่อผู้ปกครอง : {{ Auth::user()->parent_name }}</h5>
                <h5>เบอร์ติดต่อ : {{ Auth::user()->mobile_phone }}</h5>
                <h5>ไอดีไลน์ : {{ Auth::user()->id_line }}</h5>
            </div>
        </div>
        <h4 class="mt-3"><i class=" uil-file-alt"></i> ประวัติการเรียน ( {{ Auth::user()->nick_name }} )</h4>
        <hr>

        @foreach (Auth::user()->course->sortByDesc('date_pay') as $index => $course)
            <h2 class="text-center mt-4">คอร์สที่ {{ $index + 1 }}</h2>
            <h4 class="text-center">
                @if (isset($course->learn_type))
                    @if ($course->learn_type->learn_type_name == 'คู่')
                        {{ $course->learn_type->learn_type_name }}
                    @elseif ($course->learn_type->learn_type_name == 'เดี่ยว')
                        {{ $course->learn_type->learn_type_name }}
                    @elseif ($course->learn_type->learn_type_name == 'กลุ่ม')
                        {{ $course->learn_type->learn_type_name }}
                    @else
                        {{ $course->learn_type->learn_type_name }}
                    @endif
                @else
                    ไม่ระบุ
                @endif
            </h4>
            <h5>สมัครคอร์สเมื่อ : {{ $course->date_pay }}</h5>

            <h5>จำนวนครั้งในการเรียน : {{ $course->learn->count() }}/{{ $course->learn_amount }}
                @if ($course->learn->count() == $course->learn_amount)
                    <h5 class="text-success">เรียนครบเเล้ว</h5>
                @else
                    <h5 class="text-danger">ยังเรียนไม่ครบ</h5>
                @endif
            </h5>

            <table class="table table-centered mb-0 table-sm-12" id="basic-datatable" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%" class="text-center">ครั้งที่มาเรียน</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 10%">ไอดีเรียน</th>
                        <th style="width: 10%" class="text-center">ครูผู้สอน</th>
                        <th style="width: 10%" class="text-center">การเรียน</th>
                        <th style="width: 30%" class="text-center">พัฒนาการ</th>
                        <th style="width: 30%" class="text-center">เรียนเมื่อ</th>
                    </tr>
                </thead>
                <tbody>
                    @if (Auth::user()->course->isNotEmpty())
                        @foreach ($course->learn as $learn)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="d-none d-sm-table-cell text-center">{{ $learn->learn_id }}</td>
                                <td class="text-center">{{ $learn->user_teach->nick_name }}</td>
                                <td class="text-center">
                                    @if ($learn->learn_type->learn_type_name == 'เดี่ยว')
                                        <span
                                            class="badge bg-warning p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @elseif ($learn->learn_type->learn_type_name == 'คู่')
                                        <span
                                            class="badge bg-success p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @elseif ($learn->learn_type->learn_type_name == 'กลุ่ม')
                                        <span
                                            class="badge bg-danger p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @else
                                        <span
                                            class="badge bg-primary p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @endif
                                </td>
                                <td>{{ $learn->note }}</td>
                                <td class="text-center">{{ $learn->learn_at }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">ไม่มีข้อมูลการเรียนในคอร์สนี้</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach

    </div>
@endsection
