<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\user_status;
use App\Models\learn;
use Illuminate\Support\Facades\Auth;
use App\Models\learn_type;
use Illuminate\Support\Facades\Http;



class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ทั้งหมดพร้อมกับสถานะของผู้ใช้
        $users = Users::with('user_status')->get();
        $learntype = learn_type::all();

        return view('record', compact('users', 'learntype'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_learn_id' => 'required|integer',
            'user_teach_id' => 'required|integer',
            'learn_type_id' => 'required|integer',
            'note' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['learn_at'] = now(); // ใส่ค่าเวลาให้กับ learn_at
        $data['teach_at'] = now(); // ใส่ค่าเวลาให้กับ teach_ats
        

        try {

            learn::create($data);

            // สร้างข้อความเพื่อส่งไปยังไลน์
            $user_learn = Users::findOrFail($data['user_learn_id']);
            $user_teach = Users::findOrFail($data['user_teach_id']);
            $sumlearn = learn::where('user_learn_id', $data['user_learn_id'])->count();
            $user = Auth::user();

            $message = "บันทึกการสอนสำเร็จ\n" ."\n".
                       
                       "เรียนครั้งที่: " . $sumlearn . "\n" .
                       "ชื่อเล่น: " . $user_learn->nick_name . "\n" .
                       "ชื่อจริง: " . $user_learn->first_name . "\n" .
                       "เวลาเรียน: " . $data['learn_at'] . "\n" .
                       "หมายเหตุ: " . $data['note'] . "\n" ."\n".

                       "ผู้สอน: " . $user_teach->nick_name . "\n".
                       "สอนเมื่อ: " . $data['teach_at'] . "\n" . "\n".

                       "บันทึกโดย: " . $user->nick_name;


            // ส่งการแจ้งเตือนไปยังไลน์
            $this->sendLineNotification($message);

            return redirect()->route('recordteacher')->with('success', 'บันทึกการเรียนสำเร็จ');

        } catch (\Exception $e) {
            return redirect()->route('recordteacher')->with('error', 'เกิดข้อผิดพลาดในการเพิ่มนักเรียน');
        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
