<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class FranchiseLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:franchise',['except'=>'logout']);
    }
    public function showLoginForm()
    {
    //	die('sdfgdsfg');
      return view('auth.franchise-login');
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
      if (Auth::guard('franchise')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
        // if successful, then redirect to their intended location
        //return redirect()->intended(route('admin.dashboard'));
        return redirect()->guest(route( 'franchise.dashboard' ));
      }
      // if unsuccessful, then redirect back to the login with the form data
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
        Auth::guard('franchise')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'franchise.login' ));
    }
}
