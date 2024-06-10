<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\user_status;
use App\Models\learn_type;
use App\Models\learn;
use Illuminate\Support\Facades\Http;

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
        ]);

        // Generate a unique 6-digit user_id based on timestamp
        $user_id = $this->generateUniqueUserId();

        $data = $request->all();

        $data['user_id'] = $user_id;
        $data['regis_at'] = now(); // ใส่ค่าเวลาให้กับ regis_at

        

        try {
            Users::create($data);

            // สร้างข้อความเพื่อส่งไปยังไลน์
            $message = "เพิ่มนักเรียนเรียบร้อย\n" ."\n".
                       "รหัสนักเรียน: $user_id\n" .
                       "รหัสใช้เข้าสู่ระบบคือ: " . "12345678"."\n"."\n".
                       "ชื่อจริง: " . $data['first_name'] . "\n" .
                       "นามสกุล: " . $data['last_name'] . "\n" .
                       "ชื่อเล่น: " . $data['nick_name'] . "\n" .
                       "โรงเรียน: " . $data['school'] . "\n" .
                       "เพศ: " . ($data['gender'] == 1 ? 'ชาย' : 'หญิง') . "\n" .
                       "วันเกิด: " . $data['birthday'] . "\n" .
                       "อายุ: " . $data['Agee'] . "\n" ."\n".
                       "ชื่อผู้ปกครอง: " . $data['parent_name'] . "\n" .
                       "ความสัมพันธ์กับผู้ปกครอง: " . $data['parent_relationship'] . "\n" .
                       "เบอร์ติดต่อ: " . $data['mobile_phone'] . "\n" .
                       "ไอดีไลน์: " . $data['id_line'] . "\n"."\n". 
                       "ลงทะเบียนเมื่อ: " . $data['regis_at'];

            // ส่งการแจ้งเตือนไปยังไลน์
            $this->sendLineNotification($message);

            return redirect()->route('addstudent')->with('success', "เพิ่มนักเรียนเรียบร้อยแล้ว รหัสนักเรียน: $user_id");

        } catch (\Exception $e) {
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
