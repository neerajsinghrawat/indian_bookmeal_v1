<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Session;

class EmailTemplatesController extends Controller
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
         //die(Helper::$common->getproductsFeaturevalue());
    	$emailTemplates = EmailTemplate::OrderBy('created_at','ASC')->paginate(10);
        return view('admin.emailTemplates.index',["emailTemplates" => $emailTemplates])->with('title', 'EmailTemplates');
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */ 

    public function add()
    {
    	
        return view('admin.emailTemplates.add');
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create(Request $request)
    {
         //echo '<pre>';print_r($start_time.'==>'.$end_time);die;
        $emailTemplate = new EmailTemplate;

        $emailTemplate->name = trim($request->name);
        $emailTemplate->subject = trim($request->subject);
        $emailTemplate->status = ($request->status == 'on')?1:0;
       	$emailTemplate->type = $request->type;	
       	$emailTemplate->message = $request->message;	
                
		if($emailTemplate->save()){
            Session::flash('success','Email Template Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/emailTemplates');
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
        $emailTemplates = EmailTemplate::find($id);

        return view('admin.emailTemplates.edit',["emailTemplates" => $emailTemplates]);
       
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
        $emailTemplate = EmailTemplate::find($id);
		
        $emailTemplate->name = trim($request->name);
        $emailTemplate->subject = trim($request->subject);
        $emailTemplate->status = ($request->status == 'on')?1:0;
       	$emailTemplate->type = $request->type;	
       	$emailTemplate->message = $request->message;	
                
		if($emailTemplate->save()){
            Session::flash('success','Email Template Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/emailTemplates');
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
		$emailTemplate = EmailTemplate::find($id);    
		
		if($emailTemplate->delete()){
            Session::flash('success','Email Template Delete successfully');
        }else{
            Session::flash('error','Please try again.');
        }
		
        return \Redirect::to('admin/emailTemplates');
    }
}
