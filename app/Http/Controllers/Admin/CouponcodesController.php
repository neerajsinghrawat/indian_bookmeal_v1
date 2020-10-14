<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Couponcode;
use App\Models\Group;
use App\Models\Product;
use App\Models\Category;
use App\Models\CouponItem;
use Session;

class CouponcodesController extends Controller
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
    	$couponcodes = Couponcode::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.couponcodes.index',["couponcodes" => $couponcodes]);
    }
    

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */     
     public function add()
    {
        $group_list = Group::where('status','=', 1)->get();
        $product_list = Product::select('id','name')->where('status','=', 1)->get();

    	$category_list = Category::where('parent_id','!=', 0)->where('status','=', 1)->with('parent')->get(); 
        //echo '<pre>product_list'; print_R($category_list); die;
        return view('admin.couponcodes.add',["group_list" => $group_list,"product_list" => $product_list,"category_list" => $category_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $couponitem_arr = array();
        //$couponitem_productarr = array();
    	$this->validate($request, [
            'code' => 'unique:couponcodes',            
        ]);

        

        $couponcode = new Couponcode;

        $couponcode->name = trim($request->name);
        $couponcode->description = $request->description;
        $couponcode->start_date = date('Y-m-d', strtotime($request->start_date));
        $couponcode->coupon_count = $request->coupon_count;
        $couponcode->apply_for = $request->apply_for;

        $couponcode->code = trim($request->code);
        $couponcode->use_code_times = trim($request->use_code_times);
        $couponcode->group_id = $request->group_id;
        $couponcode->amount = $request->amount;

        $couponcode->expire_date = date('Y-m-d', strtotime($request->expire_date));
        $couponcode->coupon_type = $request->coupon_type;
        $couponcode->status = ($request->status == 'on')?1:0; 

        if($couponcode->apply_for == 'category'){
            
            $couponitem_arr['data'] = explode(',', $request->category_id);
            $couponitem_arr['type'] = 'category';

        }
        if($couponcode->apply_for == 'product') {
            
            $couponitem_arr['data'] = explode(',', $request->product_id);
            $couponitem_arr['type'] = 'product';
        }

        

        if($couponcode->save()){
            if (isset($couponitem_arr) && !empty($couponitem_arr['data'])) {

                foreach ($couponitem_arr['data'] as $key => $value) {

                    $couponItem = new CouponItem;

                    $couponItem->apply_for = $couponitem_arr['type'];
                    if ($couponitem_arr['type'] == 'product') {
                        $couponItem->product_id = $value;
                    }elseif($couponitem_arr['type'] == 'category') {
                        $couponItem->category_id = $value;
                    }
                    $couponItem->couponcode_id = $couponcode->id;
                    $couponItem->save();
                    
                }

            }

        	Session::flash('success','Coupon code Create successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
		//$this->queueActivationKeyNotification($user);
        return \Redirect::to('admin/couponcodes');
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
        $couponcodes = Couponcode::find($id);
       	$group_list = Group::where('status','=', 1)->get();
        $product_list = Product::select('id','name')->where('status','=', 1)->get();

        $category_list = Category::where('parent_id','!=', 0)->where('status','=', 1)->with('parent')->get(); 


        $coupon_Item = CouponItem::where('couponcode_id','=', $id)->get()->toArray();
        $idmerge_arr = array();
        $category_value = '';
        $product_value = '';
        
        foreach ($coupon_Item as $key => $coupoItem) {
           // echo '<pre>';print_r($coupoItem);die;
           if ($coupoItem['apply_for'] == 'category') {
               $idmerge_arr['category'][] = $coupoItem['category_id'];
               $category_value = implode(',',$idmerge_arr['category']);
           }

           if ($coupoItem['apply_for'] == 'product') {
               $idmerge_arr['product'][] = $coupoItem['product_id'];
               $product_value = implode(',',$idmerge_arr['product']);

           }
        }
        

        return view('admin.couponcodes.edit',["group_list" => $group_list,"couponcodes" =>$couponcodes,"product_list" =>$product_list,"category_list" =>$category_list,"category_value" =>$category_value,"product_value" =>$product_value]);


        
       
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
            'code' => 'unique:couponcodes,code,'.$id,            
        ]);

        $couponcode = Couponcode::find($id);
		
        $couponcode->name = trim($request->name);
        $couponcode->description = $request->description;
        $couponcode->start_date = date('Y-m-d', strtotime($request->start_date));
        $couponcode->coupon_count = $request->coupon_count;
        $couponcode->apply_for = $request->apply_for;
        
        $couponcode->amount = $request->amount;


        $couponcode->code = trim($request->code);
        $couponcode->use_code_times = trim($request->use_code_times);
        $couponcode->group_id = $request->group_id;

        $couponcode->expire_date = date('Y-m-d', strtotime($request->expire_date));
        $couponcode->coupon_type = $request->coupon_type;
        $couponcode->status = ($request->status == 'on')?1:0;    

        //echo '<pre>';print_r($_POST);die;
        if($couponcode->apply_for == 'category'){
            
            $couponitem_arr['data'] = explode(',', $request->category_id);
            $couponitem_arr['type'] = 'category';

        }
        if($couponcode->apply_for == 'product') {
            
            $couponitem_arr['data'] = explode(',', $request->product_id);
            $couponitem_arr['type'] = 'product';
        }

        if($couponcode->save()){

            

            CouponItem::where('couponcode_id',$id)->delete();
            //echo '<pre>';print_r($coupoItem);die;


            if (isset($couponitem_arr) && !empty($couponitem_arr['data'])) {
            foreach ($couponitem_arr['data'] as $key => $value) {

                $couponItem = new CouponItem;

                $couponItem->apply_for = $couponitem_arr['type'];
                if ($couponitem_arr['type'] == 'product') {
                    $couponItem->product_id = $value;
                }elseif($couponitem_arr['type'] == 'category') {
                    $couponItem->category_id = $value;
                }
                $couponItem->couponcode_id = $couponcode->id;
                $couponItem->save();
                
            }
        }
        	Session::flash('success','Coupon code update successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
		

        return \Redirect::to('admin/couponcodes');
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
		$couponcode = Couponcode::find($id);    
		
		if($couponcode->delete()){
        	Session::flash('success','Coupon code delete successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/couponcodes');
    }

 /**
 * getAjaxcodeunique find unique value.
 * 
 * @return \Illuminate\Http\Response
 */
    public function getAjaxcodeunique(Request $request)
    {
	    $response = 0;
	    $couponcodes = Couponcode::where('id','!=', $request->codeid)->where('code','=', $request->code)->get();
	   if (isset($couponcodes[0]) && !empty($couponcodes)){
	   		$response = 1;
	   	}
	    return $response;

    }
}
