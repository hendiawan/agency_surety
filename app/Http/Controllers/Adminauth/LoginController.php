<?php

namespace App\Http\Controllers\Adminauth;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function getLoginForm()
    {

        return view('admin.auth.login');
    }	
    
    public function authenticate(Request $request)
    {
        
        $username = $request->input('username');
        $password = $request->input('password');
         
        if (auth()->guard('admin')->attempt(['username' => $username, 'password' => $password ])) 
        {
            
            return redirect()->intended('admin/dashboard');
        }
        else
        {
            return redirect()->intended('admin/login')->with('status', 'Invalid Login Credentials !');
        }
    }
    
    
    public function getLogout() 
    {
        auth()->guard('admin')->logout();
        return redirect()->intended('admin/login');
    }
    
}
