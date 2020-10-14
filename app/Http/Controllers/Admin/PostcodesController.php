<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Postcode;
use App\Models\Franchise;
use App\Http\Controllers\Controller;
use Session;
class PostcodesController extends Controller
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
    	$postcodes = Postcode::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.postcodes.index',["postcodes" => $postcodes]);
    }

 /**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */  
     public function add()
    {
      	$franchise_list = Franchise::where('status','=', 1)->get();
        return view('admin.postcodes.add',["franchise_list" => $franchise_list]);
    }


/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create(Request $request)
    {
       
        //echo '<pre>';print_r($_POST);die;
        $postcode = new Postcode;
        
            $postcode->post_code = trim($request->post_code);
            $postcode->status = ($request->status == 'on')?1:0;

            /*if (isset($request->franchise_id) && !empty($request->franchise_id)) {

                $postcode->franchise_id = $request->franchise_id;
                 $postcode->main = 0;

            }else{

                $postcode->franchise_id = 0;
            }            */
    				
                  
            if($postcode->save()){

                Session::flash('success','Postcode Save successfully');

            }else{
                Session::flash('error','Please try again.');
            }

        return \Redirect::to('admin/postcodes');
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
        
        $postcodes = Postcode::find($id);
        $franchise_list = Franchise::where('status','=', 1)->get();
        return view('admin.postcodes.edit',["postcodes" => $postcodes,"franchise_list" =>$franchise_list]);
       
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
        $postcode = Postcode::find($id);
		
	       $postcode->post_code = trim($request->post_code);
	       $postcode->status = ($request->status == 'on')?1:0;

	       /*if (isset($request->franchise_id) && !empty($request->franchise_id)) {

                $postcode->franchise_id = $request->franchise_id;
                $postcode->main = 0;

            }else{

                $postcode->franchise_id = 0;
                $postcode->main = 1;
            }*/
    				
            if($postcode->save()){

                Session::flash('success','Postcode Update successfully');

            }else{
                Session::flash('error','Please try again.');
            } 
		
        return \Redirect::to('admin/postcodes');
    }


 /**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function destroy(Request $request, $id)
    {
        //die('sdfdsf');
        $postcode = Postcode::find($id);    
        
        if($postcode->delete()){
            Session::flash('success','Postcode Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        // hard delete
        //DB::delete('delete from w_coin_index where coin_index_id = ?',[$id]);
        return \Redirect::to('admin/postcodes');
    }
}
