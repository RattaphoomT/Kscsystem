<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\user_status;
use App\Models\learn;
use App\Models\learn_type;


class ShowRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ทั้งหมดพร้อมกับสถานะของผู้ใช้
        $show = Learn::with(['user_learn', 'user_teach', 'learn_type'])->get();
       

        return view('showrecord', compact('show'));
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
        try {
            $learn = learn::findOrFail($id);
            $learn->delete();

            return response()->json(['message' => 'ประวัติการเรียนถูกลบเรียบร้อยแล้ว.'], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'ไม่พบประวัติการเรียนที่ต้องการลบ.'], 404);

        } catch (\Exception $e) {

            return response()->json(['message' => 'เกิดข้อผิดพลาดในการลบประวัติการเรียน.'], 500);
        }
    }
}
