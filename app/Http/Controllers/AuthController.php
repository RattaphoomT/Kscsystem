<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required',
        ]);

        $user = Users::where('user_id', $request->user_id)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            switch ($user->user_status_user_status_id) {
                case 1:
                    return redirect()->route('adminindex')->with('success', 'เข้าสู่ระบบสำเร็จ ยินดีต้อนรับ '. $user->nick_name );
                case 2:
                    return redirect()->route('student.dashboard')->with('success', 'เข้าสู่ระบบสำเร็จ ยินดีต้อนรับ '. $user->nick_name );
                case 3:
                    return redirect()->route('teacher.dashboard')->with('success', 'เข้าสู่ระบบสำเร็จ ยินดีต้อนรับ '. $user->nick_name );
                default:
                    return redirect()->route('showlogin')->with('error', 'เข้าสู่ระบบไม่สำเร็จ');
            }
        }

        return back()->withErrors(['mobile_phone' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'ออกจากระบบเรียนร้อย');
    }
}
