<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Country;
use App\Models\Postcode;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderComplaint;
use App\Models\UserAddress;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

class UsersController extends Controller
{

    
/**
 * Display the products by category.
 *
 * @param string $slug
 *
 * @return \Illuminate\Http\Response
 */

  
  public function index(Request $request ,$slug = null)
    {
		
		
       Session::put('selectedDashboardTab', 'overview');
	   
	   $userDetail = User::find(Auth::user()->id);
	   
	   $recentOrders = Order::with('user')->where('user_id','=', Auth::user()->id)->orderBy('id','desc')->limit(10)->get();
	   
	   $orders = Order::with('order_items')->where('user_id','=', Auth::user()->id)->orderBy('id','desc')->get();
	 
		
		//$activeComplaintOrderNumbers = OrderComplaint::select('order_number')->where('status','=',0)->where('user_id','=', Auth::user()->id)->distinct('order_number')->get();
		/*$activeComplaintsArr = array();
		if(!empty($activeComplaintOrderNumbers)){
			foreach($activeComplaintOrderNumbers as $active_complaint_order){
				echo '<pre>active_complaint_order'; print_R($active_complaint_order); die;
			}
		}*/
		
		$userOrderNumbers = Order::select('order_number')->where('user_id','=',Auth::user()->id)->distinct('order_number')->get();;
		
		
		$activeComplaints = OrderComplaint::where('status','=',0)->where('user_id','=', Auth::user()->id)->get();
		$activeComplaintArr = array();
		if(!empty($activeComplaints)){
			$i = 0;
			foreach($activeComplaints as $active_complaint){
				$activeComplaintArr[$active_complaint->order_number][$i]['user_id'] = $active_complaint->user_id;
				$activeComplaintArr[$active_complaint->order_number][$i]['order_number'] = $active_complaint->order_number;
				$activeComplaintArr[$active_complaint->order_number][$i]['subject'] = $active_complaint->subject;
				$activeComplaintArr[$active_complaint->order_number][$i]['problem'] = $active_complaint->problem;
				$activeComplaintArr[$active_complaint->order_number][$i]['user_type'] = $active_complaint->user_type;
				$activeComplaintArr[$active_complaint->order_number][$i]['created_at'] = date('d M,Y  H:i A', strtotime($active_complaint->created_at));
			$i++;
			}
		}
		
		$resolvedComplaints = OrderComplaint::where('status','=',1)->where('user_id','=', Auth::user()->id)->get();
		$resolvedComplaintArr = array();
		if(!empty($resolvedComplaints)){
			$i = 0;
			foreach($resolvedComplaints as $resolved_complaint){
				$resolvedComplaintArr[$resolved_complaint->order_number][$i]['user_id'] = $resolved_complaint->user_id;
				$resolvedComplaintArr[$resolved_complaint->order_number][$i]['order_number'] = $resolved_complaint->order_number;
				$resolvedComplaintArr[$resolved_complaint->order_number][$i]['subject'] = $resolved_complaint->subject;
				$resolvedComplaintArr[$resolved_complaint->order_number][$i]['problem'] = $resolved_complaint->problem;
				$resolvedComplaintArr[$resolved_complaint->order_number][$i]['user_type'] = $resolved_complaint->user_type;
				$resolvedComplaintArr[$resolved_complaint->order_number][$i]['created_at'] = date('d M,Y H:i A', strtotime($resolved_complaint->created_at));
			$i++;
			}
		}
		
		$countries= Country::get();
		//echo '<pre>activeComplaintArr'; print_r($activeComplaintArr); die;
		$user_id = Auth::user()->id;

		$addressesArr = array();
		$addresses = UserAddress::where('user_id','=',Auth::user()->id)->get();
		if(!empty($addresses)){
			$i = 0;
			foreach ($addresses as $key => $address) {
				if($address->type == "other"){
						$addressesArr[$address->type][$i] = $address;

						$i++;
				}else{
					$addressesArr[$address->type] = $address;
				}
				
			}	
		}
			
		

        return view('front.users.dashboard',['userDetail'=>$userDetail,'recentOrders'=>$recentOrders,'orders'=>$orders,'userOrderNumbers'=>$userOrderNumbers,'activeComplaintArr'=>$activeComplaintArr,'resolvedComplaintArr'=>$resolvedComplaintArr,'user_id'=>$user_id,'countries'=>$countries,'addressesArr' => $addressesArr]);
		
		
    }
	
	
	public function save_complaint(){
		
		if(isset($_POST['submitComplaint'])){
			
			$order_complaint = new OrderComplaint;
			$order_complaint->order_number = isset($_POST['order_number']) ? $_POST['order_number'] : "";
			$order_complaint->subject =  isset($_POST['subject']) ? $_POST['subject'] : "";
			$order_complaint->problem =  isset($_POST['problem']) ? $_POST['problem'] : "";
			$order_complaint->status =  0;
			$order_complaint->user_type =  'customer';
			$order_complaint->user_id = Auth::user()->id;
			
			 if($order_complaint->save()){
            Session::flash('success_h1','Complaint');  

                Session::flash('success','Service Request send successfully');
            }else{
            Session::flash('error_h1','Complaint');

                Session::flash('error','Please try again.');
            }

			return \Redirect::to('dashboard');
			
		}
			
	}
	
	
	public function saveResolvedOrderComplaints(){
		$result = 0;
		if(isset($_POST['requestType']) && $_POST['requestType'] == "submitResolvedRequest"){
			$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : ''; 
			$order_number = isset($_POST['order_number']) ? $_POST['order_number'] : '';
			
			OrderComplaint::where('order_number', $order_number)->update(array('status' => '1'));
			$result = 1;
		}
		
		echo $result; exit();
	}

	
	public function setDashboardTabSession(){
		$result = 1;
		$tab_name = "overview";
		if(isset($_POST['requestType']) && $_POST['requestType'] == "setDashboardTab"){
			$tab_name = isset($_POST['tab_name']) ? $_POST['tab_name'] : ''; 
		}
		Session::forget('selectedDashboardTab');
		
		Session::put('selectedDashboardTab', $tab_name);
		
		echo Session::get('selectedDashboardTab'); exit();
	}

/**
 * edit_profile the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
	public function edit_profile(Request $request, $id)
	{
		$this->validate($request, [
            'phone'=> 'required|unique:users,phone,'.$id,
            'email'=> 'required|email|unique:users,email,'.$id,
        ]);
		    $user = User::find($id);
		
            $user->first_name = trim($request->first_name);
            $user->last_name = trim($request->last_name);
            $user->username = trim($request->first_name).' '.trim($request->last_name);
            $user->email = trim($request->email);
            $user->phone = $request->phone;
            $user->dob = date('Y-m-d', strtotime($request->dob));
            $user->postcode = $request->postcode;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country_id = $request->country_id;                 
                   
        if (!empty($request->file('picture'))) {

            $image = $request->file('picture');
            $unq_id = uniqid(); 
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/user');
            $image->move($destinationPath, $name);
                //echo '<pre>';print_r($destinationPath.'==>'.$name);die; 
            $user->picture =  $name;

            $fullPath = public_path('image/user/'.$name);
                           
              $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

                if(!empty($fullPath)){

                    $source = \Tinify\fromFile($fullPath);
                    $source->toFile($fullPath);
                    Image::make($destinationPath.'/'.$name)->resize(100, 100)->save(public_path('/image/user/150x150/'.$name));
                }

        }

      		  if($user->save()){
            Session::flash('success_h1','User Profile');

                Session::flash('success','User Update successfully');
            }else{
            Session::flash('error_h1','User Profile');

                Session::flash('error','Please try again.');
            }
		
        return \Redirect::to('dashboard');

	}
/**
 * edit_profile the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
	public function user_address(Request $request, $id)
	{
		//echo '<pre>';print_r($_POST);die;

        $this->address_delete($id);

		foreach ($request->address as $key => $value) {
			if ($key != 'other') {

				$userAddress = new UserAddress;		
	            $userAddress->address = $value['address'];
	            $userAddress->postcode = $value['postcode'];
	            $userAddress->title = $value['title'];
	            $userAddress->type = $value['type'];
	            $userAddress->phone = $value['phone'];
	            $userAddress->user_id = $id;
	            $userAddress->save();
			}else{

				foreach ($value as $key => $add) {
					$userAddress = new UserAddress;		
		            $userAddress->address = $add['address'];
		            $userAddress->postcode = $add['postcode'];
		            $userAddress->title = $add['title'];
		            $userAddress->type = $add['type'];
		            $userAddress->phone = $add['phone'];
		            $userAddress->user_id = $id;
		            $userAddress->save();
				}
				
			}
		}

		
        return \Redirect::to('dashboard');

	}/**
 * edit_profile the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
	public function add_address_new(Request $request)
	{
		//echo '<pre>';print_r($request['address']);die;
	    $resultArr = array();
	    $resultArr['result'] = 0;
		if ($request->isMethod('post')) {
			

				$userAddress = new UserAddress;		
	            $userAddress->address = $request['address'];
	            $userAddress->postcode = $request['postcode'];
	            $userAddress->title = $request['title'];
	            $userAddress->type = $request['type'];
	            $userAddress->phone = $request['phone'];
	            $userAddress->user_id = Auth::user()->id;
	            $userAddress->save();

		    if(!empty($userAddress->id)){
	            $deliveryAddress =  UserAddress::where('user_id','=',Auth::user()->id)->where('id','=',$userAddress->id)->first();
	            if(!empty($deliveryAddress)){
	                 $resultArr['result'] = 1;
	                $resultArr['delivery_address_id'] = $deliveryAddress->id;
	                $resultArr['delivery_address'] = $deliveryAddress->address;
	                 $resultArr['delivery_title'] = $deliveryAddress->title;
	                $resultArr['delivery_postcode'] = $deliveryAddress->postcode;
	                $resultArr['delivery_phone'] = $deliveryAddress->phone;
	            }
	        }
			
		}

		
   		echo json_encode($resultArr); exit();
        

	}

 /**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function address_delete($id)
{
    $user_address = UserAddress::where('user_id','=',$id)->get();

    foreach ($user_address as $key => $userAddress) {

        $userAdd = UserAddress::find($userAddress->id);
        $userAdd->delete();
    }

}

/**
 * Remove the specified resource from storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function delete_ajax_address(Request $request)
    {
        $result = 0;   
        $userAddress = UserAddress::find($request->address_id);  
        
        if($userAddress->delete()){
            $result = 1;
        }

        return response()->json(['success'=> $result]);
    }
/**
 * change_password the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
	public function change_password(Request $request)
	{	
		$this->validate($request, [
            'old_password'=> 'required',
            'new_password'=> 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

		$current_password = Auth::User()->password;           
      if(Hash::check($request->old_password, $current_password)){

      		$user = User::find(Auth::user()->id);		
            $user->password = bcrypt($request->new_password);
            if($user->save()){
            	Session::flash('success_h1','Password');

                Session::flash('success','Change Password successfully');
            }else{

            	Session::flash('error_h1','Password');

                Session::flash('error','Please try again.');
            }
      }else{
      		Session::flash('error_h1','Password');
               Session::flash('error','Old password not match,Try again.');
            }
        
        return \Redirect::to('dashboard');
	}


/**
 * Show the form for forgot_password a new resource.
 *
 * @return \Illuminate\Http\Response
 */     
	public function forgot_password_view()
	{

	    return view('front.users.forgot_password_view');
	}

/**
 * forgot_password the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * 
 * @return \Illuminate\Http\Response
 */
	public function forgot_password(Request $request)
	{	
		$this->validate($request, [
            'email'=> 'email|required',
        ]);
		
		$email = User::where('email', $request->email)->first();
        
        $post_data = array();

		if (!empty($email)) {
			$password = uniqid();
			$user = User::find($email->id);		
            $user->password = bcrypt($password);

            if($user->save()){

		        $post_data['username'] = $email->username;
		        $post_data['first_name'] = $email->first_name;
		        $post_data['last_name'] = $email->last_name;
		        $post_data['email'] = $email->email;
		        $post_data['phone'] = $email->phone;
		        $post_data['password'] = $password;

		        $emailTemplate = new EmailTemplate;
		        $emailTemplate->sendUserEmail($post_data,3);
                Session::flash('success_h1','Password');
                Session::flash('success','Please check your email password send successfully');

            }else{
               Session::flash('error_h1','Password');
               Session::flash('error','Please try again.');

            }
		}else{
				Session::flash('error_h1','Password');
               Session::flash('error','Please enter valid email address,Try again.');
            }
        
        return \Redirect::to('/');
	}
}
