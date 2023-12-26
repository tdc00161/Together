<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserController extends Controller
{
    public function loginget() {
        // Auth::login($user, $remember = true);
        // 로그인 한 유저는 보드 리스트로 이동
        if(Auth::check()) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    public function loginpost(Request $request) {

        $remember = true;

        // 유저 정보 습득
        $result = User::where('email', $request->email)->first();
        if(!$result || !(Hash::check($request->password, $result->password))) {
            $errorMsg= '이메일과 비밀번호 다시 확인해주세요.';
            return view('login')->withErrors($errorMsg);
        }

        // 유저 인증작업
        Auth::login($result, $remember);
        if(Auth::check()) {
            session(['user' => $result]);
        } else {
            $errorMsg = "인증 에러가 발생 했습니다.";
            return view('login')->withErrors($errorMsg);
        }
        return redirect('/dashboard')->cookie($cookie);
    }

   

    public function registrationget() {
        Log::debug('*** registrationget Start ***');
        if(Auth::check()) {
            return redirect('/dashboard');
        }
        if(isset($errors)) {
            Log::debug('errors : ', $errors->all());
        }
        Log::debug('*** registrationget End ***');
        return view('registration');
    }

    public function registrationpost(Request $request) {

        // ** 데이터 베이스에 저장할 데이터 획득 **
        // request 에 담긴 정보들 중 담고싶은 정보만 담아 출력 / 변수명->only(''); /
        $data = $request->only('email', 'password', 'name'); 

        // 비밀번호 암호화 (라라벨에서 제공해주는 비밀번호 암호화)
        $data['password'] = Hash::make($data['password']);

        // 회원 정보 DB에 저장
        $result = User::create($data);

        return redirect()->route('user.login.get');
    }

    public function logoutget() {
      
        $user = Auth::user();

        if($user) {
            $user->setRememberToKen(null);
            $user->save();
        }

        Session::flush(); // 세션파기
        Auth::logout(); // 로그아웃
        
        return redirect()->route('user.login.get');
    }
    
    // 사용자를 이메일로 조회하는 메소드
    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }
}
