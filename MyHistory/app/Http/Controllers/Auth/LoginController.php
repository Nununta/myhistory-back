<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // ★追加
use Illuminate\Http\JsonResponse; //追記
use Illuminate\Support\Facades\Auth; //追記
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

      //下記メソッド追加
      protected function authenticated(Request $request, $user)
      {
          return $user;
      }
  
      protected function loggedOut(Request $request)
      {
          //セッションを再生成する
          $request->session()->regenerate();
  
          return response()->json();
      }

    //追加
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (auth()->attempt($credentials)) {
            log::info('a');
            $request->session()->regenerate();
            return response()->json(Auth::user());
        }
        log::info('b');
        return response()->json(['message' => 'ユーザーが見つかりません。'], 422);
    }
}
