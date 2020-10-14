<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Staff;
use App\Models\OrderDeliveryStatus;
use App\Models\AdminUser;
use Session;
class OrdersController extends Controller
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
		$orders = Order::with('order_items','user')->orderBy('id','desc')->paginate(20);
    	
		return view('admin.orders.index',["orders" => $orders]);
    }

	/**
     * displaying order detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  varchar  $order_number
     * @return \Illuminate\Http\Response
     */
	public function order_detail(Request $request ,$order_number = null){
		
		if(!empty($order_number)){
			
			$orderDetail = Order::with('order_items')->where('order_number','=',$order_number)->orderBy('id','desc')->first();
			
			$staffs = Staff::select('id','first_name','last_name')->where('status','=',1)->get();
			
			$orderDeliveryStatus = OrderDeliveryStatus::where('order_id','=',$orderDetail->id)->get();
			
			$orderDeliveryStatusArr = array();
			if(!empty($orderDeliveryStatus)){
				foreach($orderDeliveryStatus as $order_status){
					$orderDeliveryStatusArr[$order_status->order_status_type] = $order_status;
				}
			}
			
			$deliveryUserDetailArr = array();
			$orderDeliveryStatus = OrderDeliveryStatus::where('order_id','=',$orderDetail->id)->where('order_status_type','=', 'assign_staff')->first();
			if(!empty($orderDeliveryStatus)){
				if($orderDeliveryStatus->user_type == "staff"){
					$deliveryUserDetail = Staff::where('id','=',$orderDeliveryStatus->user_id)->first();
					
					if(!empty($deliveryUserDetail)){
						$deliveryUserDetailArr['name'] = $deliveryUserDetail['first_name'] .' '.$deliveryUserDetail['last_name'];
						$deliveryUserDetailArr['email'] = $deliveryUserDetail['email'];
						$deliveryUserDetailArr['phone'] = $deliveryUserDetail['phone'];
						$deliveryUserDetailArr['mobile'] = $deliveryUserDetail['mobile'];
						$deliveryUserDetailArr['image'] = $deliveryUserDetail['image'];
					}
				}else{
					
					$deliveryUserDetail = AdminUser::where('id','=',$orderDeliveryStatus->user_id)->first();
					if(!empty($deliveryUserDetail)){
						$deliveryUserDetailArr['name'] = $deliveryUserDetail['name'];
						$deliveryUserDetailArr['email'] = $deliveryUserDetail['email'];
					}
				}
			}
			
			return view('admin.orders.order_detail',['orderDetail'=>$orderDetail,'staffs'=>$staffs,'orderDeliveryStatusArr'=>$orderDeliveryStatusArr,'deliveryUserDetailArr'=>$deliveryUserDetailArr]);
		}
		
	}
	
	
	public function update_delivery_satff(){
		if(isset($_POST['staff_id']) && isset($_POST['order_number'])){
			
			$staff_id =	!empty($_POST['staff_id']) ? $_POST['staff_id'] : 0;
			$order_number =	!empty($_POST['order_number']) ? $_POST['order_number'] : '';
			$order_status =	!empty($_POST['order_status']) ? $_POST['order_status'] : '';
			
			$order_status_text = 'Food Pack and Assign';
			$order_status_type = 'assign_staff';
			$user_type = 'staff';
			
			if(!empty($order_status)){
				$orderStatusArr = explode('~',$order_status);
				$order_status_type = isset($orderStatusArr[0]) ? $orderStatusArr[0] : $order_status_type;
				$order_status_text = isset($orderStatusArr[1]) ? $orderStatusArr[1] : $order_status_text;
				$user_type = 'admin';
				$staff_id = 1;
			}
			$orderDetail = Order::where('order_number','=',$order_number)->orderBy('id','desc')->first();
			
			if(!empty($orderDetail)){
				
				
				$order = Order::find($orderDetail->id);
				$order->order_status = $order_status_text;
				$order->save();
				
				$exitorderStatus = OrderDeliveryStatus::where('order_id','=',$orderDetail->id)->where('order_status_type','=',$order_status_type)->first();
				
				if(!empty($exitorderStatus)){
					$orderStatus = OrderDeliveryStatus::find($exitorderStatus->id);
				}else{
					$orderStatus = new OrderDeliveryStatus();
				}
				$orderStatus->order_id = $orderDetail->id;
				$orderStatus->order_status = $order_status_text;
				$orderStatus->order_status_type = $order_status_type;
				$orderStatus->user_type = $user_type;
				$orderStatus->user_id = $staff_id;
				$orderStatus->created_at = date('Y-m-d H:i:s');
				$orderStatus->updated_at = date('Y-m-d H:i:s');
				$orderStatus->save();
				
				//echo '<pre>orderDetail'; print_R($order); die;
				
				
				 return \Redirect::to('admin/orders/'.$order_number);
			}
		}
	}



    
}
