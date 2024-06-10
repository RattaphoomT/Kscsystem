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

        <form action="{{ route('record.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-6 mt-3">

                    <div class="form-group mt-3">
                        <label for="user_learn_id">ชื่อผู้เรียน</label>
                        <select name="user_learn_id" class="form-control select2 mt-1" required>
                            <option value="">กรุณาเลือกชื่อผู้เรียน..</option>
                            @foreach ($users as $item)
                                @if ($item->user_status_user_status_id != '1' && $item->user_status_user_status_id != '3')
                                    <option value="{{ $item->user_id }}">{{ $item->nick_name }}  {{ $item->first_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="user_teach_id">ชื่อผู้สอน</label>
                        <select name="user_teach_id" class="form-control select2 mt-1" required>
                            <option value="">กรุณาเลือกผู้สอน..</option>
                            @foreach ($users as $item)
                                @if ($item->user_status_user_status_id == '3')
                                    <option value="{{ $item->user_id }}">{{ $item->nick_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="learn_type_id">รูปเเบบการสอน</label>
                        <select name="learn_type_id" class="form-control select2 mt-1" required>
                            <option value="">กรุณาเลือกรูปเเบบการสอน..</option>
                            @foreach ($learntype as $item)
                                    <option value="{{ $item->learn_type_id }}">{{ $item->learn_type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="note">พัฒนาการ</label>
                        <input type="text" name="note" class="form-control mt-1">
                    </div>
                    
                    

                </div>

            </div>
            <button type="submit" class="btn btn-primary mt-3">บันทึก</button>
        </form>
    </div>
@endsection
