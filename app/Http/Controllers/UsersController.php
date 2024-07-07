<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\user_status;
use App\Models\learn_type;
use App\Models\learn;
use App\Models\Coursee;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ทั้งหมดพร้อมกับสถานะของผู้ใช้
        $users = Users::with('user_status')->get();

        return view('index', compact('users'));
    }

    public function create()
    {
        $learntype = learn_type::all();

        return view('addstudent', compact('learntype'));
    }

    public function edit(string $id)
    {
        $show = Users::with(['learn.learn_type'])->findOrFail($id);
        $learntype = learn_type::all();

        // ตรวจสอบว่าพบข้อมูลหรือไม่
        if (!$show) {
            abort(404, 'student not found');
        }
        
        // จัดรูปแบบวันเกิดให้อยู่ในรูปแบบที่ต้องการ
        $show->birthday = \Carbon\Carbon::parse($show->birthday)->format('d-m-Y');

        return view('editstudent', compact('show', 'learntype'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nick_name' => 'required|string|max:255',
            'school' => 'nullable|string|max:255',
            'gender' => 'required|in:1,2',
            'birthday' => 'required|string|max:255',
            'Agee' => 'required|integer|min:1',
            'parent_name' => 'nullable|string|max:255',
            'parent_relationship' => 'nullable|string|max:255',
            'mobile_phone' => 'nullable|string|max:15',
            'id_line' => 'nullable|string|max:255',
            'learn_type_learn_type_id' => 'required|integer',
            'password' => 'nullable|string|min:8',
            'date_pay' => 'required|string|max:255',
            'learn_amount' => 'required|integer|min:1',
        ]);


        try {
            // Generate a unique 6-digit user_id based on timestamp
            $user_id = $this->generateUniqueUserId();

            // // Create user data
            $userData = [
                'user_id' => $user_id,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'nick_name' => $request->input('nick_name'),
                'school' => $request->input('school'),
                'gender' => $request->input('gender'),
                'birthday' => $request->input('birthday'),
                'Agee' => $request->input('Agee'),
                'parent_name' => $request->input('parent_name'),
                'parent_relationship' => $request->input('parent_relationship'),
                'mobile_phone' => $request->input('mobile_phone'),
                'id_line' => $request->input('id_line'),
                'learn_type_learn_type_id' => $request->input('learn_type_learn_type_id'),
                'regis_at' => now(),
            ];

            // Create course data
            $courseData = [
                'course_id' => $this->generateUniqueCourseId(),
                'date_pay' => $request->input('date_pay'),
                'learn_amount' => $request->input('learn_amount'),
                'course_user_id' => $user_id,
                'learntype_id' => $request->input('learn_type_learn_type_id'),
                'insert_at' => now(),
            ];

            // Save user and course data
            Users::create($userData);
            Coursee::create($courseData);

            // Notification message
            $message = "เพิ่มนักเรียนเรียบร้อย\n" .
                "รหัสนักเรียน: $user_id\n" .
                "ชื่อจริง: {$userData['first_name']}\n" .
                "นามสกุล: {$userData['last_name']}\n" .
                "ชื่อเล่น: {$userData['nick_name']}\n" .
                "โรงเรียน: {$userData['school']}\n" .
                "เพศ: " . ($userData['gender'] == 1 ? 'ชาย' : 'หญิง') . "\n" .
                "วันเกิด: {$userData['birthday']}\n" .
                "อายุ: {$userData['Agee']}\n" .
                "ชื่อผู้ปกครอง: {$userData['parent_name']}\n" .
                "ความสัมพันธ์กับผู้ปกครอง: {$userData['parent_relationship']}\n" .
                "เบอร์ติดต่อ: {$userData['mobile_phone']}\n" .
                "ไอดีไลน์: {$userData['id_line']}\n" .
                "ลงทะเบียนเมื่อ: {$userData['regis_at']}";

            // Send notification
            $this->sendLineNotification($message);

            return redirect()->route('addstudent')->with('success', "เพิ่มนักเรียนเรียบร้อยแล้ว รหัสนักเรียน: $user_id");
        } catch (\Exception $e) {
            Log::error('Error:', ['exception' => $e]);
            return redirect()->route('addstudent')->with('error', 'เกิดข้อผิดพลาดในการเพิ่มนักเรียน');
        }
    }


    private function generateUniqueUserId()
    {
        // Generate a 6-digit random number
        $random_number = mt_rand(100000, 999999);

        // Check if this random number exists in database, regenerate if it does
        while (Users::where('user_id', $random_number)->exists()) {
            $random_number = mt_rand(100000, 999999);
        }

        return $random_number;
    }

    private function generateUniqueCourseId()
    {
        // Generate a 7-digit random number
        $random_course_id = mt_rand(1000000, 9999999);

        // Check if this random number exists in database, regenerate if it does
        while (Coursee::where('course_id', $random_course_id)->exists()) {
            $random_course_id = mt_rand(1000000, 9999999);
        }

        return $random_course_id;
    }



    private function sendLineNotification($message)
    {
        $token = env('LINE_NOTIFY_TOKEN');

        Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->asForm()->post('https://notify-api.line.me/api/notify', [
            'message' => $message,
        ]);
    }
    
    public function destroy(string $id)
    {
        try {
            // ลบข้อมูลในตาราง learn ก่อน
            Learn::where('user_learn_id', $id)->delete();

            $user = Users::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'นักเรียนถูกลบเรียบร้อยแล้ว.'], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'ไม่พบนักเรียนที่ต้องการลบ.'], 404);

        } catch (\Exception $e) {

            return response()->json(['message' => 'เกิดข้อผิดพลาดในการลบนักเรียน.'], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nick_name' => 'required|string|max:255',
            'school' => 'nullable|string|max:255',
            'gender' => 'required|in:1,2',
            'birthday' => 'required|date_format:d-m-Y',
            'Agee' => 'required|integer|min:1',
            'parent_name' => 'nullable|string|max:255',
            'parent_relationship' => 'nullable|string|max:255',
            'mobile_phone' => 'nullable|string|max:15',
            'id_line' => 'nullable|string|max:255',
            'learn_type_learn_type_id' => 'required|integer',
        ]);

        $data = $request->all();
        $data['birthday'] = \Carbon\Carbon::createFromFormat('d-m-Y', $request->birthday)->format('Y-m-d');
        $data['update_at'] = now();

        try {
            $user = Users::findOrFail($id);
            $user->update($data);

            return redirect()->route('studentmange', $id)->with('success', 'อัปเดตข้อมูลนักเรียนเรียบร้อยแล้ว');
            
        } catch (ModelNotFoundException $e) {

            abort(404, 'student not found');

        } catch (\Exception $e) {

            return redirect()->route('studentmange', $id)->with('error', 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล');
        }
    }
}
