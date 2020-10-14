<?php

namespace App\Http\Controllers\Front;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\NewsLetter;
use App\Models\Product;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Client;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\WebsiteVisitor;
use App\Models\TableReservation;
use App\Models\OpeningTime;
use App\Models\EmailTemplate;

use App\Models\Postcode;


use Session;
use DB;

use Illuminate\Support\Facades\Cookie;
use Auth;
use Redirect;

class PagesController extends Controller
{

  
    public function getHome()
    {
        //echo Cookie::get('cart_set_id');die;
        //print_r(Session::getId());die;
       //echo '<pre>';print_r($_SERVER['REMOTE_ADDR']);die('dmnhk');
        $productsArr = array();

        $getip = WebsiteVisitor::where('ip_address','=',$_SERVER['REMOTE_ADDR'])->count();

        if ($getip < 1) {
        $websiteVisitor = new WebsiteVisitor;

        $websiteVisitor->ip_address = $_SERVER['REMOTE_ADDR'];

        $websiteVisitor->save();
        }

        $category_list = Category::where('parent_id','=',0)->where('status','=', 1)->with('children')->get();

        $ourmenu_category_list = Category::where('parent_id','!=',0)->where('status','=', 1)->get();
        //$ourmenu_category_list = array();
        
        /*if(!empty($ourmenu_category_listData)){
            foreach($ourmenu_category_listData as $cat){
                $cat_name = strtolower(trim($cat->name));
                $cat_name = str_replace(' ', '-', $cat_name);
                $ourmenu_category_list[$cat_name] = $cat;
            }
        }*/
        
    	$ourmenu_category_productData = Category::where('parent_id','!=',0)->where('status','=', 1)->with(['product' => function($test) {
                        $test->where('status', '=', 1);
                    }])->get();
    	 if(!empty($ourmenu_category_productData)){
    	     $i = 1;
            foreach($ourmenu_category_productData as $cat){
                $cat_name = strtolower(trim($cat->name));
                $cat_name = str_replace(' ', '-', $cat_name);
                    $ourmenu_category_product[$cat_name]['cat_detail']['start_time'] = $cat->start_time; 
                    $ourmenu_category_product[$cat_name]['cat_detail']['end_time'] = $cat->end_time; 
                if(isset($cat->product) && count($cat->product) > 0){
                    foreach($cat->product as $product){
                       $ourmenu_category_product[$cat_name]['product'][] = $product; 
                    }
                    
                }
               
            $i++; }
        }

    	$sliders = Slider::where('status','=', 1)->get();
    	$testimonials = Testimonial::where('status','=', 1)->where('show_inhome_page','=', 1)->limit(2)->get();


        $bestsellerproducts = Product::with('categorysub')->where('category_id','=', 7)->where('status','=', 1)->where('is_popular','=', 1)->get()->toArray();

 

          foreach ($bestsellerproducts as $key => $value) {
              $productsArr[$value['categorysub']['name'].'~'.$value['categorysub']['bannerImage']][] = $value ;
          }  

        //$testimonials = Testimonial::OrderBy('created_at','DESC')->paginate(10);


        //echo '<pre>';print_r($productsArr);die;
    	//$setting = Setting::where('status','=', 1)->first();
 
        return view('front.pages.home',["category_list" => $category_list,"sliders" => $sliders,"testimonials" => $testimonials,"productsArr" => $productsArr,"ourmenu_category_list" => $ourmenu_category_list,"ourmenu_category_list" => $ourmenu_category_list,"ourmenu_category_product" => $ourmenu_category_product]);
 
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create_newsletter(Request $request)
    {
        //echo '<pre>';print_r($request->email);die;
        $newsLetter = new NewsLetter;

        $newsLetter->email = $request->email;

        if($newsLetter->save()){
            Session::flash('success_h1','NewsLetter');
            Session::flash('success','Thankyou for connect with us.');
        }else{
			Session::flash('error_h1','NewsLetter');
            Session::flash('error','Please try again.');
        }       
        return \Redirect::to('/');
    }


/**
 * Display the about_us by page.
 *
 * @return \Illuminate\Http\Response
 */
    public function about_us()
    {

        $pageabout_us = Page::where('status','=', 1)->where('slug','=', 'about-us')->first();
        $product_count = Product::where('status','=', 1)->count();
        $order_count = Order::where('payment_status','=', 'approved')->count();
        $productreview_count = ProductReview::count();
        $websitevisitor_count = WebsiteVisitor::count();
        $testimonials = Testimonial::where('status','=', 1)->get();
        
        return view('front.pages.about_us',["pageabout_us" => $pageabout_us,"product_count" => $product_count,"testimonials" => $testimonials,"order_count" => $order_count,"productreview_count" => $productreview_count,"websitevisitor_count" => $websitevisitor_count]);
    }

/**
 * Display the contact_us by page.
 * save contact_us records 
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function contact_us()
    {

        $setting = Setting::first();
        return view('front.pages.contact_us',["setting" => $setting]);
    }

/**
 * Display the contact_us by page.
 * save contact_us records 
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function contactus_save(Request $request)
    {
        $contact = new Contact;

        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->message = $request->message;

        if($contact->save()){
            Session::flash('success_h1','Contact us');           
            Session::flash('success','Contact Save successfully');
            }else{
            Session::flash('error_h1','Contact us');
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('/contact-us');
    }

/**
 * Display the page detail.
 * 
 * @return \Illuminate\Http\Response
 */
    public function page_detail($slug)
    {
       if(!empty($slug)) {
            
            $pageabout_us = Page::where('status','=', 1)->where('slug','=', $slug)->first();
            if(!empty($pageabout_us)) {

            }else{
                 return abort(404);
            }

       }else{
         return abort(404);
       }

       return view('front.pages.page_detail',["pageabout_us" => $pageabout_us]);
    }

/**
 * Display the client by page.
 *
 * @return \Illuminate\Http\Response
 */
    public function client_list()
    {

        $client_list = Client::where('status','=', 1)->get();
        
        return view('front.pages.client_list',["client_list" => $client_list]);
    }
/**
 * Display the client by page.
 *
 * @return \Illuminate\Http\Response
 */
    public function table_reservation()
    {

        $setting = Setting::with('openingTime')->first();
        $people_count = range(1, $setting->total_men);
        //echo '<pre>';print_r($people_count);die;
        return view('front.pages.table_reservation',["setting" => $setting,"people_count" => $people_count]);
    }

/**
 * Remove the specified resource from storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function save_table_reservation(Request $request)
    {
       $result = 0;
       $msg = '';
       $setting = Setting::first();
        //die('kmjkjjghj');
       
       if (!empty($request->reservation_date) && !empty($request->people_count) && !empty($request->reservation_time) && !empty($request->name) &&  !empty($request->email) &&  !empty($request->phone)) {

            $time = date('H:i:s',strtotime($request->reservation_time));
            $date = date('Y-m-d',strtotime($request->reservation_date));
            $currenttime = date('H:i:s');
            $currentDate = date('Y-m-d');
            //echo '<pre>';print_r($currenttime);die;
            $day = strtolower(date('l',strtotime($request->reservation_date)));
            if (($date == $currentDate && $time > $currenttime) || ($date > $currentDate)) {
                $openingTimes = OpeningTime::where('setting_id','=',$setting->id)->where('day_name','=',$day)->first();
                if (!empty($openingTimes) && $openingTimes->is_close == 0) {

                    if ($openingTimes->start_time <= $time && $openingTimes->end_time > $time) { 

                        $tableReservations = TableReservation::where('reservation_time','=', $time)->where('reservation_date','=', $date)->get()->toArray();
                        if (!empty($tableReservations)) {
                            $total_men = 0;
                            foreach ($tableReservations as $key => $value) {
                                $total_men += $value['people_count'];
                                
                            }
                            
                            if ($setting->total_men != $total_men) {

                                $remaining = $setting->total_men - $total_men;

                                if ($request->people_count <= $remaining) {
                                    $tableReservation = new TableReservation;

                                    $tableReservation->reservation_date = $date;
                                    $tableReservation->people_count = $request->people_count;       
                                    $tableReservation->reservation_time = $time;       
                                    $tableReservation->name = $request->name;       
                                    $tableReservation->email = $request->email;       
                                    $tableReservation->phone = $request->phone; 
                                            

                                    if($tableReservation->save()){
                                        //print_r($tableReservation->id);die;
                                        $msg = 'Your Table Book successfully';
                                        $result = 1;
                                        $this->sendmailtocustomer($tableReservation->id,$request);
                                    }
                                }else{

                                        $msg = 'Only '.$remaining .' People Space on selected time';
                                        $result = 0;

                                }
                                

                            }else{
                                        $msg = 'All Table reserved this selected time';
                                        $result = 0;
                            }
                        }else{
                                $tableReservation = new TableReservation;

                                $tableReservation->reservation_date = $date;
                                $tableReservation->people_count = $request->people_count;       
                                $tableReservation->reservation_time = $time;       
                                $tableReservation->name = $request->name;       
                                $tableReservation->email = $request->email;       
                                $tableReservation->phone = $request->phone; 
                                        

                                if($tableReservation->save()){
                                    //print_r($tableReservation->id);die;
                                    $msg = 'Your Table Book successfully';
                                    $result = 1;
                                    $this->sendmailtocustomer($tableReservation->id,$request);

                                }
                        }
                    }else{
                        $msg = 'This time not set in Detail';
                        $result = 0;

                    }


                }else{

                        $msg = 'This day is week off please cahnge date';
                        $result = 0;

                }

            }else{

                        $msg = 'Please select greater than current time ';
                        $result = 0;
            }
          
       }else{
        $msg = 'Please Fill all * fields';
       }
        
        

        return response()->json(['success'=> $result,'msg'=>$msg]);
        die;
    }

/**
 * delete user cart by cart ids
 *
 * @param string $order_number
 *
 * @return \Illuminate\Http\Response
 */
    public function sendmailtocustomer($reservation_id,$request){
        //echo '<pre>';print_r($request->name);die;
        $extraContentArr = array();
        $post_data = array();
        if(!empty($reservation_id)){
            
            //$orderDetail = Order::with('order_items','user')->where('user_id','=', Auth::user()->id)->where('order_number','=',$order_number)->orderBy('id','desc')->first();
            $tableReservations = TableReservation::where('id','=', $reservation_id)->first(); 

            $post_data['username'] = $request->name;
            $post_data['email'] = $request->email;


            if(!empty($tableReservations)){
                    
                            $htmlcomment = '';


                                $htmlcomment .= '<table width="100%" border= "1px">
                                            <thead>
                                              <tr>
                                                <th style = "font-weight:bold;" > Name</th>
                                                <th style = "font-weight:bold;" > Phone No</th>
                                                <th  style = "font-weight:bold;"> Email</th>
                                                <th  style = "font-weight:bold;"> Table Book date</th>
                                                <th  style = "font-weight:bold;"> Time</th>
                                                <th  style = "font-weight:bold;"> People Count</th>



                                              </tr>
                                            </thead><tbody>';
                                     
                                           $htmlcomment.='<tr>
                                                      <td > '. $tableReservations->name .'</td> 
                                                      <td > '. $tableReservations->phone .'</td> 
                                                      <td > '. $tableReservations->email .'</td> 
                                                      <td > '. (date('d-m-Y',strtotime($tableReservations->reservation_date))) .'</td> 
                                                      <td > '. (date('h:i A',strtotime($tableReservations->reservation_time))).'</td> 
                                                      <td > '. $tableReservations->people_count .'</td> 
                                                                                                               
                                                    </tr>';                                             

                                                    
                                                 

                                $htmlcomment .= '</tbody></table>';

                            
                            $extraContentArr['Tablesummary'] =  $htmlcomment ;

                            $emailTemplate = new EmailTemplate;
                            $emailTemplate->sendUserEmail($post_data,5,$extraContentArr);

            }
        }   
    }         

    public function add_timedropdown(Request $request)
    {   
        $timearray=array(); /*'12:00 AM','01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM'*/
        //echo '<pre>';print_r($timearray);die;
        $dayarr = array(1=>'monday',2=>'tuesday',3=>'wednesday',4=>'thursday',5=>'friday',6=>'saturday',0=>'sunday');
         $day = $dayarr[$request->day];
        if($request->isMethod('post')) {  
            $setting = OpeningTime::where('day_name','=', $day)->first();
            $time1 = strtotime($setting->start_time);
            $time2 = strtotime($setting->end_time);
            $diff = $time2 - $time1;
            $hours = date('H', $diff);

            for ($i=0; $i <= $hours; $i++) { 
                 $timearray[] =date('h:i A',strtotime($setting->start_time));

                 $setting->start_time =date('H:i:s',strtotime('+1 hour',strtotime($setting->start_time)));
            }
            
            //print_r($timearray);die;
        }

        echo json_encode($timearray); exit();


    }

/**
 * search postcode
 *
 * @param \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\Response
 */
  public function check_postalcode(Request $request)
  { 
    $msg = '';
    $result = 1;
      if ($request->isMethod('post')) {  
        //echo '<pre>';print_r(expression)      
        $postcode_list = Postcode::where('post_code','=',$request->post_code)->where('status','=',1)->first();
        $postcode = array();
        if (!empty($postcode_list)) {          
          $postcode['code_status'] = 1;
          $postcode['postcode'] = $request->post_code;
          if (Session::has('postcode')) {
            Session::forget('postcode');
          }
          Session::put('postcode', $postcode);

          Session::flash('success_h1','Postcode');
          Session::flash('success','Food delivery able to your Postcode');          
        }else {

          $postcode['code_status'] = 0;
          $postcode['postcode'] = $request->post_code;
          if (Session::has('postcode')) {
            Session::forget('postcode');
          }
          $msg = 'We do not provide delivery in '. $request->post_code;
          $result = 0;
        }
    }
        return response()->json(['success'=> $result,'msg'=>$msg]);die;
  }

}
