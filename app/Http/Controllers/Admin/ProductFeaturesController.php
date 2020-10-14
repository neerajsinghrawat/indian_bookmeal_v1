<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductFeature;
use App\Models\ProductFeatureAttribute;
use Session;
class ProductFeaturesController extends Controller
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
        $testimonials = ProductFeature::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.productFeatures.index',["testimonials" => $testimonials]);
    }

    /**
     * Show all recoreds in table a new resource.
     *
     * @return \Illuminate\Http\Response
    */ 
    public function featuresAttribute($id)
    {
        $productFeaturedata = ProductFeature::find($id);
        //echo '<pre>';print_r($productFeaturedata);die;
        $productFeatureAttributes = ProductFeatureAttribute::where('product_feature_id','=', $id)->OrderBy('created_at','DESC')->paginate(10);
        return view('admin.productFeatures.featuresAttribute',["productFeaturedata" => $productFeaturedata,"productFeatureAttributes" => $productFeatureAttributes]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */     
     public function add()
    {
        
        return view('admin.productFeatures.add');
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */     
     public function addfeaturesAttribute($id)
    {
        $productFeaturedata = ProductFeature::find($id);
        return view('admin.productFeatures.addfeaturesAttribute',["productFeaturedata" => $productFeaturedata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createfeaturesAttribute(Request $request)
    {
        //echo '<pre>';print_r($request->all());die;
        $productFeatureAttribute = new ProductFeatureAttribute;

        $productFeatureAttribute->name = trim($request->name);
        $productFeatureAttribute->product_feature_id = $request->product_feature_id;
        $productFeatureAttribute->status = ($request->status == 'on')?1:0;

        if($productFeatureAttribute->save()){
            Session::flash('success','ProductFeatureAttribute Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/productFeatures/features_attribute/'.$request->product_feature_id);
    }    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //echo '<pre>';print_r($request->all());die;
        $testimonial = new ProductFeature;

        $testimonial->value = trim($request->name);
        $testimonial->status = ($request->status == 'on')?1:0;

        if($testimonial->save()){
            Session::flash('success','ProductFeature Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/productFeatures');
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
        $testimonials = ProductFeature::find($id);
       
        return view('admin.productFeatures.edit',["testimonials" => $testimonials]);
       
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editfeaturesAttribute($pf_id,$id)
    {
        //die($id);
        $productFeaturedata = ProductFeature::find($pf_id);
        $productFeatureAttributes = ProductFeatureAttribute::find($id);
       
        return view('admin.productFeatures.editfeaturesAttribute',["productFeaturedata" => $productFeaturedata,"productFeatureAttributes" => $productFeatureAttributes]);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatefeaturesAttribute(Request $request, $pf_id, $id)
    {

        //die($request->file('image'));
        $productFeatureAttribute = ProductFeatureAttribute::find($id);
        
        $productFeatureAttribute->name = trim($request->name);
        $productFeatureAttribute->product_feature_id = $request->product_feature_id;
        $productFeatureAttribute->status = ($request->status == 'on')?1:0;

        if($productFeatureAttribute->save()){
            Session::flash('success','ProductFeatureAttribute Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/productFeatures/features_attribute/'.$pf_id);
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

        //die($request->file('image'));
        $testimonial = ProductFeature::find($id);
        
       	$testimonial->value = trim($request->name);
        $testimonial->status = ($request->status == 'on')?1:0;

        if($testimonial->save()){
            Session::flash('success','ProductFeature Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/productFeatures');
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
        $testimonial = ProductFeature::find($id);    
        
        if($testimonial->delete()){
            Session::flash('success','ProductFeature Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/productFeatures');
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletefeaturesAttribute($pf_id,$id)
    {
        //die('sdfdsf');
        $testimonial = ProductFeatureAttribute::find($id);    
        
        if($testimonial->delete()){
            Session::flash('success','ProductFeatureAttribute Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/productFeatures/features_attribute/'.$pf_id);
    }
}
