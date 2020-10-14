<?php
namespace App\Http\Controllers\Auth;
 
use App\Models\User;
use App\Models\EmailTemplate;
 
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\ActivationKeyTrait;
 
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
 
    use RegistersUsers, ActivationKeyTrait;
 
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '';
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
 
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data,
            [
                //'username'               => 'required',
                'first_name'               => 'required',
                'last_name'               => 'required',
                'phone'            => 'required|unique:users',
                'email'                 => 'email|required|unique:users',
                'password'              => 'required|min:6|max:20',
                'password_confirmation' => 'required|same:password',
            ],
            [
                //'username.required'     => 'Name is required',
                'phone.required'     => 'Mobile no. is required',
              
                'first_name.required'   => 'First Name is required',
                'last_name.required'    => 'Last Name is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
            ]
        );

        return $validator;
    }
 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
       //echo '<pre>';print_r($data);die;
        $pass = substr(number_format(time() * rand(),0,'',''),0,6);
        $user =  User::create([
            'username' => $data['first_name'].$data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'otp' => $pass,
            'password' => bcrypt($data['password']),
            'address' => $data['address'],
            'postcode' => $data['postcode'],


            'group_id' => 1,
            //'activated' => 1,
           // 'status' => 1,
            'activated' => !config('app.send_activation_email')  // if we do not send the activation email, then set this flag to 1 right away
        ]);

        //$this->sendmsg($data['phone'],$pass);
        return $user;
    }
     
/*    private function sendmsg($phone,$msg){
              $ch = curl_init();
                $msg = urlencode('OTP: '.$msg.' ');
             curl_setopt($ch, CURLOPT_URL, 'http://www.dakshinfosoft.com/api/sendhttp.php?authkey=3134AXq8JgNa57bc3d62&mobiles='.$phone.'&message='.$msg.'&sender=BHARAT&route=4&country=0');
              ob_start();
             // $buffer = curl_exec($ch);
              curl_exec($ch);
              ob_end_clean();
              curl_close($ch);
              unset($ch);
             // return $buffer;
    }*/

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
     
        // create the user
        $user = $this->create($request->all());

        $post_data = array();
        $post_data['username'] = $user->username;
        $post_data['first_name'] = $user->first_name;
        $post_data['last_name'] = $user->last_name;
        $post_data['email'] = $user->email;
        $post_data['phone'] = $user->phone;
        $post_data['password'] = $request->password;
        $post_data['address'] = $user->address;
        $post_data['postcode'] = $user->postcode;

        $emailTemplate = new EmailTemplate;
        $emailTemplate->sendAdminEmail($post_data,1);
        $emailTemplate->sendUserEmail($post_data,2);

        // process the activation email for the user
       // $daaa = $this->queueActivationKeyNotification($user);
        
        //echo '<pre>';print_r($daaa);die;
        // we do not want to login the new user
            Session::flash('success_h1','Register');
            Session::flash('success','Register successfully please check your email for account activation.');
        return redirect('/login')
            ->with('message', 'Register successfully please check your email for account activation')
            ->with('status', 'success');
    }
}
