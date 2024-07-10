@extends('layout')

@section('title')
    บันทึกการสอน | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">บันทึกการสอน</h4>
@endsection

@section('nonconten')
@endsection

@section('conten')
    <div class="container">
        <h3 class="text-center">บันทึกการสอน</h3>
        <hr>

        
        <form action="{{ route('course.store') }}" method="POST" id="load">
            @csrf
            <div class="row">

                <div class="col-md-6 mt-3">

                    <div class="form-group mt-3">
                        <label for="course_user_id">ชื่อนักเรียนที่ต้องการต่อคอร์ส</label>
                        <select name="course_user_id" class="form-control select2 mt-1" required>
                            <option value="">กรุณาเลือกชื่อนักเรียน..</option>
                            @foreach ($users as $item)
                                @if ($item->user_status_user_status_id != '1' && $item->user_status_user_status_id != '3')
                                    <option value="{{ $item->user_id }}">{{ $item->nick_name }}  {{ $item->first_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="form-group mt-3">
                        <label for="learntype_id">รูปเเบบการเรียน</label>
                        <select name="learntype_id" class="form-control select2 mt-1" required>
                            <option value="">กรุณาเลือกรูปเเบบการเรียน..</option>
                            @foreach ($learntype as $item)
                                    <option value="{{ $item->learn_type_id }}">{{ $item->learn_type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="learn_amount">จำนวนครั้งในการเรียน</label>
                        <input type="number" name="learn_amount"  class="form-control mt-1" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="date_pay">วันที่จ่ายเงิน</label>
                        <input type="text" name="date_pay" id="date_pay" class="form-control datepicker">
                    </div>
                    
                </div>

            </div>
            <button type="submit" class="btn btn-primary mt-3">บันทึก</button>
        </form>
    </div>
@endsection
