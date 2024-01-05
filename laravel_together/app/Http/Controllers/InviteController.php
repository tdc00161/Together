<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ProjectRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    
    // 프로젝트 초대링크
    public function sendInvite() {

        // 초대 토큰
        $token = Str::random(30);
        $time = now()->addMinute(2);

        $inviteLink = URL::signedRoute('invite', ['token' => $token, '$time' => $time]);
    
        // ProjectRequest::create(['inviteLink' => $inviteLink]);
    
        return view('inviteMg')
        ->with('inviteLink',$inviteLink);
        }
    
    public function invite(Request $request, $token) {

    $user = ProjectRequest::where('invitation_token',$token)->first();

    if (!$request->hasValidSignature()) {
        abort(403);
    }

    return view('user.login.get');

    }
}
