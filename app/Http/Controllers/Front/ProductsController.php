<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Country;
use App\Models\Postcode;
use App\Models\Cart;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductTag;
use App\Models\UserAddress;
use App\Models\ShippingTax;
use App\Models\Couponcode;
use App\Models\Order;
use App\Models\ProductFeature;
use App\Models\ProductFeatureAttribute;
use App\Models\ProductAttribute;
use App\Models\PaymentGetway;
use App\Models\Setting;
use Illuminate\Support\Facades\Cookie;
use Session;
use Auth;
use DB;

class ProductsController extends Controller
{

/**
 * Display the products by category.
 *
 * @param string $slug
 *
 * @return \Illuminate\Http\Response
 */

  public function index($slug = null)
  {
    //die('kjkjh');
      $products = array();
      $subCategories = array();
      $subCatArr = array();
      $productsArr = array();
      $current_time = strtotime(date('H:i:s a'));
      
      $categories_first = Category::where('slug','=', $slug)->first();
      //echo '<pre>';print_r($categories_first);die;

      $categories = Category::where('parent_id','=', $categories_first->id)->get();

      if (!empty($categories)){

        $products = Product::with('categorysub')->where('category_id','=', $categories_first->id)->where('status','=',1)->get()->toArray();
      }   

      foreach ($products as $key => $value) {
          $productsArr[$value['categorysub']['name'].'~'.$value['categorysub']['bannerImage'].'~'.$value['categorysub']['slug']][] = $value ;
      }
    //echo '<pre>';print_r($productsArr);die;
      return view('front.products.index',['categories' =>$categories,'products' =>$productsArr,]);
  }

/**
 * Display the products by sub category.
 *
 * @param string $slug
 *
 * @return \Illuminate\Http\Response
 */  
  public function sub_categoryindex(Request $request ,$slug = null)
  {
    $conditions[] = array('status','=',1);
    $orconditions = array();
    $column = 'created_at';
    $type = 'DESC';
    $limit = 25;

    $products = array();
    $productrates = array();
    $avg_rating = 0;
    $totalRating = 0;
    $tagIds = array();
    $productIds = array();
    $product_Ids = array();
    $tag_list = array();

    $categories = Category::where('slug','=', $slug)->first();
    $tagists = ProductTag::get();

    foreach ($tagists as $key => $tagist) {
      $tag_list[strtolower($tagist->tag)] = strtolower($tagist->tag);
    }
    
    if (!empty($categories)){

      $conditions[] = array('sub_category_id','=', $categories->id);
      $productrating = Product::select ('sub_category_id','id','name')->with('productReview')->where('sub_category_id','=', $categories->id)->where('status','=',1)->get()->toArray();

      foreach ($productrating as $key => $value) {
        $avg_rating = 0;
        $totalRating = 0;
        if (!empty($value['product_review'])) {
          foreach ($value['product_review'] as $key => $proreview) {
            $totalRating += $proreview['rating'];
          }
          if(($totalRating > 0) && (count($value['product_review']) > 0)){
            $avg_rating = $totalRating / count($value['product_review']);
          }
        }
        $productrates[$value['id']] = round($avg_rating);
      }


      $column = 'created_at';
      $type = 'DESC';
      $is_search = 0;  

      if (isset($_GET['data'])) {
       
          if (isset($_GET['data']['sort']) && !empty($_GET['data']['sort'])) {

            if ($_GET['data']['sort'] == 'low_to_high') {
                $column = 'price';
                $type = 'ASC';
            } elseif($_GET['data']['sort'] == 'high_to_low') {
                $column = 'price';
                $type = 'DESC';
            }else{
                $column = 'created_at';
                $type = 'DESC';
            }
          }

          if (isset($_GET['data']['show_recored']) && !empty($_GET['data']['show_recored'])) {
            $limit = $_GET['data']['show_recored'];
          }            

          if (isset($_GET['data']['product_name']) && !empty($_GET['data']['product_name'])) {
            $is_search = 1;
            $conditions[] = array('name','LIKE', '%'.$_GET['data']['product_name'].'%');
          }              

          if (isset($_GET['data']['tag']) && !empty($_GET['data']['tag'])) {
            $is_search = 1;
            $tagitem_arr['data'] = explode(',', $_GET['data']['tag']);

            foreach ($tagitem_arr['data'] as $key => $value) {
              $tagIds[] = $value;
            }

            $tagproduct_id = ProductTag::whereIn('tag',$tagIds)->get();
            foreach ($tagproduct_id as $key => $tagproductid) {
              $product_Ids[$tagproductid['product_id']] = $tagproductid['product_id'];
            }
            $orconditions = (!empty($product_Ids))?$product_Ids:null;
          }            

          if (isset($_GET['data']['rating']) && ($_GET['data']['rating'] >= 0 )) {

            $is_search = 1;
            foreach ($productrates as $key => $productrate) {
              if ($_GET['data']['rating'] == $productrate) {
                $productIds[$key] = $key;
              }              
            }
            $orconditions = (!empty($productIds))?$productIds:null;
          }
        }

        if($is_search == 1){
          if(!empty($orconditions)){
           $products = Product::where($conditions)->whereIn('id',$orconditions)->OrderBy($column, $type)->limit($limit)->get(); 
          }else{
            $products = '';
          }
        }else{
          $products = Product::where($conditions)->OrderBy($column, $type)->limit($limit)->get();
        }

    }   
    
    return view('front.products.sub_categoryindex',["products" => $products,'categories' =>$categories,'tag_list' =>$tag_list]);
  }


/**
 * Display products details.
 *
 * @param string $slug
 *
 * @return \Illuminate\Http\Response
 */
  public function detail($slug = null)
  {

    $product_details = Product::with('category','productItem','productAttribute')->where('slug','=', $slug)->where('status','=',1)->first();
		$productImages = array();
		if(!empty($product_details)){
			$iImgPath = asset('image/no_product_image.jpg');
      if(isset($product_details->image) && !empty($product_details->image)){
        $iImgPath = asset('image/product/400x330/'.$product_details->image);
      }
			$productImages[] = $iImgPath;
			
			if(!empty($product_details->product_images) && count($product_details->product_images) > 0){
				foreach($product_details->product_images as $product_img){
					$productImages[] = asset('image/product/400x330/'.$product_img->image);
				}
			}
		}

    $related_products  = Product::where('sub_category_id','=',$product_details->sub_category_id)->where('id','!=',$product_details->id)->where('status','=',1)->get();

    /*$productFeatureItems = ProductFeatureItems::with('productFeature')->where('product_id','=', $product_details->id)->get()->toArray();	*/

    //echo "<pre>";print_r($productFeatureItems);die;

    $productReviews = ProductReview::with('user')->where('product_id','=',$product_details->id)->get();
		
    return view('front.products.detail',["product_details" => $product_details,'productReviews'=>$productReviews,'related_products'=>$related_products,'productImages'=>$productImages]);
  }

/**
 * search postcode
 *
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function search_postalcode(Request $request)
  { 
	  if ($request->isMethod('post')) {        
        $postcode_list = Postcode::where('post_code','=',$request->code)->first();
        $postcode = array();
        if (!empty($postcode_list)) {          
          $postcode['code'] = 'Current Post Code : '.$request->code;
          $postcode['code_status'] = 1;
          $postcode['button_text'] = 'Search new Postcode';
          $postcode['postcode'] = $request->code;
          if (Session::has('postcode')) {
            Session::forget('postcode');
          }
          Session::put('postcode', $postcode);

          Session::flash('success_h1','Postcode');
          Session::flash('success','Food delivery able to your Postcode');          
        }else {
          Session::flash('error_h1','Postcode');
          Session::flash('error','Something went wrong. Please try again');
        }
    }
    return redirect('/');
  }

/**
 * find post code and save session
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function ajax_search_postalcode(Request $request)
  {
    $result = array();
    if ($request->isMethod('post')) {          
      $postcode_list = Postcode::where('post_code','=',$request->code)->first();
     
      $postcode = array();
      if (!empty($postcode_list)) {        
        $postcode['code'] = 'Post Code : '.$request->code;
        $postcode['code_status'] = 1;
          if (Session::has('postcode')) {
            Session::forget('postcode');
          }
          Session::put('postcode', $postcode);
        $result = $postcode;
      }
    }
    return response()->json($result);
  }

/**
 * autocomplete_postcode
 *
 * ajax
 * 
 * @return \Illuminate\Http\Response
 */
  public function autocomplete_postcode()
  { 
    $codes =array();
    $names = array();
    if(isset($_GET['term']) && !empty($_GET['term'])){
      $term = $_GET['term'];
      $postcode_list = Postcode::where('post_code','LIKE',$term.'%')->get();
         
      if (isset($postcode_list[0]) && !empty($postcode_list)) {
               foreach ($postcode_list as $key => $value) {
                   /*$codes['id'] = $value->id;
                   $codes['label'] = $value->post_code;*/
                   $names[] = array("id"=>$value->id,"label"=>$value->post_code);
               }

      

      }
      echo json_encode($names); exit();
    }
  }

/**
 * add_to_cart
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function add_to_cart(Request $request)
  {         
    $result['cart_count'] = 0;
    $result['response'] = 0;
    $oldqty = 0;
    //echo '<pre>';print_r($_POST);die;
    if(Auth::check()){
      if ($request->isMethod('post')) {

        $set_id = new Cart;
        $qty = isset($request->productqty)?$request->productqty:1;
        $products = Product::where('status','=', 1)->where('id','=', $request->productid)->first();
        $cart_list = Cart::where('product_id','=',$request->productid)->first();

        if (!empty($cart_list)) {
          $set_id = Cart::find($cart_list->id);
          $oldqty = $cart_list->qty;
        }

        if (Session::has('shoppingstep')) {
          Session::forget('shoppingstep');
        }

        if(!empty($products)){
            $cart = $set_id;
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $request->productid;
            $cart->qty = $qty+$oldqty;       
            
            $cart->save();

            $cart_count = Cart::where('user_id','=', Auth::user()->id)->count();
            $result['cart_count'] = $cart_count;
            $result['response'] = 1;

            if (Session::has('cart_count')) {
                Session::forget('cart_count');
            }
            Session::put('cart_count', $cart_count);
        }        
      }
    }else{

    }
    return response()->json($result);
  }

  /**
 * product_detail
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function product_detail(Request $request)
  {         
    $html ='';
    //echo '<pre>';print_r($_POST);die;
    /*if(Auth::check()){*/
      if ($request->isMethod('post')) {

        $product_details = Product::with('productAttribute')->where('status','=', 1)->where('id','=', $request->productid)->first();

        if(!empty($product_details)){
          $iImgPath = asset('image/no_product_image.jpg');
          if(isset($product_details->image) && !empty($product_details->image)){
            $iImgPath = asset('image/product/400x330/'.$product_details->image);
          }
            $html .='<form action="" id="AddToCART" class="booking-formss">'.csrf_field().'<div class="modal-header modal-header-lg dark bg-dark"><div class="bg-image" ><img src="'.asset('css/front/img/modal-add.jpg').'" alt="" class="bbg-image"></div><h4 class="modal-title">Specify your dish</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button></div>';

            $html .='<div class="modal-product-details"><div class="row align-items-center"><div class="col-md-6"><h6 class="mb-0">'. ucwords($product_details->name) .'</h6><span class="text-muted">'. $product_details->description .'</span></div><div class="col-md-3"><input type="number"  name="quantity" value="1" size="2" min="1" id="input-quantity1" class="form-control qty inputHeight" amount="'.$product_details->price.'"></div><div class="col-md-3 text-lg text-right">'. getSiteCurrencyType().'<span class="totalPrice">'.number_format($product_details->price, 2, '.','') .'</span></div></div></div>
            <div class="modal-body panel-details-container">';
                
            $feature =array();
            $feature = explode(',', $product_details->product_feature);  
            if (!empty($feature[0])) {
              //echo '<pre>';print_r($feature);die;
            foreach ($feature as $key => $value) {                      
                

            $html .='<div class="panel-details"><h5 class="panel-details-title"><label class="custom-control custom-radio"><input name="radio_title_size" type="radio" class="custom-control-input"><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span></label>';
            $feature_name = getFeatureName($value); 
            $html .='<a href="#panelDetails'.$value.'" data-toggle="collapse">'.$feature_name.'</a></h5><div id="panelDetails'.$value.'" class="collapse show"><div class="panel-details-content row">';
            foreach ($product_details->productAttribute as $key => $productitem){ 
            if ($productitem['feature_id'] == $value) { 

            if ($productitem->is_same_price == 1) {
                $productitem->price = 0;
            }
            $attribute_name = getAttributeName($productitem->attribute);
            $tag = '+';
            if ($productitem->price_type == 'Decrement') {
              $tag = '-';
            }
            
            $html .='<div class="col-md-6 form-group"><label class="custom-control custom-radio">
            
             <input name="productAttribute[radio_'.$value.']" type="radio" class="custom-control-input attributes attributes_'.$value.'" value="'.$productitem->id.'" pricetype="'.$productitem->price_type.'" productAmount="'.$product_details->price.'" amount="'.$productitem->price.'" feature="'.$value.'" notEdit="1"><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span> <span class="custom-control-description">'.$attribute_name.'('. $tag.getSiteCurrencyType().number_format($productitem->price, 2, '.','').')</span> </label></div>';
            } } 

            $html .='</div></div></div>';
            } }
               
               
            $html .='<div class="panel-details"><h5 class="panel-details-title"><label class="custom-control custom-radio"><input name="radio_title_size" type="radio" class="custom-control-input"><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span></label><a href="#panelDetailsOther" data-toggle="collapse">Allergen Key</a>
                </h5><div id="panelDetailsOther" class="collapse"><span class="text-muted">'.$product_details->allergen_key.'</span></div>
                </div>
            </div>
            <input type="hidden" class="totalAmount" value="'.$product_details->price.'">
            <input type="hidden" name="product_id" value="'.$product_details->id.'">
            <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg submitCart" data-dismiss="modal"><span>Add to Cart</span></button></form>';



        }


        

               
      }
    /*}else{

    }*/
    return $html;
  }

  /**
 * product_detail
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function product_cart_detail(Request $request)
  {         
    $html ='';
    //echo '<pre>';print_r($_POST);die;
    /*if(Auth::check()){*/
      if ($request->isMethod('post')) {

        $product_details = Product::with('productAttribute')->where('status','=', 1)->where('id','=', $request->productid)->first();
        $product_cartdetails = Cart::where('id','=', $request->cartid)->first();
        //echo "<pre>";print_r($product_cartdetails);die;
        $attributes = $this->getAttributeDetail($product_cartdetails['productItem_ids']);
        //echo "<pre>";print_r($attributes);die;
        if(!empty($product_details)){
          $iImgPath = asset('image/no_product_image.jpg');
          if(isset($product_details->image) && !empty($product_details->image)){
            $iImgPath = asset('image/product/400x330/'.$product_details->image);
          }
            $html .='<form action="" id="updateToCART" class="booking-formss">'.csrf_field().'<div class="modal-header modal-header-lg dark bg-dark"><div class="bg-image" ><img src="'.asset('css/front/img/modal-add.jpg').'" alt="" class="bbg-image"></div><h4 class="modal-title">Specify your dish</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button></div>';

            $html .='<div class="modal-product-details"><div class="row align-items-center"><div class="col-md-6"><h6 class="mb-0">'. ucwords($product_details->name) .'</h6><span class="text-muted">'. $product_details->description .'</span></div><div class="col-md-3"><input type="number"  name="quantity" value="'.$product_cartdetails->qty.'" size="2" min="1" id="input-quantity1" class="form-control qty inputHeight" amount="'.$product_details->price.'"></div><div class="col-md-3 text-lg text-right">'. getSiteCurrencyType().'<span class="totalPrice">'.number_format(($product_details->price + $attributes['amount'])*$product_cartdetails->qty, 2, '.','') .'</span></div></div></div>
            <div class="modal-body panel-details-container">';
                
            $feature =array();
            $feature = explode(',', $product_details->product_feature);  
            if (!empty($feature[0])) {
            foreach ($feature as $key => $value) {                      
                

            $html .='<div class="panel-details"><h5 class="panel-details-title"><label class="custom-control custom-radio"><input name="radio_title_size" type="radio" class="custom-control-input"><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span></label>';
            $feature_name = getFeatureName($value); 
            $html .='<a href="#panelDetails'.$value.'" data-toggle="collapse">'.$feature_name.'</a></h5><div id="panelDetails'.$value.'" class="collapse show"><div class="panel-details-content row">';
            $attributeArr = unserialize($product_cartdetails->productItem_ids);
            foreach ($product_details->productAttribute as $key => $productitem){ 
              if ($productitem['feature_id'] == $value) { 
                $checked= '';
                if (isset($attributeArr['radio_'.$value]) && $attributeArr['radio_'.$value]== $productitem->id) {
                  $checked='checked=checked';
                }
                

              if ($productitem->is_same_price == 1) {
                  $productitem->price = 0;
              }
              $attribute_name = getAttributeName($productitem->attribute);
               $tag = '+';
                if ($productitem->price_type == 'Decrement') {
                  $tag = '-';
                }
              $html .='<div class="col-md-6 form-group"><label class="custom-control custom-radio">              
               <input name="productAttribute[radio_'.$value.']" type="radio" class="custom-control-input attributes attributes_'.$value.'" value="'.$productitem->id.'" pricetype="'.$productitem->price_type.'" productAmount="'.$product_details->price.'" amount="'.$productitem->price.'" '.$checked.' feature="'.$value.'"  notEdit="0"><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span> <span class="custom-control-description">'.$attribute_name.'('. $tag.getSiteCurrencyType().number_format($productitem->price, 2, '.','').')</span> </label></div>';
              } 
            } 

            $html .='</div></div></div>';
            } }
               
               
            $html .='<div class="panel-details"><h5 class="panel-details-title"><label class="custom-control custom-radio"><input name="radio_title_size" type="radio" class="custom-control-input"><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span></label><a href="#panelDetailsOther" data-toggle="collapse">Allergen Key</a>
                </h5><div id="panelDetailsOther" class="collapse"><span class="custom-control-description">'.$product_details->allergen_key.'</span></div>
                </div>
            </div>
            <input type="hidden" class="totalAmount" value="'.$product_details->price.'">
            <input type="hidden" name="product_id" value="'.$product_details->id.'">
            <input type="hidden" name="cart_id" value="'.$product_cartdetails['id'].'">
            <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg submitupdateCart" data-dismiss="modal"><span>Add to Cart</span></button></form>';



        }


        

               
      }
    /*}else{

    }*/
    return $html;
  }



/**
 * product_front_cartdetail
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function product_front_cartdetail(Request $request)
  {         
    $html ='';
    $setting = Setting::first();
    /*if(Auth::check()){*/
      if ($request->isMethod('post')) {

          $current_date = date('Y-m-d');

          if (Auth::check()) {
            $conditions = array(Auth::user()->group_id => Auth::user()->group_id,0 => 0);
            

            $cart_list = Cart::with('product')->where('user_id','=', ((Auth::check())?Auth::user()->id:'1'))->get();
            
            $couponcode_lists = Couponcode::with('couponItem')->where('status','=', 1)->where('start_date','<=', $current_date)->where('expire_date','>=', $current_date)->whereIn('group_id',$conditions)->get();

          }else{

            $conditions = array();
            

            $cart_list = Cart::with('product')->where('cart_set_id','=', Cookie::get('cart_set_id'))->get();
            
            $couponcode_lists = array();

          }

          
          $couponn = array();
          if (!empty($couponcode_lists)) {
                foreach ($cart_list as $key1 => $cart_value) {
                  foreach ($couponcode_lists as $key3 => $couponcodeList) {

                    $appliedCoupon = order::where('coupon_code','=', $couponcodeList->code)->count();

                    $appliedUserCoupon = order::where('coupon_code','=', $couponcodeList->code)->where('user_id','=', ((Auth::check())?Auth::user()->id:'1'))->count();

                    if (($couponcodeList->coupon_count > $appliedCoupon) && ($couponcodeList->use_code_times > $appliedUserCoupon)) {
                      if($couponcodeList->apply_for == "cart"){
                         $couponn[$couponcodeList->id] = $couponcodeList->id; 

                      }else{
                        foreach ($couponcodeList->couponItem as $key4 => $value) {
                         if ($value->apply_for == 'product' && $value->product_id == $cart_value->product_id) {
                          $couponn[$value->couponcode_id] = $value->couponcode_id; 
                         }elseif ($value->apply_for == 'category' && $value->category_id == $cart_value['product']['sub_category_id']){
                          //
                          $couponn[$value->couponcode_id] = $value->couponcode_id; 

                         }
                        }
                      }

                    }else{

                    }
                    
                  }      
              }
          }

   
          $shipping_taxes = ShippingTax::first();

          if (!empty($cart_list[0])) {
            $html .='<table class="table-cart">
               <tbody>';
                    $total = 0;
                            foreach ($cart_list as $key => $cartlistdetail) {  
                                           $iImgPath = asset('image/no_product_image.jpg');
                                          if(isset($cartlistdetail->product->image) && !empty($cartlistdetail->product->image)){
                                            $iImgPath = asset('image/product/200x200/'.$cartlistdetail->product->image);
                                          }
                            $attributes = getAttributeDetail($cartlistdetail->productItem_ids) ;
                          //echo '<pre>';print_r($cartlistdetail);die;            
                            $total += ($cartlistdetail->product->price+$attributes['amount']) * $cartlistdetail['qty'];
                     
            $html .='<tr class="cart_'.$cartlistdetail->id.'">
                        <td class="title">
                            <span class="name">
                                <a href="#productcartDetail" class="productcartDetail" data-toggle="modal" product_id="'.$cartlistdetail->product->id.'" cart_id="'.$cartlistdetail->id.'">'. ucwords($cartlistdetail->product->name).'</a></span><br>
                            <span class="caption text-muted">'.$attributes['name'].'</span>
                        </td>
                        <td class="price">'. getSiteCurrencyType().number_format((($cartlistdetail->product->price+$attributes['amount'])*$cartlistdetail->qty), 2, '.','').'</td>
                        <td class="actions">
                            <a href="#productcartDetail" data-toggle="modal" class="action-icon productcartDetail" product_id="'.$cartlistdetail->product->id.'" cart_id="'.$cartlistdetail->id.'"><i class="ti ti-pencil"></i></a>
                            
                            <span class="action-icon delete_cart delete_'.$cartlistdetail->id.'" cart_id="'. $cartlistdetail->id.'"><i class="ti ti-trash"></i></span>
                        </td>
                    </tr>';
                   
                     }  
            $html .='</tbody>
            </table>
            <div class="cart-summarys">
                <div class="row">
                    <div class="col-7 text-right text-muted">Order total:</div>
                    <div class="col-5"><strong><span class="cart-products-totals">'. getSiteCurrencyType().number_format($total, 2, '.','').'</span></strong></div>
                </div>
                <div class="row">
                    <div class="col-7 text-right text-muted">Tax(';

                     $html .= (!empty($shipping_taxes->tax_percent))?$shipping_taxes->tax_percent:0;
                     $html .='%):</div>
                    <div class="col-5"><strong><span class="tax_total">';
                    

                    $total_amount = $total;
                    if (!empty($shipping_taxes->tax_percent) && $shipping_taxes->tax_percent > 0) {   
                        $total_amount = ($total * $shipping_taxes->tax_percent) / 100 + $total;       
                      $html .=  getSiteCurrencyType().number_format(($total * $shipping_taxes->tax_percent) / 100, 2, '.','');
                    } else{
                     $html .= getSiteCurrencyType().'0';
                    }
            $html .='</span></strong></div>
                </div>';
                if ($setting->is_delivery == 1){
            $html .='<div class="row">
                    <div class="col-7 text-right text-muted">Devliery:</div>
                    <div class="col-5"><strong><span class="cart-deliverys">';

                    if (!empty($shipping_taxes->shipping_amount) && $shipping_taxes->shipping_type == 'Paid' ) {
                         //$total_amount = $shipping_taxes->shipping_amount + $total_amount;
                         //$total_amount = $shipping_taxes->shipping_amount + $total_amount;
                 //$html .= getSiteCurrencyType().$shipping_taxes->shipping_amount;
                 $html .= getSiteCurrencyType().'0';
                     }else{
                 $html .= 'Free';
                     } 

                    if ((Session::has('apply_coupon.amount')) && !empty(Session::get('apply_coupon.amount'))) {
                        if ($total_amount > Session::get('apply_coupon.amount')) {
                            $total_amount = $total_amount - Session::get('apply_coupon.amount');
                        }else{
                            $total_amount = 0;
                        }
                        
                    } 
            $html .='</span></strong></div>
                </div>';
              }

                $html .=' <hr class="hr-sm">
                <div class="row text-lg">
                    <div class="col-7 text-right text-muted">Total:</div>
                    <div class="col-5"><strong><span class="cart-totals">'.getSiteCurrencyType().number_format($total_amount, 2, '.','').'</span></strong></div>
                </div>
            </div>';
          }else{


            $html .='<div class="cart-empty" style="display: block;">
                    <i class="ti ti-shopping-cart"></i>
                    <p>Your cart is empty...</p>
                </div>';

          }
      }
    /*}else{


      $html .='<div class="cart-empty" style="display: block;">
                    <i class="ti ti-shopping-cart"></i>
                    <p>Your cart is empty...</p>
                </div>';     
    }*/

        
    return $html;
  }
  public function getAttributeDetail($attribute='')
  {
          
      $attributeArr = unserialize($attribute);
      $attribute_detail = array();
      $attribute_detail['amount'] = 0;
      $attribute_detail['name'] = '';
      $attribute_detailname = '';

      //echo '<pre>';print_r($attributeArr);die;
      if (!empty($attribute)) {
        
      
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
 * add_to_cart
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function add_to_cart_new(Request $request)
  {         
    $result['cart_count'] = 0;
    $result['response'] = 0;
    $oldqty = 0;
    $cookie_id = Cookie::get('cart_set_id');
    //echo '<pre>';print_r($_POST);die;
    /*if(Auth::check()){*/
      if ($request->isMethod('post')) {

        $set_id = new Cart;
        $qty = isset($request->quantity)?$request->quantity:1;
        $products = Product::where('status','=', 1)->where('id','=', $request->product_id)->first();
       //echo '<pre>';print_r($products);die;
        //$cart_list = Cart::where('product_id','=',$request->productid)->first();
        $cart_list = array();

        if (!empty($cart_list)) {
          $set_id = Cart::find($cart_list->id);
          $oldqty = $cart_list->qty;
        }

        if (Session::has('shoppingstep')) {
          Session::forget('shoppingstep');
        }

        if(!empty($products)){
         //echo '<pre>';print_r($_POST);die;
            $cart = $set_id;
            if(Auth::check()){
              $cart->user_id = Auth::user()->id;
              $cart->cart_set_id = $cookie_id;
            }else{
                            
              $cart->cart_set_id = $cookie_id;

            }
            $cart->product_id = $request->product_id;
            $cart->qty = $qty+$oldqty; 

            if (isset($request->productAttribute) && !empty($request->productAttribute)) {
               $cart->productItem_ids = serialize($request->productAttribute);
               
            }            
            
            $cart->save();

            if(Auth::check()){
              $cart_count = Cart::where('user_id','=', Auth::user()->id)->count();
            }else{
              $cart_count = Cart::where('cart_set_id','=', $cookie_id)->count();
            }

            $result['cart_count'] = $cart_count;
            $result['cart_amount'] = 0;
            $result['response'] = 1;

              $total = 0;
            if(Auth::check()){
              $cart_list = Cart::with('product')->where('user_id','=', ((Auth::check())?Auth::user()->id:'1'))->get();
            }else{
              $cart_list = Cart::with('product')->where('cart_set_id','=', $cookie_id)->get();
              //$cart_count = Cart::where('cart_set_id','=', $cookie_id)->count();
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
              $result['cart_amount'] = $total;
            if (Session::has('cart_count')) {
                Session::forget('cart_count');
            }
            Session::put('cart_count', $cart_count);
            Session::flash('success_h1','Cart');
            Session::flash('success','Cart Add successfully');
        }        
      }
    /*}else{

    }*/
    return response()->json($result);
  }

/**
 * update_to_cart_new
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function update_to_cart_new(Request $request)
  {         
    $result['cart_count'] = 0;
    $result['response'] = 0;
    $oldqty = 0;
    $cookie_id = Cookie::get('cart_set_id');

    //echo '<pre>';print_r($_POST);die;
    /*if(Auth::check()){*/
      if ($request->isMethod('post')) {

        
        $qty = isset($request->quantity)?$request->quantity:1;
        $products = Product::where('status','=', 1)->where('id','=', $request->product_id)->first();
       
        $cart_list = array();

        if (Session::has('shoppingstep')) {
          Session::forget('shoppingstep');
        }

        if(!empty($products)){
         //echo '<pre>';print_r($_POST);die;
            $cart = Cart::find($request->cart_id);
            if(Auth::check()){
              $cart->user_id = Auth::user()->id;
              $cart->cart_set_id = $cookie_id;
            }else{
                            
              $cart->cart_set_id = $cookie_id;

            }
            
            $cart->product_id = $request->product_id;
            $cart->qty = $qty+$oldqty; 

            if (isset($request->productAttribute) && !empty($request->productAttribute)) {
               $cart->productItem_ids = serialize($request->productAttribute);
               
            }            
            
            $cart->save();

            if(Auth::check()){
              $cart_count = Cart::where('user_id','=', Auth::user()->id)->count();
            }else{
              $cart_count = Cart::where('cart_set_id','=', $cookie_id)->count();

            }
            $result['cart_count'] = $cart_count;
            $result['response'] = 1;

            if (Session::has('cart_count')) {
                Session::forget('cart_count');
            }
            Session::put('cart_count', $cart_count);
        }        
      }
    /*}else{

    }*/
    return response()->json($result);
  }


/**
 * Update cart
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function update_cart(Request $request)
  {         
    $result['cart_count'] = 0;
    $result['response'] = 0;
    $result['class'] = '';
    $oldqty = 0;
    $qty = 0;
    $result['total'] = 0;
    $result['qty'] = 0;
    $tax_shipping = ShippingTax::first();
    if(Auth::check()){      
      if ($request->isMethod('post')) {
        if ($request->qty <= 1 && $request->button_type == 'sub') {
          $cart = Cart::find($request->cart_id);    

          if($cart->delete()){
              $result['response'] = 2;
              $result['class'] = "$('.cart_'+$request->cart_id).remove()";
          }
          $cart_count = Cart::with('product')->where('user_id','=', Auth::user()->id)->count();
          $result['cart_count'] = $cart_count;

          if (Session::has('cart_count')) {
              Session::forget('cart_count');
          }
          Session::put('cart_count', $cart_count);

        }else{
          $cart_list = Cart::where('product_id','=',$request->product_id)->where('id','=',$request->cart_id)->first();

          if (!empty($cart_list)) {
            $oldqty = $cart_list->qty;

            if ($request->button_type == 'add') {
              $qty = $oldqty+1;
            } elseif ($request->button_type == 'sub') {
              $qty = $oldqty-1;
            }
            $cart = Cart::find($cart_list->id);
            $cart->qty = $qty;       
            
            if($cart->save()){
              $result['response'] = 1;
            }
            $cart_details = Cart::with('product')->where('user_id','=', Auth::user()->id)->get();
          
            foreach ($cart_details as $key => $value) {
              $result['total'] += ($value->product->price * $value->qty);
            }
            $result['producttotal'] = $qty*$request->product_price;
            

            if (!empty($tax_shipping->shipping_amount) && $tax_shipping->shipping_type == 'Paid') {

             $result['shippingamount'] = $tax_shipping->shipping_amount;

            }else{
              $result['shippingamount'] = 0;
            }

            if (!empty($tax_shipping->tax_percent) && $tax_shipping->tax_percent > 0) {              
                $result['tax_amount'] =  ($result['total'] * $tax_shipping->tax_percent) / 100;
            } else{
              $result['tax_amount'] = 0 ;
            }

            $result['product_id'] = $request->product_id;
            $result['cart_id'] = $request->cart_id;
            $result['qty'] = $qty;
            $result['subMaintotal'] = $result['shippingamount'] + $result['total'] + $result['tax_amount'];


    if (Session::has('apply_coupon')) {
      if (Session::get('apply_coupon.status') == 'percentage') {
         $result['coupon_discount'] = $result['total'] * Session::get('apply_coupon.percentage') / 100 ;
        if ($result['subMaintotal'] > $result['coupon_discount']) {
            $result['Maintotal'] = $result['subMaintotal'] - $result['coupon_discount'];
        }else {
            $result['Maintotal'] = 0;
        }
      }else{
        $result['coupon_discount'] = Session::get('apply_coupon.amount');
        if ($result['subMaintotal'] > Session::get('apply_coupon.amount')) {
            $result['Maintotal'] = $result['subMaintotal'] - Session::get('apply_coupon.amount');
        }else {
            $result['Maintotal'] = 0;
        }
      }
        Session::put('apply_coupon.amount',$result['coupon_discount']); 
    }

          }
        }
      }
    }
    return response()->json($result);
  }
  
/**
 * Delete cart items
 *
 * ajax
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function delete_cart(Request $request)
  {
    $result['cart_count'] = 0;
    $result['response'] = 0;
    if ($request->isMethod('post')) {
      if (!empty($request->cartid)) {
        $cart = Cart::find($request->cartid);
        if($cart->delete()){
            $result['response'] = 1;
        }


            if(Auth::check()){
              $cart_count = Cart::with('product')->where('user_id','=', Auth::user()->id)->count();
              
            }else{
              $cart_count = Cart::with('product')->where('cart_set_id','=', Cookie::get('cart_set_id'))->count();

              //$cart_count = Cart::where('cart_set_id','=', $cookie_id)->count();

            }
        $result['cart_count'] = $cart_count;

        if (Session::has('cart_count')) {
          Session::forget('cart_count');
        }

        Session::put('cart_count', $cart_count);
      }       
    }
    return response()->json($result);
  }

/**
 * Cart items list details.
 *
 * @return \Illuminate\Http\Response
 */
  public function cart_detail()
  {
   // print_r(Session::getId());die;

    $current_date = date('Y-m-d');
    $conditions = array(Auth::user()->group_id => Auth::user()->group_id,0 => 0);

    $cart_list = Cart::with('product')->where('user_id','=', Auth::user()->id)->get();
    $payment_getway = PaymentGetway::first();

    //echo '<pre>';print_r($payment_getway);die;

    
    $couponcode_lists = Couponcode::with('couponItem')->where('status','=', 1)->where('start_date','<=', $current_date)->where('expire_date','>=', $current_date)->whereIn('group_id',$conditions)->get();
    //echo '<pre>couponcode_lists'; print_r($couponcode_lists); die;
    //echo '<pre>couponn'; print_r($cart_list); die;
    $couponn = array();
    foreach ($cart_list as $key1 => $cart_value) {
      //$cart_value->product+$cart_value->productFeatureItem_price;
        foreach ($couponcode_lists as $key3 => $couponcodeList) {
          //echo '<pre>couponcodeList'; print_r($couponcodeList); die;

          $appliedCoupon = order::where('coupon_code','=', $couponcodeList->code)->count();

          $appliedUserCoupon = order::where('coupon_code','=', $couponcodeList->code)->where('user_id','=', Auth::user()->id)->count();

          if (($couponcodeList->coupon_count > $appliedCoupon) && ($couponcodeList->use_code_times > $appliedUserCoupon)) {
            if($couponcodeList->apply_for == "cart"){
               $couponn[$couponcodeList->id] = $couponcodeList->id; 

            }else{
              foreach ($couponcodeList->couponItem as $key4 => $value) {
               if ($value->apply_for == 'product' && $value->product_id == $cart_value->product_id) {
                $couponn[$value->couponcode_id] = $value->couponcode_id; 
               }elseif ($value->apply_for == 'category' && $value->category_id == $cart_value['product']['sub_category_id']){
                //
                $couponn[$value->couponcode_id] = $value->couponcode_id; 

               }
              }
            }

          }else{

          }
          
        }      
    }
//echo '<pre>couponn'; print_r($couponn); die;
    $couponcode_list = Couponcode::whereIn('id',$couponn)->get();

//die('asfsdfd');
    $shipping_taxes = ShippingTax::first();

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

        
    return view('front.products.cart_detail',["cart_list" => $cart_list,"addressesArr" => $addressesArr,"shipping_taxes" => $shipping_taxes,"couponcode_list" => $couponcode_list,"payment_getway" => $payment_getway]);
  }

/**
 * sopping_cart_step.
 * 
 * @param \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
  public function shopping_cart_step(Request $request)
  {
    //die('sfsdffg');
    $steps = array();
    $product_detail = array();

    $cart_itemslist = Cart::with('product')->where('user_id','=', Auth::user()->id)->get();
    $shipping_taxes = ShippingTax::first();
    $total = 0;

    if (!empty($cart_itemslist[0])) {
      foreach ($cart_itemslist as $key => $cartlistdetail) {                 
          $total += ($cartlistdetail->product->price * $cartlistdetail->qty);
      }

      if (!empty($shipping_taxes->shipping_amount) && $shipping_taxes->shipping_type == 'Paid') {

      $shippingamount = $shipping_taxes->shipping_amount;

      }else {

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
      if (isset($request->step) && !empty($request->step)) {
        if($request->step == 'step_1') {
          $steps['step'] = 'step_1';
          $steps['total'] = $total; 
          $steps['tax_amount'] = $tax_amount; 
          $steps['maintotal'] = $maintotal; 
          $steps['coupon_discount'] = $coupon_discount; 
          $steps['shippingamount'] = $shippingamount; 
          $steps['shipping_type'] = $shipping_taxes->shipping_type; 
          $steps['tax_percentage'] = $shipping_taxes->tax_percent; 

          if (Session::has('shoppingstep')) {
            Session::forget('shoppingstep');
          }
          Session::put('shoppingstep', $steps);       
        }

        if($request->step == 'step_2') {
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
          }              
        }
      }
    }

    return redirect('/shopping-cart');
  }


/**
 * sopping_cart_step.
 * 
 * @param \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function shoppingcart_step(Request $request)
    {
    $steps = '';
    //echo '<pre>';print_r($_POST);die;
        if (isset($request->step) && !empty($request->step)) {
            if($request->step == 'step_1') {

                $steps['step'] = 'step_1';

                if (Session::has('shoppingstep')) {
                    Session::forget('shoppingstep');
                }
                Session::put('shoppingstep', $steps);
            }

            if($request->step == 'step_2') {
                $steps['step'] = 'step_2';
                if (Session::has('shoppingstep')) {
                    Session::forget('shoppingstep');
                }
                Session::put('shoppingstep', $steps);                
            }
        }

       return redirect('/shopping-cart');
       
    }



/**
     * Store a newly created product review.
     *
     * @return \Illuminate\Http\Response
     */
	public function save_product_review(){
		$product_slug = '';
		if(isset($_POST['submit']) && $_POST['submit'] == "saveProductReview"){
			$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
			$product_slug = isset($_POST['product_slug']) ? $_POST['product_slug'] : '';
			
			$exitProductReview = ProductReview::where('user_id','=',Auth::user()->id)->where('product_id','=',$product_id)->first();
			
			if(empty($exitProductReview)){
				$review = new ProductReview;
				$review->product_id = $product_id;
				
				$review->review = isset($_POST['review']) ? $_POST['review'] : '';
				$review->rating = isset($_POST['rating']) ? $_POST['rating'] : 0;
				$review->user_id = Auth::user()->id;
				$review->created_at = date('Y-m-d H:i:s');
				$review->updated_at = date('Y-m-d H:i:s');
				
				if($review->save()){
            Session::flash('success_h1','Review');  
					Session::flash('success','Your review has been saved successfully');
				}else{
            Session::flash('error_h1','Review');
					Session::flash('error','Something went wrong. Please try again');
				}
			}else{
        Session::flash('error_h1','Review');
				Session::flash('error','you review already exists');
			}
			
			
			return redirect('/product/'.$product_slug);
			
		}
		
	}
    
/**
 * product_tag_list.
 * 
 *
 * @param string $slug
 *
 * @return \Illuminate\Http\Response
 */
    public function product_tag_list($slug = null)
    {   
        $resultarr = array();
        $product_list = array();

        $product_tags = ProductTag::select('product_id')->where('tag','=',$slug)->distinct('tag')->get();

        if (isset($product_tags) && count($product_tags) > 0) {
            
        foreach ($product_tags as $key => $product_tags) {
           $resultarr[$product_tags['product_id']] = $product_tags['product_id'];
        }

        
        //
        $product_list = Product::whereIn('id',$resultarr)->get();

        }

       // echo '<pre>resultarr'; print_r($resultarr); die;
      
        return view('front.products.product_tag_list',["product_list" => $product_list,"slug" => $slug]);
       
    }



public function ajaxSelectDeliveryAddress(){
    
    $resultArr = array();
    $resultArr['result'] = 0;
    if(isset($_POST['requestType']) && $_POST['requestType'] == "selectAddress"){
        
        $address_id = (isset($_POST['address_id']) && !empty($_POST['address_id'])) ? $_POST['address_id'] : '';
        $address_type = (isset($_POST['address_type']) && !empty($_POST['address_type'])) ? $_POST['address_type'] : '';
        
        if(!empty($address_id)){
            $deliveryAddress =  UserAddress::where('user_id','=',Auth::user()->id)->where('id','=',$address_id)->first();
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
 * set coupon amount in cart items .
 * 
 *
 * @param string $slug
 *
 * @return \Illuminate\Http\Response
 */
    public function apply_coupon_amount($id = null ,$slug = null)
    {   
      //echo $slug;die;
      $applyCouponAmount = array();
      $couponcode = Couponcode::where('id','=',$id)->first();
      if (Session::has('apply_coupon')) {
          Session::forget('apply_coupon');
      }
      if ($couponcode->coupon_type == 'amount' ) {
        $applyCouponAmount['amount'] = $couponcode->amount;
        $applyCouponAmount['message'] = 'Coupon Applied ! '. $couponcode->code;
        $applyCouponAmount['id'] = $couponcode->id;
        $applyCouponAmount['status'] = 'amount';
        $applyCouponAmount['coupon_code'] = $couponcode->code;
        $applyCouponAmount['coupon_type'] = $couponcode->coupon_type;
        $applyCouponAmount['coupon_amount'] = $couponcode->amount;
        
      }else{
        $coupon_amount = $slug * $couponcode->amount / 100 ; 
        $applyCouponAmount['amount'] = $coupon_amount;
        $applyCouponAmount['message'] = 'Coupon Applied ! '. $couponcode->code;
        $applyCouponAmount['id'] = $couponcode->id;
        $applyCouponAmount['percentage'] = $couponcode->amount;
        $applyCouponAmount['status'] = 'percentage';
        $applyCouponAmount['coupon_code'] = $couponcode->code;
        $applyCouponAmount['coupon_type'] = $couponcode->coupon_type;
        $applyCouponAmount['coupon_amount'] = $couponcode->amount;
      }
        Session::put('apply_coupon', $applyCouponAmount);
        Session::flash('success_h1','Coupon');  
        Session::flash('success','Coupon Code applied successfully');
      return redirect('/shopping-cart');
    }

/**
 * back_to_cart .
 * 
 *
 * @return \Illuminate\Http\Response
 */
    public function back_to_cart()
    {   

      if (Session::has('shoppingstep')) {
          Session::forget('shoppingstep');
      }
      return redirect('/shopping-cart');
    }


}
