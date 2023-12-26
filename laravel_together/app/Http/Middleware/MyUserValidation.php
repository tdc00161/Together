<?php
//          파일생성 명령어
//          php artisan make:middleware 미들웨어명 


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MyUserValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::debug(" ***********유효성 체크 시작********** ");

        // 항목 리스트
        $arrBaseKey = [
            'email',
            'name',
            'password',
            'passwordchk'
        ];
        // 유효성 체크 리스트
        $arrBaseValidation = [
            'email' => 'required|email|max:25', // 필수입력 | 이메일형식 | 최대:50
            'name' => 'required|regex:/^[a-zA-z가-힣]+$/|min:2|max:50', // 필수입력 | 정규식 |
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/', // passwordchk 랑 같은지 체크
            'passwordchk' => 'same:password'
            // 'tel' => 'regex:/^010[0-9]{4}[0-9]{4}$'
        ];

        // request 파라미터
        $arrRequestParam = [];
        Log::debug("foreach 시작");
        // 루프 돌려 있는값 체크 해서 배열에 담음 (체이닝메소드 ->has : 해당 값 체크  )
        foreach($arrBaseKey as $val) {
            Log::debug("항목 : ".$val);
            if($request->has($val)) {
                $arrRequestParam[$val] = $request->$val;
            }else {
                unset($arrBaseValidation[$val]);
            }
        }
        Log::debug("리퀘스트 파라미터 획득", $arrRequestParam);
        Log::debug("유효성 체크 리스트 시작",$arrBaseValidation);

        // 유효성 (validation) 검사
        $validator = Validator::make($arrRequestParam, $arrBaseValidation, [
            'email.required' => '이메일은 필수 입력 항목입니다.',
            'email.email' => '이메일 형식이 올바르지 않습니다.',
            'password.required' => '비밀번호는 필수 입력 항목입니다.',
            'password.min' => '비밀번호는 최소 8자 이상 입력해야 합니다.',
            'password.regex' => '비밀번호는 소문자, 대문자, 숫자, 특수문자 모두 최소한 하나 이상 포함해야 합니다.',
            'passwordchk.same' => '비밀번호가 동일하지 않습니다.',
            'name.required' => '이름은 필수 입력 항목입니다.',
            'name.regex' => '이름에는 영문자나 한글만 사용할 수 있습니다.',
        ]);

        Log::debug(" ***********유효성 검사 시작********** ");


        Log::debug(" ***********유효성 검사실패시 처리********** ");
       // 유효성 (validation) 검사 실패 시 처리
      if ($validator->fails()) {

        // if ($request->ajax()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        return back()->withErrors($validator)->withInput();
    }
        Log::debug(" ***********유효성 체크 종료********** ");
        return $next($request);
}
}   
