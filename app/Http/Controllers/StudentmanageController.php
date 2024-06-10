<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\user_status;
use App\Models\learn;
use Carbon\Carbon;

class StudentmanageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ทั้งหมดพร้อมกับสถานะของผู้ใช้
        $users = Users::with('user_status')->get();

        return view('studentmanage', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Users::with(['learn.learn_type'])->findOrFail($id);
        $show->update_at = Carbon::parse($show->update_at);

        // ตรวจสอบว่าพบข้อมูลหรือไม่
        if (!$show) {
            abort(404, 'student not found');
        }
        
        return view('showstudent', compact('show'));
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
}
