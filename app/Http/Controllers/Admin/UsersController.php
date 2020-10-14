<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ActivationKeyTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Group;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderComplaint;
use Session;

class UsersController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:admin');
     
    }

    /**
     * Show all recoreds in table a new resource.
     *
     * @return \Illuminate\Http\Response
    */  
    public function index()
    {
    	$users = User::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.users.index',["users" => $users]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */     
     public function add()
    {
    	$group_list = Group::where('status','=', 1)->get();
        return view('admin.users.add',["group_list" => $group_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$this->validate($request, [
            'first_name'            => 'required',
            'last_name'            => 'required',
            'phone'            => 'required|unique:users',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
        ],[
                'first_name.required'   => 'First Name is required',
                'last_name.required'    => 'Last Name is required',
                'phone.required'    => 'Phone No. is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
            ]);

        $user = new User;

        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->username = $request->first_name.$request->last_name;

        $user->email = trim($request->email);
        $user->password = bcrypt($request->password);
        $user->phone = trim($request->phone);
        $user->group_id = trim($request->group_id);
        $user->activated = ($request->activated == 'on')?1:0;      
                
		if($user->save()){
        	Session::flash('success','User Save successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
		//$this->queueActivationKeyNotification($user);
        return \Redirect::to('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	//die($id);
        $users = User::find($id);
       	$group_list = Group::where('status','=', 1)->get();
        return view('admin.users.edit',["group_list" => $group_list,"users" =>$users]);
        
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    	$this->validate($request, [
            'first_name'            => 'required',
            'last_name'            => 'required',
            'phone'            => 'required|unique:users,phone,'.$id,
            'email'                 => 'required|email|unique:users,email,'.$id,
            'confirm_password' => 'same:password',
        ],[
                'first_name.required'   => 'First Name is required',
                'last_name.required'    => 'Last Name is required',
                'phone.required'    => 'Phone No. is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
               
            ]);
        $user = User::find($id);
		
        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->username = $request->first_name.$request->last_name;

        $user->email = trim($request->email);
        $user->phone = trim($request->phone);
        $user->group_id = trim($request->group_id);
        $user->activated = ($request->activated == 'on')?1:0; 

        if(!empty($request->password)) {
    die('asdfasdfds');            
            $user->password = bcrypt($request->password);
        }

        if($user->save()){
        	Session::flash('success','User Update successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
		
        return \Redirect::to('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	//die('sdfdsf');
		$user = User::find($id);    
		
		if($user->delete()){
        	Session::flash('success','User Delete successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/users');
    }
	
	
	/**
     * view user information
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
		if(!empty($id)){
			
			$userDetail = User::find($id);
			
		   $recentOrders = Order::with('user')->where('user_id','=', $id)->orderBy('id','desc')->limit(10)->get();
		   
		   $orders = Order::with('order_items')->where('user_id','=', $id)->orderBy('id','desc')->get();
		
		
			
			$userOrderNumbers = Order::select('order_number')->where('user_id','=',$id)->distinct('order_number')->get();;
			
			
			//$activeComplaints = OrderComplaint::where('status','=',0)->where('user_id','=', $id)->get();
			$activeComplaints = OrderComplaint::select('order_number')->where('status','=',0)->where('user_type','=','customer')->distinct('order_number')->orderBy('created_at','desc')->get();
			
			$activeComplaintArr = array();
			if(!empty($activeComplaints)){
				$i = 0;
				foreach($activeComplaints as $active_complaint){
					
					$complaints = OrderComplaint::where('status','=',0)->where('order_number','=',$active_complaint['order_number'])->get();
					
					if(!empty($complaints)){
						$n = 1;
						foreach($complaints as $complaint){
							$activeComplaintArr[$complaint->order_number][$n]['user_id'] = $complaint->user_id;
							$activeComplaintArr[$complaint->order_number][$n]['order_number'] = $complaint->order_number;
							$activeComplaintArr[$complaint->order_number][$n]['subject'] = $complaint->subject;
							$activeComplaintArr[$complaint->order_number][$n]['problem'] = $complaint->problem;
							$activeComplaintArr[$complaint->order_number][$n]['user_type'] = $complaint->user_type;
							$activeComplaintArr[$complaint->order_number][$n]['created_at'] = date('d M,Y  H:i A', strtotime($complaint->created_at));
						
						$n++;
						}
					}
					
				$i++;
				}
			}
			
			//echo '<pre>activeComplaintArr'; print_R($activeComplaintArr); die;
			
			$resolvedComplaints = OrderComplaint::select('order_number')->where('status','=',1)->where('user_type','=','customer')->distinct('order_number')->orderBy('created_at','desc')->get();
			
			$resolvedComplaintArr = array();
			if(!empty($resolvedComplaints)){
				$i = 0;
				foreach($resolvedComplaints as $resolved_complaint){
					
					$complaints = OrderComplaint::where('status','=',1)->where('order_number','=',$resolved_complaint['order_number'])->get();
					
					if(!empty($complaints)){
						$n = 1;
						foreach($complaints as $complaint){
							$resolvedComplaintArr[$complaint->order_number][$n]['user_id'] = $complaint->user_id;
							$resolvedComplaintArr[$complaint->order_number][$n]['order_number'] = $complaint->order_number;
							$resolvedComplaintArr[$complaint->order_number][$n]['subject'] = $complaint->subject;
							$resolvedComplaintArr[$complaint->order_number][$n]['problem'] = $complaint->problem;
							$resolvedComplaintArr[$complaint->order_number][$n]['user_type'] = $complaint->user_type;
							$resolvedComplaintArr[$complaint->order_number][$n]['created_at'] = date('d M,Y H:i A', strtotime($complaint->created_at));
						
						$n++;
						}
					}
					
				$i++;
				}
			}
			//echo '<pre>resolvedComplaintArr'; print_R($resolvedComplaintArr); die;
		}
		
	return view('admin.users.view_profile',['userDetail'=>$userDetail,'recentOrders'=>$recentOrders,'orders'=>$orders,'userOrderNumbers'=>$userOrderNumbers,'activeComplaintArr'=>$activeComplaintArr,'resolvedComplaintArr'=>$resolvedComplaintArr]);	
	}
	
	
	
	public function save_complaint(){
		
		
		if(isset($_POST['submitComplaint'])){
			
			if(isset($_POST['order_number']) && !empty($_POST['order_number'])){
				
				$order_complaint = new OrderComplaint;
				$order_complaint->order_number = isset($_POST['order_number']) ? $_POST['order_number'] : 0;
				$order_complaint->subject =  isset($_POST['subject']) ? $_POST['subject'] : "";
				$order_complaint->problem =  isset($_POST['problem']) ? $_POST['problem'] : "";
				$order_complaint->status =  0;
				$order_complaint->user_type =  'admin';
				$order_complaint->user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
				
				 if($order_complaint->save()){
					//Session::flash('success','Service Request send successfully');
				}else{
					//Session::flash('error','Please try again.');
				}

			}
			
			return \Redirect::to('admin/users/view/'.$order_complaint->user_id);
			
		}
	}
	
}
