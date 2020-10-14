<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Feature;
use App\Models\FeatureValue;
use App\Models\FeatureGroup;

class FeatureGroupsController extends Controller
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
    	$featureGroup = FeatureGroup::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.featureGroups.index',["featureGroup" => $featureGroup]);
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */  
     public function add()
    {
        $category_list = Category::where('status','=', 1)->get();
        return view('admin.featureGroups.add',["category_list" => $category_list]);
    }


/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create(Request $request)
    {
        $featureGroup = new FeatureGroup;
        
            $featureGroup->name = trim($request->name);
            $featureGroup->status = ($request->status == 'on')?1:0;
            $featureGroup->category_id = $request->category_id;
            $featureGroup->save();       

        return \Redirect::to('admin/featureGroups');
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
        
        $feature_groups = FeatureGroup::find($id);
        $category_list = Category::where('status','=', 1)->get();
        //$country_list = Country::where('status','=', 1)->get();
        return view('admin.featureGroups.edit',["feature_groups" => $feature_groups,"category_list" => $category_list]);
       
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
      
        $featureGroup = FeatureGroup::find($id);
        
            $featureGroup->name = trim($request->name);
            $featureGroup->status = ($request->status == 'on')?1:0;
            $featureGroup->category_id = $request->category_id;
            $featureGroup->save();       

        return \Redirect::to('admin/featureGroups');
    }

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function add_feature_value(Request $request, $id)
    {
      
        $featurevalue = FeatureValue::where('feature_id','=', $id)->get();
        return view('admin.features.add_feature_value',["featurevalue" => $featurevalue,"id" => $id]);
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function add_value(Request $request)
    {
        //echo '<pre>';print_r($_POST);die();

       foreach ($request->value as $key => $value) {
        $feature_value = new FeatureValue;

        $feature_value->value =  $value;
        $feature_value->feature_id =  $request->feature_id;

        $feature_value->save();
        }
        
        return \Redirect::to('admin/features');
    }
/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function delete_value(Request $request)
    {
        //die($request);
       // echo '<pre>';print_r($_POST);die();
        $result = 0;
        $featurevalue = FeatureValue::where('id','=', $request->value_id)->first();   
        $feature_value = FeatureValue::find($featurevalue->id);  
        
        if($feature_value->delete()){
            $result = 1;
        }

        return response()->json(['success'=> $result]);
    }

}
