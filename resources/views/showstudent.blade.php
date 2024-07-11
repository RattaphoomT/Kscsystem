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

            <div class="col-sm-3 d-flex justify-content-center">
                <img src="{{ asset($show->user_img) }}" alt="User Image" class="img-fluid" style="width: 50%; border-radius: 3%;">
            </div>

            <div class="col-sm-2">
                <h5>ชื่อเล่น : {{ $show->nick_name }}</h5>
                <h5>อายุ : {{ $show->Agee }} ปี</h5>
                <h5>โรงเรียน : {{ $show->school }}</h5>
                <h5>ชื่อจริง : {{ $show->first_name }}</h5>
                <h5>นามสกุล : {{ $show->last_name }}</h5>
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

            <div class="col-sm-3">
                <h5>ชื่อผู้ปกครอง : {{ $show->parent_name }}</h5>
                <h5>เบอร์ติดต่อ : {{ $show->mobile_phone }}</h5>
                <h5>ไอดีไลน์ : {{ $show->id_line }}</h5>
            </div>

        </div>
        

        <hr>

        <h3 class="mt-4 text-center"><i class=" uil-file-alt"></i> ประวัติการเรียนของ ( {{ $show->nick_name }} )</h3>
     

        @foreach ($show->course->sortByDesc('date_pay') as $index => $course)
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

            <h5 class="mt-4">สมัครคอร์สเมื่อ : {{ $course->date_pay }}</h5>
            <h5>จำนวนครั้งในการเรียน : {{ $course->learn->count() }}/{{ $course->learn_amount }}
                @if ($course->learn->count() == $course->learn_amount)
                    <h5 class="text-success">เรียนครบเเล้ว</h5>
                @else
                <h5 class="text-danger">ยังเรียนไม่ครบ</h5>
                @endif
            </h5>
            <table class="table table-centered mb-0 table-sm-12 show-student-datatable" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%" class="text-center">ครั้งที่มาเรียน</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 10%">ไอดีเรียน</th>
                        <th style="width: 10%" class="text-center">ครูผู้สอน</th>
                        <th style="width: 10%">การเรียน</th>
                        <th style="width: 30%" class="d-none d-sm-table-cell text-center">พัฒนาการ</th>
                        <th style="width: 30%" class="text-center">เรียนเมื่อ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($course->learn->isNotEmpty())
                        @php $learnIndex = 1; @endphp
                        @foreach ($course->learn as $learn)
                            <tr>
                                <td class="text-center">{{ $learnIndex }}</td>
                                <td class="d-none d-sm-table-cell text-center">{{ $learn->learn_id }}</td>
                                <td class="text-center">{{ $learn->user_teach->nick_name }}</td>
                                <td>
                                    @if ($learn->learn_type->learn_type_name == 'เดี่ยว')
                                        <span class="badge bg-warning p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @elseif($learn->learn_type->learn_type_name == 'คู่')
                                        <span class="badge bg-success p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @elseif($learn->learn_type->learn_type_name == 'กลุ่ม')
                                        <span class="badge bg-danger p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @else
                                        <span class="badge bg-primary p-1 position-relative">{{ $learn->learn_type->learn_type_name }}</span>
                                    @endif
                                </td>
                                <td class="d-none d-sm-table-cell text-center">{{ $learn->note }}</td>
                                <td class="text-center">{{ $learn->learn_at }}</td>
                            </tr>
                            @php $learnIndex++; @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">ไม่มีข้อมูลการเรียนในคอร์สนี้</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <hr>
        @endforeach
    </div>
@endsection
