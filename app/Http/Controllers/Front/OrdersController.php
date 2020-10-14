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
use App\Models\OrderDeliveryStatus;
use App\Models\AdminUser;
use App\Models\Staff;
use App\Http\Controllers\Controller;
use Session;
use Auth;

class OrdersController extends Controller
{

  /**
     * displaying order detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  varchar  $order_number
     * @return \Illuminate\Http\Response
     */
	public function order_detail(Request $request ,$order_number = null){
		
		if(!empty($order_number)){
			
			$orderDetail = Order::with('order_items','user')->where('user_id','=', Auth::user()->id)->where('order_number','=',$order_number)->orderBy('id','desc')->first();
			//echo '<pre>orderDetail'; print_R($orderDetail); die;
			if(!empty($orderDetail)){
				
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
			
			//echo '<prE>deliveryUserDetailArr'; print_r($deliveryUserDetailArr); die;
			
				 return view('front.orders.order_detail',['orderDetail'=>$orderDetail,'orderDeliveryStatusArr'=>$orderDeliveryStatusArr,'deliveryUserDetailArr'=>$deliveryUserDetailArr]);
			}else{
				return abort(404);
			}
		}else{
			return abort(404);
		}
		
		
	}



}
