<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\PaymentGetway;
use Session;

class PaymentGetwaysController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    	//die($id);
        $blogs = PaymentGetway::find(1);
       

        return view('admin.paymentGetways.edit',["blogs" =>$blogs]);


        
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //echo '<pre>';print_r($_POST);die;
        $blog = PaymentGetway::find(1);

        if ($request->stripe == 1 || $request->cod == 1) {
            
            if ($request->stripe == 1) {
                $blog->secret_id = $request->secret_id;       
                $blog->demo_id = $request->demo_id;       
                $blog->type = $request->type;
                $blog->stripe = ($request->stripe == 1)?1:0; 
            }
            $blog->cod = ($request->cod == 1)?1:0;
        }else{
            Session::flash('error','Please Select one mode.');
            return \Redirect::to('admin/paymentGetways/edit');
        }


             

        if($blog->save()){

            Session::flash('success','PaymentGetway Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }

        return \Redirect::to('admin/');
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
		$blog = PaymentGetway::find($id);    
		
		if($blog->delete()){
        	Session::flash('success','PaymentGetway delete successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/paymentGetways');
    }

}
