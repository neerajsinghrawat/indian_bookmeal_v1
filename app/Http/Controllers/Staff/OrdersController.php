<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Staff;
use App\Models\OrderDeliveryStatus;
use App\Models\AdminUser;
use Session;
use Auth;
class OrdersController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:staff');
     
    }

    /**
     * Show all recoreds in table a new resource.
     *
     * @return \Illuminate\Http\Response
    */  
    public function index()
    {
		$order_list = OrderDeliveryStatus::with('order','order_items')->where('order_status_type','=','assign_staff')->where('user_type','=','staff')->where('user_id','=',Auth::user()->id)->orderBy('created_at','desc')->paginate(10);

    	//echo '<pre>';print_r($order_list);die;
		return view('staff.orders.index',["order_list" => $order_list]);
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
			
			return view('staff.orders.order_detail',['orderDetail'=>$orderDetail]);
		}
		
	}
	

	/**
     * update order status detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update_delivery_satff(Request $request){

    	//echo '<pre>';print_r($_POST);die;
    	$result = 0;
		if(isset($_POST['order_number'])){
			
			$staff_id =	Auth::user()->id;
			$order_number =	!empty($_POST['order_number']) ? $_POST['order_number'] : '';
			$order_status =	!empty($_POST['order_status']) ? $_POST['order_status'] : '';
			
			
			
			$orderDetail = Order::where('order_number','=',$order_number)->orderBy('id','desc')->first();
			
			if(!empty($orderDetail)){
				
				if(!empty($order_status)){
					$orderStatusArr = explode('~',$order_status);
					$order_status_type = isset($orderStatusArr[0]) ? $orderStatusArr[0] : $order_status_type;
					$order_status_text = isset($orderStatusArr[1]) ? $orderStatusArr[1] : $order_status_text;
					$user_type = 'staff';

				}
				
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
				
				$result = 1 ;
			}
		}
		return $result;
	}
	

    
}
