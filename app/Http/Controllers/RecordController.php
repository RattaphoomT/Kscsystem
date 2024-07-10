<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\user_status;
use App\Models\learn;
use App\Models\Coursee;
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
            'teach_at' => 'required|string|max:100',
            'learn_at' => 'required|string|max:100',
            'note' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        try {
            // ค้นหาข้อมูลในตาราง Coursee ที่ตรงกับ user_learn_id และเรียงลำดับตาม insert_at
            $coursees = Coursee::where('course_user_id', $data['user_learn_id'])
                        ->orderBy('insert_at')
                        ->get();

            foreach ($coursees as $coursee) {
                // นับจำนวนข้อมูลในตาราง learn ที่ตรงกับ course_id นี้
                $learnCount = Learn::where('learn_course_id', $coursee->course_id)->count();

                
                // ถ้าจำนวนการเรียนยังไม่ครบตามที่กำหนด
                if ($learnCount < $coursee->learn_amount) {
                    // บันทึกข้อมูลการเรียนใหม่ในตาราง learn
                    $learnData = [
                        'learn_course_id' => $coursee->course_id,
                        'user_learn_id' => $data['user_learn_id'],
                        'user_teach_id' => $data['user_teach_id'],
                        'learn_type_id' => $data['learn_type_id'],
                        'teach_at' => $data['teach_at'],
                        'learn_at' => $data['learn_at'],
                        'note' => $data['note'],
                    ];

                    Learn::create($learnData);

                    // สร้างข้อความเพื่อส่งไปยังไลน์
                    $user_learn = Users::findOrFail($data['user_learn_id']);
                    $user_teach = Users::findOrFail($data['user_teach_id']);
                    $sumlearn = Learn::where('user_learn_id', $data['user_learn_id'])
                                ->where('learn_course_id', $coursee->course_id)
                                ->count();
                    $user = Auth::user();

                    if($sumlearn == $coursee->learn_amount){

                        $message = "บันทึกการสอนสำเร็จ\n" ."\n".
                                
                                "เรียนครั้งที่: " . $sumlearn . "/" . $coursee->learn_amount ."\n" .
                                "ชื่อเล่น: " . $user_learn->nick_name . "\n" .
                                "ชื่อจริง: " . $user_learn->first_name . "\n" .
                                "เวลาเรียน: " . $data['learn_at'] . "\n" .
                                "หมายเหตุ: " . $data['note'] . "\n" ."\n".

                                "ผู้สอน: " . $user_teach->nick_name . "\n".
                                "สอนเมื่อ: " . $data['teach_at'] . "\n" . "\n".

                                "บันทึกโดย: " . $user->nick_name;

                        // ส่งการแจ้งเตือนไปยังไลน์
                        $this->sendLineNotification($message);

                        return redirect()->route('addrecord')->with('success', "ยินดีด้วยครั้งนี้เรียนครบเเล้ว $sumlearn/$coursee->learn_amount ");

                    }else{
                        $message = "บันทึกการสอนสำเร็จ\n" ."\n".
                                
                                "เรียนครั้งที่: " . $sumlearn . "/" . $coursee->learn_amount ."\n" .
                                "ชื่อเล่น: " . $user_learn->nick_name . "\n" .
                                "ชื่อจริง: " . $user_learn->first_name . "\n" .
                                "เวลาเรียน: " . $data['learn_at'] . "\n" .
                                "หมายเหตุ: " . $data['note'] . "\n" ."\n".

                                "ผู้สอน: " . $user_teach->nick_name . "\n".
                                "สอนเมื่อ: " . $data['teach_at'] . "\n" . "\n".

                                "บันทึกโดย: " . $user->nick_name;

                        // ส่งการแจ้งเตือนไปยังไลน์
                        $this->sendLineNotification($message);

                        return redirect()->route('addrecord')->with('success', "บันทึกการเรียนสำเร็จ $sumlearn/$coursee->learn_amount ");
                    }

                }
            }

            // ถ้าไม่มี course_id ที่ยังไม่ครบ learn_amount
            return redirect()->route('addrecord')->with('error', 'ไม่พบคอร์สเรียนที่สามารถบันทึกข้อมูลได้');

        } catch (\Exception $e) {
            return redirect()->route('addrecord')->with('error', 'เกิดข้อผิดพลาดในการบันทึกการเรียน');
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
