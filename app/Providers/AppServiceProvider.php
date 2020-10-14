<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Page;
use App\Models\OrderComplaint;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Setting;

use App\Models\Product;
use App\Models\Country;
use App\Models\Postcode;
use App\Models\User;
use App\Models\ProductReview;
use App\Models\ProductTag;
use App\Models\UserAddress;
use App\Models\ShippingTax;
use App\Models\Couponcode;
use App\Models\ProductAttribute;

use Session;
use View;
use Auth;

use Illuminate\Support\Facades\Cookie;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        if(Cookie::get('cart_set_id') !== null){
            //echo Cookie::get('cart_set_id');die;
        }else{
            $str=rand();
            $secret_key = sha1($str);
            Cookie::queue('cart_set_id', $secret_key, 10080); 
        }



        View::composer('partials.header', function($view)
            {

        if (Auth::check()) {
                //echo '<pre>';print_r(Cookie::get('cart_set_id'));die;
            
            $cookiescart_list = Cart::where('user_id','=', null)->where('cart_set_id','=', Cookie::get('cart_set_id'))->get();
            if (!empty($cookiescart_list[0])) {
                foreach($cookiescart_list as $cookiescart){

                    $cart = Cart::find($cookiescart->id);
                    $cart->user_id = Auth::user()->id;
                    $cart->save();

                }
            }
            //echo '<pre>out';print_r($cookiescart_list);die;
        }
                $category_list = Category::with('children')->where('parent_id','=',0)->where('status','=', 1)->get();
                
                $cart_count = Cart::where('user_id','=', ((Auth::check())?Auth::user()->id:'1'))->get();
                $view->with('category_list', $category_list);
            });
/*        View::composer('partials.header', function($view)
            {
                
        $subcategory_list = Category::where('parent_id','!=',0)->where('status','=', 1)->get();
                $view->with('subcategory_list', $subcategory_list);
            });*/        

        View::composer('partials.header', function($view)
            {
                if (Auth::check()) {
                    $cart_count = Cart::where('user_id','=', ((Auth::check())?Auth::user()->id:'1'))->count();                    
                }else{

                    $cart_count = Cart::where('cart_set_id','=', Cookie::get('cart_set_id'))->count();

                }
                $view->with('cart_count', $cart_count);
            });

        View::composer('partials.header', function($view)
            {
                //echo Cookie::get('cart_set_id');die;
              $total = 0;
                if (Auth::check()) {
                    $cart_list = Cart::with('product')->where('user_id','=', ((Auth::check())?Auth::user()->id:'1'))->get();
                }else{
                    $cart_list = Cart::with('product')->where('cart_set_id','=', Cookie::get('cart_set_id'))->get();
                }
                
                $couponn = array();
                foreach ($cart_list as $key1 => $cart_value) {
                  
                    $attributeArr = unserialize($cart_value['productItem_ids']);
                    $attribute_detail = array();
                    $attribute_detail['amount'] = 0;
                    if (!empty($cart_value['productItem_ids'])) {
                      foreach ($attributeArr as $key => $value) {
                        
                        $product_feature_attributes = ProductAttribute::where('id', $value)->first();
                        if (!empty($product_feature_attributes)) {
                          
                          $name = getAttributeName($product_feature_attributes->attribute);
                          if ($product_feature_attributes->price_type == 'Increment') {
                            $attribute_detail['amount'] +=$product_feature_attributes->price;
                          }elseif ($product_feature_attributes->price_type == 'Decrement') {
                            $attribute_detail['amount'] -=$product_feature_attributes->price;
                            
                          }

                          
                        }     
                              
                      }
                    }
                  

                  $total += ($cart_value->product->price+$attribute_detail['amount']) * $cart_value['qty'];
                        
                }                
         
                $cart_amount = $total;

                $view->with('cart_amount', $cart_amount);
            });

        View::composer('partials.footer', function($view)
            {
                
                $pages_detail = Page::where('status','=', 1)->where('footer_page','=', 1)->orderBy('sort_number')->get();
                $view->with('pages_detail', $pages_detail);
            });

        View::composer('partials.footer', function($view)
            {
                
                $client_list = Client::where('status','=', 1)->where('featured','=', 1)->limit(6)->get();
                $view->with('client_list', $client_list);
            });

        View::composer('partials.header', function($view)
            {
                
                $pages_detail = Page::where('status','=', 1)->where('header_page','=', 1)->orderBy('sort_number')->get();
                $view->with('pages_detail', $pages_detail);
            });

        /*View::composer('*', function($view)
            {




          
                $view->with('cart_list', $cart_list);
                $view->with('addressesArr', $addressesArr);
                $view->with('shipping_taxes', $shipping_taxes);
                $view->with('couponcode_list', $couponcode_list);

            });*/
            
            
        


        $activeComplaints = OrderComplaint::select('order_number')->where('status','=',0)->where('user_type','=','customer')->distinct('order_number')->orderBy('created_at','desc')->get();
        //echo '<pre>data_crawled_count'; print_r($activeComplaints); die;
        $activeComplaintDataArr = array();
        if(!empty($activeComplaints)){
            $i = 0;
            foreach($activeComplaints as $active_complaint){
                
                $lastComplaint = OrderComplaint::where('status','=',0)->where('order_number','=',$active_complaint['order_number'])->orderBy('created_at','desc')->first();
                
                if($lastComplaint->user_type == "customer"){
                    $activeComplaintDataArr[$lastComplaint->order_number]['user_id'] = $lastComplaint->user_id;
                    $activeComplaintDataArr[$lastComplaint->order_number]['order_number'] = $lastComplaint->order_number;
                    //$activeComplaintDataArr[$i][$active_complaint->order_number][$i]['subject'] = $active_complaint->subject;
                    $activeComplaintDataArr[$lastComplaint->order_number]['problem'] = $lastComplaint->problem;
                    $activeComplaintDataArr[$lastComplaint->order_number]['user_type'] = $lastComplaint->user_type;
                    $activeComplaintDataArr[$lastComplaint->order_number]['created_at'] = date('d M,Y  H:i A', strtotime($lastComplaint->created_at));
                }
                //echo '<pre>lastComplaint'; print_R($lastComplaint); die;
                
            $i++;
            }
            
            //echo '<pre>activeComplaintArr'; print_R($activeComplaintArr); die;
        }
        View::share('activeComplaints', $activeComplaints);
        View::share('activeComplaintDataArr', $activeComplaintDataArr);		
        $setting = Setting::with('openingTime')->first();
        $people_count = range(1, $setting->total_men);
        View::share('people_count', $people_count);        

        $timearray = getTimeArr();
        View::share('timearray', $timearray);













/***************************pre order admin header**********************************************/
        $orders_pre = Order::select('order_number','id','created_at')->with(['order_items' => function($test) {
                        $test->where('is_pre_order', '=', 1);
                    }])->where('order_status','=','Order Confirmed')->orderBy('created_at','desc')->get();

//		echo '<pre>data_crawled_count'; print_r($orders_pre);die;
		$preorderDataArr = array();
		if(!empty($orders_pre)){			
			foreach($orders_pre as $orders_pres){

              foreach ($orders_pres->order_items as $key => $preorder_item) {
                if (($preorder_item->is_pre_order == 1) && ($preorder_item->order_id == $orders_pres->id)){
                     $preorderDataArr[$orders_pres->id]['order_number'] = $orders_pres->order_number;
                     $preorderDataArr[$orders_pres->id]['date'] = date('d M,Y  H:i A', strtotime($orders_pres->created_at));
                }               
              }              
			}
		}
       // echo '<pre>';print_r($preorderDataArr);die;
		View::share('preorderDataArr', $preorderDataArr);
/*************************************************************************************8*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
