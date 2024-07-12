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

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ทั้งหมดพร้อมกับสถานะของผู้ใช้
        $users = Users::with('user_status')->get();
        $learntype = learn_type::all();

        return view('addcourse', compact('users', 'learntype'));
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
            'course_user_id' => 'required|integer',
            'learntype_id' => 'required|integer',
            'date_pay' => 'string|max:255',
            'learn_amount' => 'required|integer|min:1',
        ]);

        try {
            // ดึงข้อมูลคอร์สของผู้ใช้ทั้งหมด
            $userCourses = Coursee::where('course_user_id', $request->input('course_user_id'))->get();

            // ตรวจสอบคอร์สที่มีจำนวนการเรียน (learn) ไม่ครบตาม learn_amount
            foreach ($userCourses as $userCourse) {
                if ($userCourse->learn->count() < $userCourse->learn_amount) {
                    return redirect()->route('addcourse')->with('error', 'ยังมีคอร์สที่จำนวนการเรียนไม่ครบ');
                }
            }

            $course_id = $this->generateUniqueCourseId();

            // Create course data
            $courseData = [
                'course_id' => $course_id,
                'date_pay' => $request->input('date_pay'),
                'learn_amount' => $request->input('learn_amount'),
                'course_user_id' => $request->input('course_user_id'),
                'learntype_id' => $request->input('learntype_id'),
                'insert_at' => now(),
            ];

            $course = Coursee::create($courseData);

            if (!$course) {
                throw new \Exception('Failed to create course');
            }

            return redirect()->route('addcourse')->with('success', "ต่อคอร์สให้นักเรียนเรียบร้อย ไอดีคอร์ส: $course_id");

        } catch (\Exception $e) {
            Log::error('Error:', ['exception' => $e]);
            return redirect()->route('addcourse')->with('error', 'เกิดข้อผิดพลาดในการเพิ่มนักเรียน');
        }
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
    public function edit($id)
    {
        $course = Coursee::findOrFail($id);
        $learntype = learn_type::all();
        $users = Users::all();

        return view('editcourse', compact('course', 'learntype','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'learntype_id' => 'required|integer',
            'date_pay' => 'required|string|max:255',
            'learn_amount' => 'required|integer|min:1',
        ]);

        try {
            $course = Coursee::findOrFail($id);
            $course->learntype_id = $request->input('learntype_id');
            $course->date_pay = $request->input('date_pay');
            $course->learn_amount = $request->input('learn_amount');
            $course->save();

            return redirect()->route('studentshow',$course->user_course->user_id)->with('success', 'อัพเดทข้อมูลคอร์สเรียบร้อย');
        } catch (\Exception $e) {
            
            return redirect()->route('studentshow',$course->user_course->user_id)->with('error', 'เกิดข้อผิดพลาดในการอัพเดทคอร์ส');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Learn::where('learn_course_id', $id)->delete();

            $course = Coursee::findOrFail($id);
            $course->delete();

            return response()->json(['message' => 'คอร์สเรียนถูกลบเรียบร้อยแล้ว.'], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'ไม่พบคอร์สเรียนที่ต้องการลบ.'], 404);

        } catch (\Exception $e) {

            return response()->json(['message' => 'เกิดข้อผิดพลาดในการลบคอร์สเรียน.'], 500);
        }
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

}
