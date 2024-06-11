<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Carbon\Carbon;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function generateStudentPdf($id)
    {
        // ดึงข้อมูลนักเรียนจากฐานข้อมูล
        $student = Users::with(['user_type', 'learn', 'learn.user_teach', 'learn.learn_type'])->find($id);

        if (!$student) {
            abort(404, 'Student not found');
        }

        // ตั้งค่า Carbon ให้แสดงผลวันที่เป็นภาษาไทย
        Carbon::setLocale('th');
        $updateAt = Carbon::parse($student->update_at);
        $now = Carbon::now();
        $diffForHumans = $updateAt->diffForHumans($now, [
            'parts' => 3,
            'join' => true,
            'short' => true,
        ]);

        // ส่งข้อมูลไปยัง Blade Template
        $html = view('student', compact('student', 'diffForHumans'))->render();

        // สร้าง PDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('student.pdf', 'D'); // 'D' สำหรับดาวน์โหลด PDF

        // หรือบันทึกไฟล์บนเซิร์ฟเวอร์
        // $mpdf->Output(storage_path('app/public/student.pdf'), 'F');
    }
}
