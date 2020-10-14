<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Country;
use App\Models\ProductImage;
use App\Models\Feature;
use App\Models\FeatureValue;
use App\Models\FeatureGroup;
use App\Models\ProductFeature;
use App\Models\OpeningTime;
use DB;
use Session;

class SettingsController extends Controller
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
        die('asfadsfads');
    
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    	//die($id);
        
        $settings = Setting::find(1);

        $openingTimes = OpeningTime::where('setting_id','=',$settings->id)->get()->toArray();
        $openingTimesArr = array();
        foreach ($openingTimes as $key => $value) {
            $openingTimesArr[$value['day_name']] = $value;
        }
        //echo '<pre>';print_r($openingTimesArr);die;
       
        return view('admin.settings.edit',["settings" => $settings,"openingTimesArr" => $openingTimesArr,]);
       
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
       //echo '<pre>';print_r($_POST);die;
        $setting = Setting::find($id);
		
            $setting->site_title = trim($request->site_title);
            $setting->email = trim($request->email);
            $setting->email2 = $request->email2;
            $setting->address = trim($request->address);
            $setting->mobile = $request->mobile;
            $setting->phone = $request->phone;
            $setting->about = $request->about;
            $setting->google_analytic = $request->google_analytic;
            $setting->facebook = $request->facebook;
            $setting->twitter = $request->twitter;
            $setting->g_plus = $request->g_plus;           
            $setting->youtube_link = $request->youtube_link;
           // $setting->timing = isset($request->timing) ? $request->timing : '';
             $setting->total_table = !empty($request->total_table) ? $request->total_table : 0;
             $setting->total_men = !empty($request->total_men) ? $request->total_men : 0;
             $setting->men_in_table = !empty($request->men_in_table) ? $request->men_in_table : 0;
             $setting->table_reservation_phone_number = $request->table_reservation_phone_number;
             $setting->is_takeaway = ($request->is_takeaway == 'on')?1:0;
             $setting->is_delivery = ($request->is_delivery == 'on')?1:0;
             $setting->is_book_table_applied = ($request->is_book_table_applied == 'on')?1:0;

        if (!empty($request->file('logo'))) {
        $image = $request->file('logo');
        $unq_id = uniqid();   
       // echo $unq_id;die;
        $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image/setting');
        $image->move($destinationPath, $name);
        //$this->save();
        $setting->logo =  $name;
        }
	
        if($setting->save()){

                if (!empty($request->openingTime)) {
                    $this->openingTime_delete($id);
                    foreach ($request->openingTime as $key => $productFeature_add) {
                          
                        $OpeningTime = new OpeningTime;

                        $OpeningTime->setting_id = $setting->id;
                        $OpeningTime->start_time = date('H:i:s', strtotime($productFeature_add['start_time']));
                        $OpeningTime->end_time = date('H:i:s', strtotime($productFeature_add['end_time']));
                        $OpeningTime->day_name = $productFeature_add['day_name'];

                        if (isset($productFeature_add['is_close']) && $productFeature_add['is_close'] == 1) {
                            $OpeningTime->is_close = 1;
                        }
                        

                        $OpeningTime->save(); 
                            
                           

                    }

                }
                Session::flash('success','Setting Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }


        return \Redirect::to('admin');
    }

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function openingTime_delete($id)
    {
        $openingTimes = OpeningTime::where('setting_id','=',$id)->get();

        foreach ($openingTimes as $key => $openingTime) {
            $productItem = OpeningTime::find($openingTime->id);
            $productItem->delete();
        }

    }
}
