<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Carbon\Carbon;
use PDF;

class PdfController extends Controller
{
    public function generateStudentPdf($id)
    {
        // ดึงข้อมูลนักเรียนจากฐานข้อมูล
        $show = Users::with(['user_type', 'learn', 'learn.user_teach', 'learn.learn_type'])->find($id);

        if (!$show) {
            abort(404, 'Student not found');
        }

        // ตั้งค่า Carbon ให้แสดงผลวันที่เป็นภาษาไทย
        Carbon::setLocale('th');
        $updateAt = Carbon::parse($show->update_at);
        $now = Carbon::now();
        $diffForHumans = $updateAt->diffForHumans($now, [
            'parts' => 3,
            'join' => true,
            'short' => true,
        ]);

        // ส่งข้อมูลไปยัง Blade Template
        $data = compact('show', 'diffForHumans');
        $pdf = PDF::loadView('student', $data);

        // ตั้งค่าฟอนต์สำหรับ PDF
        $pdf->getDomPDF()->getOptions()->set('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isFontSubsettingEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);

        // ดาวน์โหลด PDF
        return $pdf->download('studentdetail.pdf');
    }
}
