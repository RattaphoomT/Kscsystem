<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ข้อมูลนักเรียน #{{ $student->user_id }}</title>
    <style>
        body { font-family: 'Garuda', sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        .header { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h3 class="text-center">ข้อมูลนักเรียน #{{ $student->user_id }}</h3>
        <hr>
        <div>
            <h5>ชื่อเล่น: {{ $student->nick_name }}</h5>
            <h5>อายุ: {{ $student->Agee }} ปี</h5>
            <h5>โรงเรียน: {{ $student->school }}</h5>
            <h5>ชื่อจริง: {{ $student->first_name }}</h5>
            <h5>นามสกุล: {{ $student->last_name }}</h5>
            <h5>รูปแบบการเรียน: {{ $student->user_type ? $student->user_type->learn_type_name : 'ไม่ระบุ' }}</h5>
            <h5>วันที่สมัครเรียน: {{ $student->regis_at }}</h5>
            <h5>วันเกิด: {{ $student->birthday }}</h5>
            <h5>เพศ: {{ $student->gender == 1 ? 'ชาย' : 'หญิง' }}</h5>
        </div>
        <hr>
        <h4>ข้อมูลผู้ปกครอง</h4>
        <div>
            <h5>ชื่อผู้ปกครอง: {{ $student->parent_name }}</h5>
            <h5>เบอร์ติดต่อ: {{ $student->mobile_phone }}</h5>
            <h5>ไอดีไลน์: {{ $student->id_line }}</h5>
        </div>
        <hr>
    </div>

    <h4>ประวัติการเรียน ( {{ $student->nick_name }} )</h4>
    <table>
        <thead>
            <tr>
                <th>ครั้งที่มาเรียน</th>
                <th>ไอดีเรียน</th>
                <th>ครูผู้สอน</th>
                <th>การเรียน</th>
                <th>พัฒนาการ</th>
                <th>เรียนเมื่อ</th>
            </tr>
        </thead>
        <tbody>
            @if ($student->learn->isNotEmpty())
                @foreach ($student->learn as $index => $learn)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $learn->learn_id }}</td>
                        <td>{{ $learn->user_teach->nick_name }}</td>
                        <td>{{ $learn->learn_type->learn_type_name }}</td>
                        <td>{{ $learn->note }}</td>
                        <td>{{ $learn->learn_at }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">ไม่มีข้อมูลการเรียน</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
