<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TbRoleUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

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
            $user = DB::table('users')->where('username', $username)->where('work_status', '1')->count();
            $admin = DB::table('tb_admins')->where('username', $username)->where('status_workadmin', '1')->count();
            $director = DB::table('tb_directors')->where('username', $username)->where('work_status', '1')->count();

            $getuser = DB::table('users')->where('username', $username)->where('work_status', '1')->first();
            $getadmin = DB::table('tb_admins')->where('username', $username)->where('status_workadmin', '1')->first();
            $getdirector = DB::table('tb_directors')->where('username', $username)->where('work_status', '1')->first();
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
                $data = DB::table('tb_admins')->join('users', 'tb_admins.employee_id', '=', 'users.employee_id')->where('tb_admins.employee_id', $id)->get();

                return response()->json([
                    'status' => 'success',
                    'data' => 'null',
                    'roled' => 'null',
                    'data' => $data,
                    'role' => 'admin'
                ]);
                //return redirect()->route('admin.dashboard')->with(['data' => $data]);
            } elseif ($user != 0 && $admin == 0 && $director != 0) {
                //ภายใน
                $idu = $getuser->employee_id;
                $c_rolesu = DB::table('tb_role_users')->where('user_id', $idu)->where('role_id', '2')->count();
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
                $data = DB::table('users')->where('employee_id', $idu)->get();
                $datad = DB::table('tb_directors')->where('employee_referees_id', $id)->get();

                return response()->json([
                    'status' => 'success',
                    'datad' => $datad,
                    'roled' => 'director',
                    'data' => $data,
                    'role' => 'users'
                ]);
            } elseif ($user == 0 && $admin == 0 && $director != 0) {
                //ภายนอก
                $id = $getdirector->employee_referees_id;
                $c_roles = DB::table('tb_role_users')->where('user_id', $id)->where('role_id', '3')->count();
                if ($c_roles == 0) {
                    $role = new TbRoleUser();
                    $role->user_id = $id;
                    $role->role_id = '3';
                    $role->save();
                }
                $data = DB::table('tb_directors')->where('employee_referees_id', $id)->get();

                return response()->json([
                    'status' => 'success',
                    'data' => 'null',
                    'roled' => 'null',
                    'data' => $data,
                    'role' => 'director'
                ]);
            } elseif ($user != 0 && $admin == 0 && $director == 0) {
                //user
                $id = $getuser->employee_id;
                $c_roles = DB::table('tb_role_users')->where('user_id', $id)->where('role_id', '1')->count();
                if ($c_roles == 0) {
                    $role = new TbRoleUser();
                    $role->user_id = $id;
                    $role->role_id = '2';
                    $role->save();
                }
                $data = DB::table('users')->where('employee_id', $id)->get();
                return response()->json([
                    'status' => 'success',
                    'data' => 'null',
                    'roled' => 'null',
                    'data' => $data,
                    'role' => 'users'
                ]);
            } else {
                return view('auth.login')->with('errorLogin');
            }
        }
    }
    public function logout()
    {
        // Session::flash();
        Auth::logout();
        return redirect('login');
    }
}
