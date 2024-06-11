<!-- resources/views/student.blade.php -->
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">


    <title>ข้อมูลนักเรียน</title>
    <style>
        /* สไตล์ CSS สำหรับ PDF */
        body {
            font-family: "Noto Sans Thai", sans-serif;
           
        }

        /* เพิ่มสไตล์เพิ่มเติมตามต้องการ */
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-center">ข้อมูลนักเรียน #{{ $show->user_id }}</h3>
        <hr>
        <!-- เพิ่ม HTML สำหรับแสดงข้อมูลนักเรียน -->
        <div>
            <p>ชื่อเล่น: {{ $show->nick_name }}</p>
            <p>อายุ: {{ $show->Agee }} ปี</p>
            <p>โรงเรียน: {{ $show->school }}</p>
            <!-- เพิ่มข้อมูลเพิ่มเติมตามต้องการ -->
        </div>
        <!-- เพิ่มส่วนอื่น ๆ ของ PDF -->
    </div>
</body>

</html>
