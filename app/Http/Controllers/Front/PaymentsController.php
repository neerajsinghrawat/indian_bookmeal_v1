<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Session;
use Redirect;

use Stripe;
use Exception; 
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderDeliveryStatus;
use App\Models\EmailTemplate;
use App\Models\Product;
use App\Models\ShippingTax;
use App\Models\Postcode;
use App\Models\ProductAttribute;
use App\Models\Setting;
use App\Models\PaymentGetway;
use App\Models\ProductFeatureAttribute;
use App\Models\ProductFeature;
use App\Models\OrderAttribute;

class PaymentsController extends Controller
{

    




/**
 * Show the form for creating a new resource.
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function paypal(Request $request)
    {	
        $steps = array();
        $product_detail = array();

        $cart_itemslist = Cart::with('product')->where('user_id','=', Auth::user()->id)->get();
        $shipping_taxes = ShippingTax::first();
        $total = 0;
        $request->take_order = (!empty($request->take_order))?$request->take_order:'takeaway';
        //echo '<pre>';print_r($_POST);die;
        if (!empty($cart_itemslist[0])) {
          foreach ($cart_itemslist as $key => $cartlistdetail) {     
              $attributes = $this->getAttributeDetail($cartlistdetail->productItem_ids);            
              $total += (($cartlistdetail->product->price+$attributes['amount']) * $cartlistdetail->qty);
          }

          if($request->take_order == 'delivery'){

            if (!empty($shipping_taxes->shipping_amount) && $shipping_taxes->shipping_type == 'Paid') {

            $shippingamount = $shipping_taxes->shipping_amount;

            }else {

            $shippingamount = 0;
            }
          }else{
            $shippingamount = 0;
          }


          if (!empty($shipping_taxes->tax_percent) && $shipping_taxes->tax_percent > 0) {              
            $tax_amount =  ($total * $shipping_taxes->tax_percent) / 100;
          } else {
            $tax_amount = 0 ;
          }

          $submaintotal = $total + $shippingamount + $tax_amount;

          //echo '<pre>';print_r(Session::get('apply_coupon'));die;
          if (Session::has('apply_coupon')) {
            if (Session::get('apply_coupon.status') == 'percentage') {
              $coupon_discount = $total * Session::get('apply_coupon.percentage') / 100 ;
              if ($submaintotal > $coupon_discount) {
                  $maintotal = $submaintotal - $coupon_discount;
              }else {
                  $maintotal = 0;
              }
            }else{
              $coupon_discount = Session::get('apply_coupon.amount');
              if ($submaintotal > Session::get('apply_coupon.amount')) {
                  $maintotal = $submaintotal - Session::get('apply_coupon.amount');
              }else {
                  $maintotal = 0;
              }
            }        
          }else{
            $coupon_discount = 0;
            $maintotal = $submaintotal;
          }
        }

        if (!empty($cart_itemslist[0])) {   

            if($request->take_order == 'delivery'){
              $steps['deliveryAddress'] = isset($request->deliveryAddress) ? $request->deliveryAddress : '';
              $postcode_list = Postcode::where('post_code','=',$steps['deliveryAddress']['postcode'])->first();

              if (!empty($postcode_list)) {
                $steps['step'] = 'step_2';
                $steps['total'] = $total;
                $steps['user'] = $request->user;
                $steps['tax_amount'] = $tax_amount; 
                $steps['maintotal'] = $maintotal; 
                $steps['coupon_discount'] = $coupon_discount; 
                $steps['shippingamount'] = $shippingamount; 
                $steps['shipping_type'] = $shipping_taxes->shipping_type; 
                $steps['tax_percentage'] = $shipping_taxes->tax_percent; 
                if (Session::has('shoppingstep')) {
                    Session::forget('shoppingstep.step');
                }
                Session::put('shoppingstep', $steps);
              }else{
                Session::flash('error_h1','Postcode');
                Session::flash('error','Food delivery not able to your Postcode, Change Postcode');
                return redirect('/shopping-cart');
              }  

            }else{

                $steps['step'] = 'step_2';
                $steps['total'] = $total;
                $steps['user'] = $request->user;
                $steps['tax_amount'] = $tax_amount; 
                $steps['maintotal'] = $maintotal; 
                $steps['coupon_discount'] = $coupon_discount; 
                $steps['shippingamount'] = $shippingamount; 
                $steps['shipping_type'] = $shipping_taxes->shipping_type; 
                $steps['tax_percentage'] = $shipping_taxes->tax_percent; 
                if (Session::has('shoppingstep')) {
                    Session::forget('shoppingstep.step');
                }
                Session::put('shoppingstep', $steps);

            }      
                  
            
            
          
        }

       $total = (Session::has('shoppingstep.maintotal'))?Session::get('shoppingstep.maintotal'):0; 
       if($total == 0){
        return redirect('/shopping-cart');
       }

       if ($request->payment_type == 'Cod') {

            $this->cod($request->take_order);
            //Session::flash('success','Your order Place successfully');
            return Redirect::to('/cart-thankyou');

       }elseif($request->payment_type == 'Stripe'){

          $res = $this->stripe($request);

          if ($res == 1) {
            //Session::flash('success','Your order Place successfully');
            return Redirect::to('/cart-thankyou');
          }else{
            Session::flash('error','Try again!');
            return Redirect::to('/shopping-cart');
          }

       }      
        
        
    }


    private function cod($take_order){


        $payment_id = 'cod';
        
        $user_address_id = 0;
        $delivery_address = '';
        $delivery_postcode = '';
        $delivery_phone = '';   
       // print_r($_POST);die;
        $tax_amount = (!empty(Session::get('shoppingstep.tax_amount')))?Session::get('shoppingstep.tax_amount'):'';
        $subtotal = (!empty(Session::get('shoppingstep.total')))?Session::get('shoppingstep.total'):'';
        $maintotal = (!empty(Session::get('shoppingstep.maintotal')))?Session::get('shoppingstep.maintotal'):'';
        $shippingamount = (!empty(Session::get('shoppingstep.shippingamount')))?Session::get('shoppingstep.shippingamount'):'';
        $shipping_type = (!empty(Session::get('shoppingstep.shipping_type')))?Session::get('shoppingstep.shipping_type'):'';
        $tax_percentage = (!empty(Session::get('shoppingstep.tax_percentage')))?Session::get('shoppingstep.tax_percentage'):'';

        $coupon_discount = (Session::has('apply_coupon') && !empty(Session::get('shoppingstep.coupon_discount')))?Session::get('shoppingstep.coupon_discount'):'';
        $coupon_code = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_code')))?Session::get('apply_coupon.coupon_code'):'';
        $coupon_type = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_type')))?Session::get('apply_coupon.coupon_type'):'';
        $coupon_amount = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_amount')))?Session::get('apply_coupon.coupon_amount'):'';

        if(Session::has('shoppingstep.deliveryAddress')){
          $user_address_id = Session::get('shoppingstep.deliveryAddress.address_id');
          $delivery_address = Session::get('shoppingstep.deliveryAddress.address');
          $delivery_postcode = Session::get('shoppingstep.deliveryAddress.postcode');
          $delivery_phone = Session::get('shoppingstep.deliveryAddress.phone');
        }
            
        
        //$result = $payment->execute($execution, $this->_api_context);
        
    
  
        $order_number = $this->random_num(7);
       
        $order = new Order;
        $order->order_number = $order_number;
        $order->payment_id = 'cod';
        $order->user_id =  Auth::user()->id;
        $order->total_amount =  (Session::has('shoppingstep.maintotal'))?Session::get('shoppingstep.maintotal'):0;
        
        $total_qty = 0;
        $cartIds = array();
        $productIds = array();
        $cart_itemslist = Cart::where('user_id','=', Auth::user()->id)->get();
        if(!empty($cart_itemslist)){
          foreach($cart_itemslist as $cart){
            $total_qty += $cart->qty;
            $cartIds[$cart->id] = $cart->id;
            $productIds[$cart->product_id] = $cart->product_id;
            
          }
        }
  
        $order->total_qty  = $total_qty;
        $order->payment_status  = 'cod';
        $order->product_ids  = serialize($productIds);
        $order->order_status  = 'Order Confirmed'; //kz 28 dec
        $order->user_address_id  = $user_address_id; 
        $order->delivery_address  = $delivery_address; 
        $order->delivery_postcode  = $delivery_postcode; 
        $order->delivery_phone  = $delivery_phone; 

        $order->tax_amount  = $tax_amount; 
        $order->maintotal  = $maintotal; 
        $order->shippingamount  = $shippingamount; 
        $order->shipping_type  = $shipping_type; 
        $order->tax_percentage  = $tax_percentage; 
        $order->subtotal  = $subtotal; 
        $order->coupon_discount  = $coupon_discount; 
        $order->coupon_code  = $coupon_code; 
        $order->coupon_type  = $coupon_type; 
        $order->coupon_amount  = $coupon_amount; 
        $order->payment_mode  = 'cod'; 
        $order->take_order  = $take_order; 
        $order->save();
  
        
        $orderStatus = new OrderDeliveryStatus();
        $orderStatus->order_id = $order->id;
        $orderStatus->order_status = 'Order Confirmed';
        $orderStatus->order_status_type = 'confirmed';
        $orderStatus->user_type = 'admin';
        $orderStatus->user_id = 1;
        $orderStatus->created_at = date('Y-m-d H:i:s');
        $orderStatus->updated_at = date('Y-m-d H:i:s');
        $orderStatus->save();
  
  
        $cart_itemslist = Cart::with('product')->where('user_id','=', Auth::user()->id)->get();
         if(!empty($cart_itemslist)){
           foreach($cart_itemslist as $cart){
            $attributes = $this->getAttributeDetail($cart->productItem_ids);            
            $subtotal = ($cart->product->price+$attributes['amount']);
            $total = (($cart->product->price+$attributes['amount']) * $cart->qty);
             // save data in cart item table
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cart->product_id;
            $orderItem->productFeatureItem_id = $cart->productItem_ids;

            $product_detail = $this->getproduct_detail($cart->product_id);
            //echo '<pre>';print_r($product_detail);die;
            $orderItem->user_id = Auth::user()->id;
            $orderItem->is_pre_order = (isset($product_detail['is_pre_order'])&& !empty($product_detail['is_pre_order']))?$product_detail['is_pre_order']:0;
            $orderItem->order_date = (isset($product_detail['order_date'])&& !empty($product_detail['order_date']))?$product_detail['order_date']:date("Y-m-d");
            $orderItem->product_name = $cart->product->name;
            $orderItem->product_image = $cart->product->image;
            $orderItem->qty =  $cart->qty;
            $orderItem->amount = $subtotal;
            $orderItem->total_amount = $total;


            
            $orderItem->save();
            $this->saveAttributedetail($cart->productItem_ids,$order->id,$orderItem->id);

           }
         }
  
  
  
        // deleting user cart by cartids
        $this->deleteUserCartByIds($cartIds);
  
        // distory user cart session
        $this->distoryUserCartSession();      

        // send order mail to user
        
        $this->sendmailtocustomer($order_number);

        if (Session::has('apply_coupon')) {
                Session::forget('apply_coupon');
        }
        //Session::flash('success_h1','Payment');
        
        //Session::flash('success','Payment successfully');          

        
        return true;
        
          
    }
    public function stripe($request){

        $user_address_id = 0;
        $delivery_address = '';
        $delivery_postcode = '';
        $delivery_phone = '';   
        $newErrorMsg = 0;
        //echo "<pre>";print_r($request->stripe);die;
        $tax_amount = (!empty(Session::get('shoppingstep.tax_amount')))?Session::get('shoppingstep.tax_amount'):'';
        $subtotal = (!empty(Session::get('shoppingstep.total')))?Session::get('shoppingstep.total'):'';
        $maintotal = (!empty(Session::get('shoppingstep.maintotal')))?Session::get('shoppingstep.maintotal'):'';
        $shippingamount = (!empty(Session::get('shoppingstep.shippingamount')))?Session::get('shoppingstep.shippingamount'):'';
        $shipping_type = (!empty(Session::get('shoppingstep.shipping_type')))?Session::get('shoppingstep.shipping_type'):'';
        $tax_percentage = (!empty(Session::get('shoppingstep.tax_percentage')))?Session::get('shoppingstep.tax_percentage'):'';

        $coupon_discount = (Session::has('apply_coupon') && !empty(Session::get('shoppingstep.coupon_discount')))?Session::get('shoppingstep.coupon_discount'):'';
        $coupon_code = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_code')))?Session::get('apply_coupon.coupon_code'):'';
        $coupon_type = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_type')))?Session::get('apply_coupon.coupon_type'):'';
        $coupon_amount = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_amount')))?Session::get('apply_coupon.coupon_amount'):'';

        if(Session::has('shoppingstep.deliveryAddress')){
          $user_address_id = Session::get('shoppingstep.deliveryAddress.address_id');
          $delivery_address = Session::get('shoppingstep.deliveryAddress.address');
          $delivery_postcode = Session::get('shoppingstep.deliveryAddress.postcode');
          $delivery_phone = Session::get('shoppingstep.deliveryAddress.phone');
        }


        /*$this->validate($request, [
            'card_no' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'cvv' => 'required',
        ]);*/

        $payment_getway = PaymentGetway::first();

        //echo "<pre>";print_r($payment_getway->secret_id);die;
        $balance_transaction = '';
        $payment_status = '';
        $clientId = '';
        $clientToken = '';
        $payment_status_code = 0;
        $stripe = Stripe\Stripe::setApiKey($payment_getway->secret_id);
        $payment_error = '';
        $card_error = 0;

        try {
            $generateToken = \Stripe\Token::create(array(
                "card" => array(
                    "number"    => $request->stripe['card_number'],
                    "exp_month" => $request->stripe['expire_month'],
                    "exp_year"  => $request->stripe['expire_year'],
                    "cvc"       => $request->stripe['cvv'],
                )));
            
           } catch (Exception $e) {
              $payment_error = $e->getMessage();
              $card_error = 1;
              //echo "<pre>";print_r($payment_error);die;
              
            }
               
            if($card_error == 0){
              $stripeToken = isset($generateToken['id']) ? $generateToken['id'] : '';
              $description = 'stripe';
              $stripe_username = Auth::user()->first_name.' '.Auth::user()->last_name;
              $stripe_userphone = Auth::user()->phone;
                
              $customer = \Stripe\Customer::create(array(
                        'source'   => $stripeToken,
                        'email'    => Auth::user()->email,
                        'name'    => $stripe_username,
                        'phone'    => $stripe_userphone,
                        'description'     => $description,
                        //'account_balance' => $amount_cents,
                      )
                    );
                //echo '<pre>customer'; print_r($customer); die;  
                $clientId = !empty($customer) ? $customer->id : '';
                $stripeToken = isset($generateToken['id']) ? $generateToken['id'] : '';
                
            }


        
        if(isset($stripeToken) && !empty($stripeToken) && $card_error == 0)
        {
            
            $amount_cents = str_replace(".","",number_format($maintotal, 2));  // Chargeble amount
            $currencies = array(
                  'GBP' => array('currency' => 'GBP','currency_symbol' => '£','currency_code' => 'GBP'),
                  'USD' => array('currency' => 'USD','currency_symbol' => '$','currency_code' => 'USD'),
                    );
            $settings = Setting::first()->toArray();

            $currency_type = (isset($settings['site_currency_type']) && !empty($settings['site_currency_type'])) ? $currencies[$settings['site_currency_type']]['currency_code'] : 'USD';

            //echo "<pre>";print_r($currency_type);die;
            //$invoiceid = mt_rand( 10000000, 99999999);                      // Invoice ID
            $description = 'stripe';
            try {
              $payment_result = \Stripe\Charge::create([     
                  "amount" => $amount_cents,
                  "currency" => $currency_type,
                  "customer" => $clientId,
                  "receipt_email" => Auth::user()->email,
                  "description" => $description]       
              );
            
              // Payment has succeeded, no exceptions were thrown or otherwise caught       
              
              if(!empty($payment_result)){
                if(isset($payment_result->balance_transaction) && $payment_result->balance_transaction != ''){  
                  $balance_transaction = $payment_result->balance_transaction;
                  $payment_status = $payment_result->status;
                }
              }
              
            } catch(Exception $e) {      

              $payment_error = $e->getMessage();
            
            } 
            
        }else{
          $results['result'] = 0;
          $results['error_msg'] = $payment_error;
          $results['error_message'] = '<h1 class="payment_result">failed</h1>';
          Session::flash('error',$results['error_msg']);
          return Redirect::to('/shopping-cart');
        }
        
        if(!empty($payment_result)){
          if(isset($balance_transaction) && $balance_transaction != ''){
            
            $payment_status = strtolower($payment_status);
            
            $paymentStatusArr = array('succeeded','pending','paid','success','successful');
            if(in_array($payment_status,$paymentStatusArr)){
              $p_result = ucfirst($payment_status);
              
              $payment_status_code = 1;
              $payment_status_type = $p_result;
              $paymentResult = $p_result;
            }
          }
          
        }else{
          $paymentResult = $payment_error;
          Session::flash('error',$payment_error);
          return Redirect::to('/shopping-cart');
        }
        

        if ($payment_status_code == 1) {

            $payment_id = $payment_result->balance_transaction;
            
            $user_address_id = 0;
            $delivery_address = '';
            $delivery_postcode = '';
            $delivery_phone = '';   

            $tax_amount = (!empty(Session::get('shoppingstep.tax_amount')))?Session::get('shoppingstep.tax_amount'):'';
            $subtotal = (!empty(Session::get('shoppingstep.total')))?Session::get('shoppingstep.total'):'';
            $maintotal = (!empty(Session::get('shoppingstep.maintotal')))?Session::get('shoppingstep.maintotal'):'';
            $shippingamount = (!empty(Session::get('shoppingstep.shippingamount')))?Session::get('shoppingstep.shippingamount'):'';
            $shipping_type = (!empty(Session::get('shoppingstep.shipping_type')))?Session::get('shoppingstep.shipping_type'):'';
            $tax_percentage = (!empty(Session::get('shoppingstep.tax_percentage')))?Session::get('shoppingstep.tax_percentage'):'';

            $coupon_discount = (Session::has('apply_coupon') && !empty(Session::get('shoppingstep.coupon_discount')))?Session::get('shoppingstep.coupon_discount'):'';
            $coupon_code = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_code')))?Session::get('apply_coupon.coupon_code'):'';
            $coupon_type = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_type')))?Session::get('apply_coupon.coupon_type'):'';
            $coupon_amount = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_amount')))?Session::get('apply_coupon.coupon_amount'):'';

            if(Session::has('shoppingstep.deliveryAddress')){
              $user_address_id = Session::get('shoppingstep.deliveryAddress.address_id');
              $delivery_address = Session::get('shoppingstep.deliveryAddress.address');
              $delivery_postcode = Session::get('shoppingstep.deliveryAddress.postcode');
              $delivery_phone = Session::get('shoppingstep.deliveryAddress.phone');
            }
                
            
            //$result = $payment->execute($execution, $this->_api_context);
            
        
      
            $order_number = $this->random_num(7);
           
            $order = new Order;
            $order->order_number = $order_number;
            $order->payment_id = $payment_id;
            $order->user_id =  Auth::user()->id;
            $order->total_amount =  (Session::has('shoppingstep.maintotal'))?Session::get('shoppingstep.maintotal'):0;
            
            $total_qty = 0;
            $cartIds = array();
            $productIds = array();
            $cart_itemslist = Cart::where('user_id','=', Auth::user()->id)->get();
            if(!empty($cart_itemslist)){
              foreach($cart_itemslist as $cart){
                $total_qty += $cart->qty;
                $cartIds[$cart->id] = $cart->id;
                $productIds[$cart->product_id] = $cart->product_id;
                
              }
            }
      
            $order->total_qty  = $total_qty;
            $order->payment_status  = $payment_status_type;
            $order->product_ids  = serialize($productIds);
            $order->order_status  = 'Order Confirmed'; //kz 28 dec
            $order->user_address_id  = $user_address_id; 
            $order->delivery_address  = $delivery_address; 
            $order->delivery_postcode  = $delivery_postcode; 
            $order->delivery_phone  = $delivery_phone; 

            $order->tax_amount  = $tax_amount; 
            $order->maintotal  = $maintotal; 
            $order->shippingamount  = $shippingamount; 
            $order->shipping_type  = $shipping_type; 
            $order->tax_percentage  = $tax_percentage; 
            $order->subtotal  = $subtotal; 
            $order->coupon_discount  = $coupon_discount; 
            $order->coupon_code  = $coupon_code; 
            $order->coupon_type  = $coupon_type; 
            $order->coupon_amount  = $coupon_amount; 
            $order->payment_mode  = 'paid'; 
            $order->take_order  = $request->take_order; 
            $order->save();
      
            
            $orderStatus = new OrderDeliveryStatus();
            $orderStatus->order_id = $order->id;
            $orderStatus->order_status = 'Order Confirmed';
            $orderStatus->order_status_type = 'confirmed';
            $orderStatus->user_type = 'admin';
            $orderStatus->user_id = 1;
            $orderStatus->created_at = date('Y-m-d H:i:s');
            $orderStatus->updated_at = date('Y-m-d H:i:s');
            $orderStatus->save();
      
      
            $cart_itemslist = Cart::with('product')->where('user_id','=', Auth::user()->id)->get();
             if(!empty($cart_itemslist)){
               foreach($cart_itemslist as $cart){
                $attributes = $this->getAttributeDetail($cart->productItem_ids);            
                $subtotal = ($cart->product->price+$attributes['amount']);
                $total = (($cart->product->price+$attributes['amount']) * $cart->qty);
                 // save data in cart item table
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cart->product_id;
                $orderItem->productFeatureItem_id = $cart->productItem_ids;


                $product_detail = $this->getproduct_detail($cart->product_id);
                //echo '<pre>';print_r($product_detail);die;
                $orderItem->user_id = Auth::user()->id;
                $orderItem->is_pre_order = (isset($product_detail['is_pre_order'])&& !empty($product_detail['is_pre_order']))?$product_detail['is_pre_order']:0;
                $orderItem->order_date = (isset($product_detail['order_date'])&& !empty($product_detail['order_date']))?$product_detail['order_date']:date("Y-m-d");
                $orderItem->product_name = $cart->product->name;
                $orderItem->product_image = $cart->product->image;
                $orderItem->qty =  $cart->qty;
                $orderItem->amount = $subtotal;
                $orderItem->total_amount = $total;
                
                $orderItem->save();
                $this->saveAttributedetail($cart->productItem_ids,$order->id,$orderItem->id);
               }
             }
      
      
      
            // deleting user cart by cartids
            $this->deleteUserCartByIds($cartIds);
      
            // distory user cart session
            $this->distoryUserCartSession();      

            // send order mail to user
            
            $this->sendmailtocustomer($order_number);

            if (Session::has('apply_coupon')) {
                    Session::forget('apply_coupon');
            }


          $newErrorMsg = 1;
          return $newErrorMsg;
        }
        
        
          return $newErrorMsg;
        
          
    }

    public function saveAttributedetail($value=array(),$order_id,$order_itemid)
    {
      $attrArr = array();
      if (!empty($value)) {
        $attrArr = unserialize($value);

        foreach ($attrArr as $key => $value) {
          if (!empty($value)) {

            $product_attributes = ProductAttribute::where('id', $value)->first();
            if (!empty($product_attributes)) {
              $product_featureAttributes = ProductFeatureAttribute::with('productFeature')->where('id', $product_attributes->attribute)->first();
              if (!empty($product_featureAttributes)) {
                $productFeatures = ProductFeature::where('id', $product_attributes->feature_id)->first();
                if (!empty($productFeatures)) {

                  
                    $orderAttribute = new OrderAttribute;
                
                    $orderAttribute->price = $product_attributes->price;
                    $orderAttribute->is_same_price = $product_attributes->is_same_price;
                    $orderAttribute->price_type = $product_attributes->price_type;
                    $orderAttribute->attribute_id = $product_attributes->attribute;
                    $orderAttribute->name = $product_featureAttributes->name;
                    $orderAttribute->order_id = $order_id;
                    $orderAttribute->order_item_id = $order_itemid;
                    $orderAttribute->feature_name = $productFeatures->value;
                    $orderAttribute->save();
                                 
                }                
              }              

            }
           
          }

        }
      }
    }

    public function getPaymentStatus()
    {
		//echo '<pre>data'; print_r(Session::get('shoppingstep.deliveryAddress')); die;
		//$tax_shipping = ShippingTax::first();
        /** Get the payment ID before session clear **/
    $payment_id = Session::get('paypal_payment_id');
		//echo '<pre>';print_r(Session::get('shoppingstep'));die;
		$user_address_id = '';
		$delivery_address = '';
		$delivery_postcode = '';
		$delivery_phone = '';		

		$tax_amount = (!empty(Session::get('shoppingstep.tax_amount')))?Session::get('shoppingstep.tax_amount'):'';
		$subtotal = (!empty(Session::get('shoppingstep.total')))?Session::get('shoppingstep.total'):'';
		$maintotal = (!empty(Session::get('shoppingstep.maintotal')))?Session::get('shoppingstep.maintotal'):'';
		$shippingamount = (!empty(Session::get('shoppingstep.shippingamount')))?Session::get('shoppingstep.shippingamount'):'';
		$shipping_type = (!empty(Session::get('shoppingstep.shipping_type')))?Session::get('shoppingstep.shipping_type'):'';
		$tax_percentage = (!empty(Session::get('shoppingstep.tax_percentage')))?Session::get('shoppingstep.tax_percentage'):'';

		$coupon_discount = (Session::has('apply_coupon') && !empty(Session::get('shoppingstep.coupon_discount')))?Session::get('shoppingstep.coupon_discount'):'';
		$coupon_code = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_code')))?Session::get('apply_coupon.coupon_code'):'';
		$coupon_type = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_type')))?Session::get('apply_coupon.coupon_type'):'';
		$coupon_amount = (Session::has('apply_coupon') && !empty(Session::get('apply_coupon.coupon_amount')))?Session::get('apply_coupon.coupon_amount'):'';

		if(Session::has('shoppingstep.deliveryAddress')){
			$user_address_id = Session::get('shoppingstep.deliveryAddress.address_id');
			$delivery_address = Session::get('shoppingstep.deliveryAddress.address');
			$delivery_postcode = Session::get('shoppingstep.deliveryAddress.postcode');
			$delivery_phone = Session::get('shoppingstep.deliveryAddress.phone');
		}
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::to('/');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {
			
           $order_number = $this->random_num(7);
           
            $order = new Order;
            $order->order_number = $order_number;
            $order->payment_id = $result->getId();
            $order->user_id =  Auth::user()->id;
			$order->total_amount =  (isset($result->transactions[0]->amount->total) && !empty($result->transactions[0]->amount->total)) ? $result->transactions[0]->amount->total : 0;
			
			$total_qty = 0;
			$cartIds = array();
			$productIds = array();
			$cart_itemslist = Cart::where('user_id','=', Auth::user()->id)->get();
			if(!empty($cart_itemslist)){
				foreach($cart_itemslist as $cart){
					$total_qty += $cart->qty;
					$cartIds[$cart->id] = $cart->id;
					$productIds[$cart->product_id] = $cart->product_id;
					
				}
			}
			
			$order->total_qty  = $total_qty;
			$order->payment_status  = $result->getState();
			$order->product_ids  = serialize($productIds);
			$order->order_status  = 'Order Confirmed'; //kz 28 dec
			$order->user_address_id  = $user_address_id; 
			$order->delivery_address  = $delivery_address; 
			$order->delivery_postcode  = $delivery_postcode; 
			$order->delivery_phone  = $delivery_phone; 

			$order->tax_amount  = $tax_amount; 
			$order->maintotal  = $maintotal; 
			$order->shippingamount  = $shippingamount; 
			$order->shipping_type  = $shipping_type; 
			$order->tax_percentage  = $tax_percentage; 
			$order->subtotal  = $subtotal; 
			$order->coupon_discount  = $coupon_discount; 
			$order->coupon_code  = $coupon_code; 
			$order->coupon_type  = $coupon_type; 
			$order->coupon_amount  = $coupon_amount; 
            $order->save();
			
			
			$orderStatus = new OrderDeliveryStatus();
			$orderStatus->order_id = $order->id;
			$orderStatus->order_status = 'Order Confirmed';
			$orderStatus->order_status_type = 'confirmed';
			$orderStatus->user_type = 'admin';
			$orderStatus->user_id = 1;
			$orderStatus->created_at = date('Y-m-d H:i:s');
			$orderStatus->updated_at = date('Y-m-d H:i:s');
			$orderStatus->save();
			
			
			$cart_itemslist = Cart::with('product')->where('user_id','=', Auth::user()->id)->get();
			 if(!empty($cart_itemslist)){
				 foreach($cart_itemslist as $cart){
					$attributes = $this->getAttributeDetail($cart->productItem_ids);            
          $subtotal = ($cart->product->price+$attributes['amount']);
          $total = (($cart->product->price+$attributes['amount']) * $cart->qty);
					 // save data in cart item table
					$orderItem = new OrderItem();
					$orderItem->order_id = $order->id;
          $orderItem->product_id = $cart->product_id;
					$orderItem->productFeatureItem_id = $cart->productItem_ids;

					$product_detail = $this->getproduct_detail($cart->product_id);
					//echo '<pre>';print_r($product_detail);die;
					$orderItem->user_id = Auth::user()->id;
					$orderItem->is_pre_order = (isset($product_detail['is_pre_order'])&& !empty($product_detail['is_pre_order']))?$product_detail['is_pre_order']:0;
					$orderItem->order_date = (isset($product_detail['order_date'])&& !empty($product_detail['order_date']))?$product_detail['order_date']:date("Y-m-d");
					$orderItem->product_name = $cart->product->name;
					$orderItem->product_image = $cart->product->image;
					$orderItem->qty =  $cart->qty;
					$orderItem->amount = $subtotal;
					$orderItem->total_amount = $total;
					
					$orderItem->save();
				 }
			 }
			
			
			
			// deleting user cart by cartids
			$this->deleteUserCartByIds($cartIds);
			
			// distory user cart session
			$this->distoryUserCartSession();			

			// send order mail to user
			
			$this->sendmailtocustomer($order_number);

			if (Session::has('apply_coupon')) {
          		Session::forget('apply_coupon');
     		}
			//ession::flash('success_h1','Payment');
            
          //Session::flash('success','Payment successfully');          

          
            return Redirect::to('/cart-thankyou');
        }
		
		    Session::flash('error_h1','Payment');
        Session::flash('error','Payment failed. Please try again');

        return Redirect::to('/');
    }
	
  public function getAttributeDetail($attribute='')
  {
          
      $attributeArr = unserialize($attribute);
      $attribute_detail = array();
      $attribute_detail['amount'] = 0;
      $attribute_detail['name'] = '';
      $attribute_detailname = '';

      if (!empty($attributeArr)) {
        //echo '<pre>';print_r($attributeArr);die;
        foreach ($attributeArr as $key => $value) {
          $product_feature_attributes = ProductAttribute::where('id', $value)->first();
          if (!empty($product_feature_attributes)) {
            
            $name = getAttributeName($product_feature_attributes->attribute);
            if ($product_feature_attributes->price_type == 'Increment') {
              $attribute_detail['amount'] +=$product_feature_attributes->price;
            }elseif ($product_feature_attributes->price_type == 'Decrement') {
              $attribute_detail['amount'] -=$product_feature_attributes->price;
              
            }

              //echo "<pre>";print_r(getAttributeName($product_feature_attributes->attribute));die;
              $attribute_detail['name'] .= $name.' ';

            
          }     
                
        }
      }
      //echo "<pre>";print_r($attribute_detail);die;
        return $attribute_detail;
  }	
/**
 * delete user cart by cart ids
 *
 * @param string $cartIds
 *
 * @return \Illuminate\Http\Response
 */
	public function getproduct_detail($product_id){
	
	$current_time = date("H:i:s");
    $current_time = strtotime($current_time);
    $current_date = date("Y-m-d");

	$productDetail = Product::with('categorysub')->where('id','=', $product_id)->first();

	$category_starttime = (!empty($productDetail->categorysub->start_time))?strtotime($productDetail->categorysub->start_time):'';
	$category_endtime = (!empty($productDetail->categorysub->end_time))?strtotime($productDetail->categorysub->end_time):'';
	$data = array();
	if($category_starttime > $current_time){

		$data['is_pre_order'] = 1;
		$data['order_date'] = $current_date;

	} if($category_endtime < $current_time){

		$data['is_pre_order'] = 1;
		$data['order_date'] = date('Y-m-d', strtotime($current_date. ' + 1 day'));

	}

	
	return $data;	
	}

/**
 * delete user cart by cart ids
 *
 * @param string $cartIds
 *
 * @return \Illuminate\Http\Response
 */
	public function deleteUserCartByIds($cartIds){
		if(!empty($cartIds)){
			Cart::whereIn('id', $cartIds)->delete(); 
		}
	}
	

/**
 * delete user cart by cart ids
 *
 * @param string $order_number
 *
 * @return \Illuminate\Http\Response
 */
	public function sendmailtocustomer($order_number){
		//die('asfsdf');
		$extraContentArr = array();
		$post_data = array();
		if(!empty($order_number)){
			
			$orderDetail = Order::with('order_items','user')->where('user_id','=', Auth::user()->id)->where('order_number','=',$order_number)->orderBy('id','desc')->first();
			
			$post_data['username'] = Auth::user()->username;
			$post_data['email'] = Auth::user()->email;


			if(!empty($orderDetail)){
					
			                   			$htmlcomment = '';
                    		if (isset($orderDetail) && !empty($orderDetail)) {

                    			$htmlcomment = '<table width="100%">
			                            <tr>
			                               <td style = "font-weight:bold;">ORDER SUMMARY</td>                  
			                            </tr>

			                            <tr>
			                            	<td style = "font-weight:bold;">Order Number:  '.$order_number.'</td> 			                            	

			                            	<td style = "font-weight:bold;"> Order Date:'.date('d/m/Y H:i A', strtotime($orderDetail->created_at)).'</td>  
			                            </tr>

			                            <tr>
			                               <td style = "font-weight:bold;"> Delivery Address:
    					'.$orderDetail->user->first_name.' '.$orderDetail->user->last_name.'<br>
    					'. $orderDetail->delivery_address.', '.$orderDetail->delivery_postcode.'<br>
    					'.$orderDetail->delivery_phone.'</td>                  
			                            </tr>
			                            </table>';

			                    $htmlcomment .= '<table width="100%" border= "1px">
			                                <thead>
			                                  <tr>
			                                    <th  style = "font-weight:bold;"> S.No.</th>
			                                    <th style = "font-weight:bold;" > Item</th>
			                                    <th style = "font-weight:bold;" > Product Attribute</th>
			                                    <th  style = "font-weight:bold;"> Rating</th>
                                          <th  style = "font-weight:bold;"> Price</th>
			                                    <th  style = "font-weight:bold;"> Payment Mode</th>
			                                    <th  style = "font-weight:bold;"> Quantity</th>
			                                    <th  style = "font-weight:bold;"> Totals</th>

			                                  </tr>
			                                </thead><tbody>';
			                        
			                        
			                            $index = 0;
			                            if(!empty($orderDetail->order_items)){
										foreach($orderDetail->order_items as $order_item){ 
										$payment_mode =($orderDetail->payment_mode == 'cod')?'Cash on delivery':'Paid';
										$iImgPath = asset('image/no_product_image.jpg');
										  if(isset($order_item->image) && !empty($order_item->image)){
											$iImgPath = asset('image/product/200x200/'.$order_item->image);
										  } 
			                               $index++;
			                             $categoryname = getAttributeDetail($order_item->productFeatureItem_id); 
			                               $htmlcomment.='<tr>
			                                          <td > '. $index .'</td>
			                                          <td > '. $order_item->product_name .'</td> 
			                                          <td > '.  $categoryname['name'] .'</td>            
			                                          <td > '. round($avg_rating = getProductAverageRatingfor_many_items($order_item->product_id)) .'</td>  
                                                <td > '.getSiteCurrencyType().''.$order_item->amount.'</td>
			                                          <td > '.$payment_mode.'</td>

			                                          <td > '. $order_item->qty .'</td> 			                                                        
			                                          <td > '.getSiteCurrencyType().$order_item->total_amount .'</td> 			                                                        
			                                        </tr>';                   							

			                                        }
    								$htmlcomment.='<tr><td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
                    <td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">'. getSiteCurrencyType().''.$orderDetail->subtotal.'</td>
    							</tr>';
    							if (!empty($orderDetail->coupon_discount)) {
    								if($orderDetail->coupon_type == 'percentage'){
					                      $amount_coupon = $orderDetail->coupon_amount.'%' ;
					                }else{
					                  $amount_coupon = getSiteCurrencyType().' '.$orderDetail->coupon_amount;
					                } 
    							$htmlcomment.='<tr><td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
                    <td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Coupon:'.$orderDetail->coupon_code.' <br/>(Discount:'.$amount_coupon.')</strong></td>
    								<td class="thick-line text-right">'. getSiteCurrencyType().''.$orderDetail->coupon_discount.'</td>
    							</tr>';
    							}
    							$htmlcomment.='<tr><td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
                    <td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Tax</strong></td>
    								<td class="thick-line text-right">'. getSiteCurrencyType().''.$orderDetail->tax_amount.'</td>
    							</tr><tr><td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
                    <td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Shipping Charges</strong></td>
    								<td class="thick-line text-right">'. getSiteCurrencyType().''.$orderDetail->shippingamount.'</td>
    							</tr>

    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                    <td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">'.getSiteCurrencyType(). $orderDetail->total_amount .'</td>
    							</tr>';
			                                       } 

			                    $htmlcomment .= '</tbody></table>';

                    		}
                    		$extraContentArr['Ordersummary'] =  $htmlcomment ;

			        		$emailTemplate = new EmailTemplate;
			        		$emailTemplate->sendUserEmail($post_data,4,$extraContentArr);

			}
		}	
	}
	

  /*public function getAttributeDetail($attribute)
    {
      
      $attributeArr = unserialize($attribute);
      $attribute_detail = array();
      $attribute_detail['amount'] = 0;
      $attribute_detail['name'] = '';
      $attribute_detailname = '';
      if (!empty($attribute)) {
        foreach ($attributeArr as $key => $value) {
          $product_feature_attributes = ProductAttributes::where('id', $value)->first();
          if (!empty($product_feature_attributes)) {
            
            $name = getAttributeName($product_feature_attributes->attribute);
            if ($product_feature_attributes->price_type == 'Increment') {
              $attribute_detail['amount'] +=$product_feature_attributes->price;
            }elseif ($product_feature_attributes->price_type == 'Decrement') {
              $attribute_detail['amount'] -=$product_feature_attributes->price;
              
            }

              //echo "<pre>";print_r(getAttributeName($product_feature_attributes->attribute));die;
              $attribute_detail['name'] .= $name.' ';

            
          }     
                
        }
      }


      //echo "<pre>";print_r($attribute_detail);die;
        return $attribute_detail;
    
    }*/	
/**
 * distory user cart session
 *
 *
 * @return \Illuminate\Http\Response
 */
	public function distoryUserCartSession(){
		
		Session::forget('cart_count');
		Session::forget('shoppingstep');
	}
	
	public function thankyou_cart(){
		
		$lastOrder = Order::with('user')->where('user_id','=', Auth::user()->id)->orderBy('id','desc')->first();
		//echo '<pre>lastOrder'; print_r($lastOrder); die;
		if(!empty($lastOrder)){
			 return view('front.orders.thankyou',["lastOrder" => $lastOrder]);
		}else{
			 return Redirect::to('/');
		}
		
	}
	
	
/**
 * function for getting random number for order number
 *
 * @param string $size
 *
 * @return \Illuminate\Http\Response
 */
	public function random_num($size) {
  	$alpha_key = '';
  	$keys = range('A', 'Z');

  	for ($i = 0; $i < 2; $i++) {
  		$alpha_key .= $keys[array_rand($keys)];
  	}

  	$length = $size - 2;

  	$key = '';
  	$keys = range(0, 9);

  	for ($i = 0; $i < $length; $i++) {
  		$key .= $keys[array_rand($keys)];
  	}

  	return $alpha_key . $key;
  }


    public function cancel()
    {
		$errorMsg = '';
		
		$cartIds = array();
		$cart_itemslist = Cart::where('user_id','=', Auth::user()->id)->get();
		if(!empty($cart_itemslist)){
			foreach($cart_itemslist as $cart){
				$cartIds[$cart->id] = $cart->id;
			}
		}
		
		// deleting user cart by cartids
		$this->deleteUserCartByIds($cartIds);
		
		// distory user cart session
		$this->distoryUserCartSession();
		
		return view('front.orders.payment_cancel',["errorMsg" => $errorMsg]);
        
    }
       /**
 * Show the form for creating a new resource.
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function notify()
    {
     echo '<pre>';print_r($_POST);
     echo '<pre>';print_r($request->all());
     echo '<pre>';print_r($request->tx);
     echo '<pre>';print_r($_GET);
     echo '<pre>';print_r($_REQUEST);die;
    
    //return view('admin.products.pay');
        
    }
       /**
 * Show the form for creating a new resource.
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function success(Request $request)
    {

    //echo '<pre>';print_r($_POST);
     echo '<pre>';print_r($request->all());

     echo '<pre>';print_r($_GET);
     echo '<pre>';print_r($_REQUEST);
    die('success');
    //return view('admin.products.pay');
        
    }

}
