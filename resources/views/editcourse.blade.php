@extends('layout')

@section('title')
    เเก้ไขคอร์ส | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">เเก้ไขคอร์ส</h4>
@endsection

@section('nonconten')
@endsection

@section('conten')
    <div class="container">
        <h3 class="text-center">เเก้ไขคอร์สของ ( {{ $course->user_course->nick_name }} )</h3>
        <hr>

        
        <form action="{{ route('course.update', $course->course_id) }}" method="POST" id="load">
            @csrf
            <div class="row d-flex justify-content-center">

                <div class="col-md-6 mt-3">

                    <div class="form-group mt-3">
                        <label for="course_user_id">คอร์สไอดี</label>
                        <input type="text" name="course_user_id"  class="form-control mt-1" value="{{ $course->course_id }}" readonly>
                    </div>

                    
                    <div class="form-group mt-3">
                        <label for="learntype_id">รูปเเบบการเรียน</label>
                        <select name="learntype_id" class="form-control select2 mt-1" required>
                            <option value="{{ $course->learntype_id }}">{{ $course->learn_type->learn_type_name }}</option>
                            @foreach ($learntype as $item)
                                    <option value="{{ $item->learn_type_id }}">{{ $item->learn_type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="learn_amount">จำนวนครั้งในการเรียน</label>
                        <input type="number" name="learn_amount"  class="form-control mt-1"  value="{{ $course->learn_amount }}" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="date_pay">วันที่จ่ายเงิน</label>
                        <input type="text" name="date_pay" id="date_pay" value="{{ $course->date_pay }}" class="form-control datepicker ">
                    </div>
                    
                </div>

            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3" >บันทึก</button>
            </div>
        </form>
    </div>
@endsection
