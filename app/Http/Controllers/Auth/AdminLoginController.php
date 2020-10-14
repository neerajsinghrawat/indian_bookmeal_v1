<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin',['except'=>'logout']);
    }
    public function showLoginForm()
    {
    //	die('sdfgdsfg');
      return view('auth.admin-login');
    }
    public function login(Request $request)
    {
     // die('sdfgdsfg');// Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);
     // die('sdfgdsfg');
      //echo $request;die;
      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // if successful, then redirect to their intended location
        Session::flash('success','Login successfully');
        //return redirect()->intended(route('admin.dashboard'));
        return redirect()->guest(route( 'admin.dashboard' ));


      }
      Session::flash('error','Email and Password not match !Please try again.');
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    /**
 * Log the user out of the application.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
 public function logout(Request $request)
    {
  //echo 'Hello';die;
        Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'admin.login' ));
    }
}
