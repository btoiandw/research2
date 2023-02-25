<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TbRoleUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        //dd($request->all());
        if ($username == "" || $password == "") {
            return view('auth.login')->with('errorLogin');
        } else {
            $user = DB::table('users')->where('username', $username)->count();
            $admin = DB::table('tb_admins')->where('username', $username)->count();
            $director = DB::table('tb_directors')->where('username', $username)->count();

            $getuser = DB::table('users')->where('username', $username)->first();
            $getadmin = DB::table('tb_admins')->where('username', $username)->first();
            $getdirector = DB::table('tb_directors')->where('username', $username)->first();
            //dd($admin,$user,$director);
            if ($user != 0 && $admin != 0 && $director == 0) {
                $id = $getadmin->employee_id;
                $c_roles = DB::table('tb_role_users')->where('user_id', $id)->where('role_id', '1')->count();
                if ($c_roles == 0) {
                    $role = new TbRoleUser();
                    $role->user_id = $id;
                    $role->role_id = '1';
                    $role->save();
                }
                return redirect()->route('admin.dashboard');
            } elseif ($user != 0 && $admin == 0 && $director != 0) {
                $idu = $getuser->employee_id;
                $c_rolesu = DB::table('tb_role_users')->where('user_id', $idu)->where('role_id', '1')->count();
                if ($c_rolesu == 0) {
                    $roleu = new TbRoleUser();
                    $roleu->user_id = $idu;
                    $roleu->role_id = '2';
                    $roleu->save();
                }
                $id = $getdirector->employee_referees_id;
                $c_roles = DB::table('tb_role_users')->where('user_id', $id)->where('role_id', '3')->count();
                if ($c_roles == 0) {
                    $role = new TbRoleUser();
                    $role->user_id = $id;
                    $role->role_id = '3';
                    $role->save();
                }
                return redirect()->route('users.dashboard');
            } elseif ($user == 0 && $admin == 0 && $director != 0) {
                $id = $getdirector->employee_referees_id;
                $c_roles = DB::table('tb_role_users')->where('user_id', $id)->where('role_id', '3')->count();
                if ($c_roles == 0) {
                    $role = new TbRoleUser();
                    $role->user_id = $id;
                    $role->role_id = '3';
                    $role->save();
                }
                return redirect()->route('director.dashboard');
            } elseif ($user != 0 && $admin == 0 && $director == 0) {
                $id = $getuser->employee_id;
                $c_roles = DB::table('tb_role_users')->where('user_id', $id)->where('role_id', '1')->count();
                if ($c_roles == 0) {
                    $role = new TbRoleUser();
                    $role->user_id = $id;
                    $role->role_id = '2';
                    $role->save();
                }
                return redirect()->route('users.dashboard');
            } else {
                return view('auth.login')->with('errorLogin');
            }
        }
    }
    public function logout()
    {

        Auth::logout();
        return redirect('/');
    }
}
