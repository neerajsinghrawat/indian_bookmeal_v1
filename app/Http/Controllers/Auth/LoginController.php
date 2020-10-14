<?php

namespace App\Http\Controllers\Auth;

/*session_start();
require 'vendor/Facebook/autoload.php';*/

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\Models\User;
use Session;

use Exception;
/*use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;*/
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
        $this->middleware('guest:web')->except('logout');
    }


/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */  
    public function showLoginForm(Request $request,$slug = null)
    {
   
      if (Session::has('login_slug')) {
        
        Session::forget('login_slug');
      }
      Session::put('login_slug', $slug);

      return view('auth.login');
    }


/**
 * login user.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required',
        'password' => 'required|min:6'
      ]);


         if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'activated' => 1])) {

          if (Session::has('login_slug')) {
            
              return redirect('/'.Session::get('login_slug'));
              
          }
            return redirect('/login');
         }else{
            Session::flash('error_h1','Login');
            Session::flash('error','Email in not valid');
            return redirect('/login');
         }        
    }


/**
 * Facebook login.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function facebook_login(){
        //die('sfdsdg');
       $facebook_api_id = '2191196177785320';
       $facebook_secret_id = 'a56282f5a6bb81d94f0ab7e7b67fe22b';
        
        if(!empty($facebook_api_id) && !empty($facebook_secret_id)){
        
            // init app with app id and secret
            FacebookSession::setDefaultApplication( $facebook_api_id,$facebook_secret_id );
            // login helper with redirect_uri
            $helper = new FacebookRedirectLoginHelper( url('/facebook-login') );
            //echo '<pre>';print_r($helper);die;
            try {
              $session = $helper->getSessionFromRedirect();

               // echo '<pre>';print_r($helper);die;
            } catch( FacebookRequestException $ex ) {
              //echo '<pre>';print_r($ex);die;
            } catch( Exception $ex ) {
              //die('ddd');// When validation fails or other local issues
            }

            // see if we have a session
            if ( isset( $session ) ) {
              // graph api request for user data
              $request = new FacebookRequest( $session, 'GET', '/me?fields=id,name,first_name,last_name,picture,email' );
              $response = $request->execute();
              // get response
              $graphObject = $response->getGraphObject();
             //echo '<pre>';print_r($response);die;
                $fb_id = $graphObject->getProperty('id');              // To Get Facebook ID
                $fb_fullname = $graphObject->getProperty('name'); // To Get Facebook full name
                $fb_email = $graphObject->getProperty('email');
                $fb_first_name = $graphObject->getProperty('first_name');
                $fb_last_name = $graphObject->getProperty('last_name');
                
                
                $user_list = User::where('oauth_uid','=',$fb_id)->first();
                if (!empty($user_list) && ($user_list->oauth_uid == $fb_id)) {
                    $user = User::find($user_list->id);
                }else{
                    $user = new User;
                }             

                $user->oauth_uid = $fb_id;
                $user->username = $fb_fullname;
                $user->first_name = $fb_first_name;
                $user->last_name = $fb_last_name;
                $user->email = $fb_email;
                $user->group_id = 1;
                
                $user->save();
 
                    return redirect('/register');
            
            } else {
              $loginUrl = $helper->getLoginUrl(array(
               'scope' => 'email'
             ));
              //echo '<pre>';print_r($loginUrl);die;
             return redirect($loginUrl);
            }
        }
        

    }


/**
  * Redirect the user to the Google authentication page.
  *
  * @return \Illuminate\Http\Response
  */
public function redirectToProvider()
{
    return Socialite::driver('google')->redirect();

}

/**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
       try {
            
        
            $googleUser = Socialite::driver('google')->user();
            
            $existUser = User::where('email','=',$googleUser->email)->first();
            //echo '<pre>';print_r($googleUser);die;

            if(!empty($existUser)) {
                //echo '<pre>';print_r($googleUser);die;
                Auth::loginUsingId($existUser->id);
            }else {
                $newuser = new User;
                $newuser->username = $googleUser->name;
                $newuser->email = $googleUser->email;
                $newuser->provider_id = $googleUser->id;
                $newuser->avatar_original = $googleUser->avatar_original;
                $newuser->provider = 'google';
                $newuser->group_id = 1;
                $newuser->save();
                Auth::loginUsingId($newuser->id);
            }
            return redirect()->to('/');
           // echo '<pre>';print_r($googleUser);die;
        } 
        catch (Exception $e) {
            //echo '<pre>';print_r($e);die;
            return 'error';
        }
    }

/**
  * Redirect the user to the Google authentication page.
  *
  * @return \Illuminate\Http\Response
  */
public function twitterRedirect()
{
    //die('sfknn');
    return Socialite::driver('twitter')->redirect();

}

/**
* Obtain the user information from Twitter.
*
* @return \Illuminate\Http\Response
*/

    public function TwitterCallback()
    {
        //die('sfaaaaknn');
        try {
        $twitterSocial =   Socialite::driver('twitter')->user();
        $existUser = User::where('email','=',$twitterSocial->getEmail())->first();

        //echo '<pre>';print_r($twitterSocial);die;
        if(!empty($existUser)){
                    Auth::login($existUser);
                    return redirect('/');
                }else{
        $user = User::firstOrCreate([
                        'username'      => $twitterSocial->getName(),
                        'email'         => $twitterSocial->getEmail(),
                        /*'image'         => $twitterSocial->getAvatar(),*/
                        'provider_id'   => $twitterSocial->getId(),
                        'provider'      => 'twitter',
                        'group_id'      => 1,
                    ]);
                Auth::login($user);
                    return redirect('/');
                }
        }
        catch (Exception $e) {
            //echo '<pre>';print_r($e);die;
            return 'error';
        }
      }

/**
  * Redirect the user to the Google authentication page.
  *
  * @return \Illuminate\Http\Response
  */
public function facebookRedirect()
{
    //die('sfknn');
    return Socialite::driver('facebook')->redirect();

}

/**
* Obtain the user information from Twitter.
*
* @return \Illuminate\Http\Response
*/

    public function facebookCallback()
    {
        //die('sfaaaaknn');
        try {
        $facebookSocial =   Socialite::driver('facebook')->user();
        $existUser = User::where('email','=',$facebookSocial->getEmail())->first();

        //echo '<pre>';print_r($facebookSocial);die;
        if(!empty($existUser)){
                    Auth::login($existUser);
                    return redirect('/');
                }else{
        $user = User::firstOrCreate([
                        'username'      => $facebookSocial->getName(),
                        'email'         => $facebookSocial->getEmail(),
                        /*'image'         => $twitterSocial->getAvatar(),*/
                        'provider_id'   => $facebookSocial->getId(),
                        'provider'      => 'facebook',
                        'group_id'      => 1,
                    ]);
        Auth::login($user);
                    return redirect('/');
                }
        }
        catch (Exception $e) {
            //echo '<pre>';print_r($e);die;
            return 'error';
        }
      }

 /*public function logout(Request $request)
    {
      //echo 'Hello';die;
       Auth::guard('web')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'login' ));
    }*/
}
