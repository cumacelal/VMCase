<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Auth;
class LoginController extends Controller
{
    //
    public function index(Request $request)
    {
        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'E-posta ya da şifre yanlıştır.'), 401);
        }
        else
        {
            Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            $user  = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            $user->token = $token;
             
            return response()->json(array('data' => $user, 'status' => true, 'messages' => 'Oturum Başarılıdır.'), 200);
        }
    }
}
