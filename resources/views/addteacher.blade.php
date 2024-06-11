@extends('layout')

@section('title')
    เพิ่มคุณครู | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">เพิ่มคุณครู</h4>
@endsection

@section('nonconten')
@endsection

@section('conten')
    <div class="container">
        <h3 class="text-center">เพิ่มข้อมูลครู</h3>
        <hr>

        <form action="{{ route('teacher.store') }}" method="POST" id="load">
            @csrf
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="first_name">ชื่อจริง</label>
                        <input type="text" name="first_name" class="form-control mt-1" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="last_name">นามสกุล</label>
                        <input type="text" name="last_name" class="form-control mt-1" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nick_name">ชื่อเล่น</label>
                        <input type="text" name="nick_name" class="form-control mt-1" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="gender">เพศ</label>
                        <select name="gender" class="form-control mt-1" required>
                            <option value="">กรุณาเลือกเพศ..</option>
                            <option value="1">ชาย</option>
                            <option value="2">หญิง</option>
                        </select>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="birthday">วันเกิด</label>
                        <input type="text" name="birthday" id="birthday" class="form-control datepicker" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="Agee">อายุ</label>
                        <input type="number" name="Agee" id="age" class="form-control mt-1" readonly>
                    </div>
                    <input type="hidden" name="user_status_user_status_id" value="3">
                </div>

                <div class="col-md-6 ">
                    <div class="form-group mt-3">
                        <label for="bank_name">ชื่อธนาคาร</label>
                        <input type="text" name="bank_name" class="form-control mt-1">
                    </div>
                    <div class="form-group mt-3">
                        <label for="bank_number">เลขบัญชี</label>
                        <input type="text" name="bank_number" class="form-control mt-1">
                    </div>
                    <div class="form-group mt-3">
                        <label for="mobile_phone">เบอร์ติดต่อ</label>
                        <input type="text" name="mobile_phone" class="form-control mt-1">
                    </div>
                    <div class="form-group mt-3">
                        <label for="id_line">ไอดีไลน์</label>
                        <input type="text" name="id_line" class="form-control mt-1">
                    </div>
                   
                        
                    <input type="hidden" name="password" value="12345678">

                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">บันทึก</button>
        </form>
    </div>
@endsection
