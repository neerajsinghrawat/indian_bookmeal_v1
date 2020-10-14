<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShippingTax;
use DB;
use Session;

class ShippingTaxesController extends Controller
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
        
        $shippingtaxes = ShippingTax::find(1);
       
        return view('admin.shippingTaxes.edit',["shippingtaxes" => $shippingtaxes]);
       
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
      
        $shippingTax = ShippingTax::find($id);

            $shippingTax->shipping_title = $request->shipping_title;
            $shippingTax->shipping_type = $request->shipping_type;
            $shippingTax->shipping_amount = $request->shipping_amount;
            $shippingTax->shipping_desc = $request->shipping_desc;
            $shippingTax->tax_text = $request->tax_text;
            $shippingTax->tax_percent = $request->tax_percent;

	
        if($shippingTax->save()){
                Session::flash('success','Shipping & Tax Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }


        return \Redirect::to('admin');
    }



}
