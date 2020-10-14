<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OpenHour;
use Session;

class OpenHoursController extends Controller
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
    	$openHours = OpenHour::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.openHours.index',["openHours" => $openHours]);
    }
    

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */     
     public function add()
    {
       
     return view('admin.openHours.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        
        $start_time= (isset($request->start_time)?date('H:i:s', strtotime($request->start_time)):'');
                        
        $end_time= (isset($request->end_time)?date('H:i:s', strtotime($request->end_time)):'');

        $openHour = new OpenHour;

        $openHour->title = trim($request->title);
        $openHour->type = $request->type;
        $openHour->start_time = $start_time;
        $openHour->end_time =  $end_time;    
        $openHour->text = (isset($request->text)?$request->text:'');
        $openHour->sort_number = $request->sort_number;
       
        $openHour->status = ($request->status == 'on')?1:0;         

        if($openHour->save()){

        	Session::flash('success','Open Hour Save successfully');
        }else{
        	Session::flash('error','Please try again.');
        }

        return \Redirect::to('admin/openHours');
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
        $openHours = OpenHour::find($id);
       

        return view('admin.openHours.edit',["openHours" =>$openHours]);


        
       
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
        $start_time= (isset($request->start_time)?date('H:i:s', strtotime($request->start_time)):'');
                        
        $end_time= (isset($request->end_time)?date('H:i:s', strtotime($request->end_time)):'');

        $openHour = OpenHour::find($id);
		
        $openHour->title = trim($request->title);
        $openHour->type = $request->type;
        $openHour->start_time = $start_time;
        $openHour->end_time =  $end_time;  
        $openHour->text = (isset($request->text)?$request->text:'');
        $openHour->sort_number = $request->sort_number;
        
        $openHour->status = ($request->status == 'on')?1:0;         

        if($openHour->save()){

            Session::flash('success','Open Hour Update successfully');
        }else{
            Session::flash('error','Please try again.');
        }

        return \Redirect::to('admin/openHours');
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
		$openHour = OpenHour::find($id);    
		
		if($openHour->delete()){
        	Session::flash('success','Open Hour delete successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/openHours');
    }

}
