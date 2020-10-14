<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Popup;
use App\Models\Category;
use Session;
class PopupsController extends Controller
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
    	$popups = Popup::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.popups.index',["popups" => $popups]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */     
     public function add()
    {
    	$categories = array();

    	$category_list = Category::where('status','=', 1)->where('parent_id','=', 0)->get()->toArray();

/*    	foreach ($category_list as $key => $value) {

    		$sub_category = Category::where('status','=', 1)->where('parent_id','=',$value['id'])->get()->toArray();

    		//$categories[]['name'] = $value['name'];
    		$categories[$value['name']] = $sub_category;
    		foreach ($sub_category as $key2 => $values) {
    			
    			
    		}
    		
    		
    		
    	}*/
    	
    	//echo '<pre>';print_r($categories);die;

        return view('admin.popups.add',["category_list" => $category_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	
        $popup = new Popup;

        $popup->image_url = trim($request->image_url);
        $popup->type = trim($request->type);
        $popup->type = trim($request->type);
        $popup->category_id = (isset($request->category_id))?serialize($request->category_id):'';
        
        $popup->status = ($request->status == 'on')?1:0;        
                
		if($popup->save()){
            Session::flash('success','Popup Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/popups');
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
        $popups = Popup::find($id);
       	$categories = array();

       	$popups->category_id = unserialize($popups->category_id);

    	$category_list = Category::where('status','=', 1)->where('parent_id','=', 0)->get()->toArray();
        return view('admin.popups.edit',["popups" => $popups,"category_list"=>$category_list]);
       
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
        $popup = Popup::find($id);
		
        $popup->image_url = trim($request->image_url);
        $popup->type = trim($request->type);
        $popup->type = trim($request->type);
        $popup->category_id = (isset($request->category_id))?serialize($request->category_id):'';
//echo '<pre>';print_r($popup->category_id);die;
        $popup->status = ($request->status == 'on')?1:0;        
                

		  if($popup->save()){
            Session::flash('success','Popup Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
		
        return \Redirect::to('admin/popups');
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
		$group = Group::find($id);    
		
		if($group->delete()){
            Session::flash('success','Group Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/groups');
    }
}
