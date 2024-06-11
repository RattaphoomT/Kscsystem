<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\user_status;
use App\Models\learn_type;
use App\Models\learn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ทั้งหมดพร้อมกับสถานะของผู้ใช้
        $users = Users::with('user_status')->get();

        return view('teachermanage', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addteacher');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nick_name' => 'required|string|max:255',
            'gender' => 'required|in:1,2',
            'birthday' => 'required|string|max:255',
            'Agee' => 'required|integer|min:1',
            'bank_name' => 'nullable|string|max:255',
            'bank_number' => 'nullable|string|max:255',
            'mobile_phone' => 'nullable|string|min:10',
            'id_line' => 'nullable|string|max:255',
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
            $message = "เพิ่มครูเรียบร้อยแล้ว\n" ."\n".

                       "รหัสครู: $user_id\n" .
                       "รหัสใช้เข้าสู่ระบบคือ: " . "12345678"."\n"."\n".

                       "ชื่อครู: " . $data['nick_name'] . "\n" .
                       "เพศ: " . ($data['gender'] == 1 ? 'ชาย' : 'หญิง') . "\n" .
                       "วันเกิด: " . $data['birthday'] . "\n" .
                       
                       "อายุ: " . $data['Agee'] . "\n" ."\n".
                       "เบอร์ติดต่อ: " . $data['mobile_phone'] . "\n" .
                       "ไอดีไลน์: " . $data['id_line'] . "\n"."\n". 
                       "ลงทะเบียนเมื่อ: " . $data['regis_at'];

            // ส่งการแจ้งเตือนไปยังไลน์
            $this->sendLineNotification($message);

            return redirect()->route('addteacher')->with('success', "เพิ่มครูเรียบร้อยแล้ว รหัสคุณครูคือ: $user_id");

        } catch (\Exception $e) {
            return redirect()->route('addteacher')->with('error', 'เกิดข้อผิดพลาดในการครู');
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Users::with(['learn.learn_type'])->findOrFail($id);
        $show->update_at = Carbon::parse($show->update_at);

        // ดึงข้อมูลการสอนที่มี user_teach_id ตรงกับ id ของผู้ใช้
        $teachRecords = learn::where('user_teach_id', $id)->with(['learn_type', 'user_learn'])->get();

        // ตรวจสอบว่าพบข้อมูลหรือไม่
        if (!$show) {
            abort(404, 'ไม่พบข้อมูลคุณครู');
        }
        

        return view('showteacher', compact('show', 'teachRecords'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $show = Users::with(['learn.learn_type'])->findOrFail($id);

        // ตรวจสอบว่าพบข้อมูลหรือไม่
        if (!$show) {
            abort(404, 'ไม่พบข้อมูลครู');
        }
        
        // จัดรูปแบบวันเกิดให้อยู่ในรูปแบบที่ต้องการ
        $show->birthday = \Carbon\Carbon::parse($show->birthday)->format('d-m-Y');

        return view('editteacher', compact('show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nick_name' => 'required|string|max:255',
            'gender' => 'required|in:1,2',
            'birthday' => 'required|date_format:d-m-Y',
            'Agee' => 'required|integer|min:1',
            'bank_name' => 'nullable|string|max:255',
            'bank_number' => 'nullable|string|max:255',
            'mobile_phone' => 'nullable|string|min:10',
            'id_line' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['birthday'] = \Carbon\Carbon::createFromFormat('d-m-Y', $request->birthday)->format('Y-m-d');
        $data['update_at'] = now();

        try {
            $user = Users::findOrFail($id);
            $user->update($data);

            return redirect()->route('teachermanage', $id)->with('success', 'อัปเดตข้อมูลครูเรียบร้อยแล้ว');
            
        } catch (ModelNotFoundException $e) {

            abort(404, 'student not found');

        } catch (\Exception $e) {

            return redirect()->route('teachermanage', $id)->with('error', 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // ลบข้อมูลในตาราง learn ก่อน
            Learn::where('user_teach_id', $id)->delete();

            $user = Users::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'ครูถูกลบเรียบร้อยแล้ว.'], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'ไม่พบครูที่ต้องการลบ.'], 404);

        } catch (\Exception $e) {

            return response()->json(['message' => 'เกิดข้อผิดพลาดในการลบครู.'], 500);
        }
    }
}
