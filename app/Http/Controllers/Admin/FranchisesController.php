<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Franchise;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\RegistersUsers;
use App\Traits\ActivationKeyTrait;
use Session;
class FranchisesController extends Controller
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


     public function index()
    {
    	$franchises = Franchise::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.franchises.index',["franchises" => $franchises]);
    }

 /**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */  
     public function add()
    {
      
        return view('admin.franchises.add');
    }


/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create(Request $request)
    {
       
        $this->validate($request, [

            'name'               => 'required',
            'phone'            => 'required',
            'email'                 => 'required|email|unique:franchises',
            'password'              => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password',
        ],[
                'name.required'     => 'Name is required',
                //'email.required'     => 'email is required',
                //'phone.max'     => 'Mobile no. maximum length is 10 number',
                //'username.min'           => 'Username needs to have at least 6 characters',
                //'first_name.required'   => 'First Name is required',
                //'last_name.required'    => 'Last Name is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
            ]);

        $franchise = new Franchise;
        
            $franchise->name = trim($request->name);
            $franchise->status = ($request->status == 'on')?1:0;
            //$franchise->slug = trim($request->slug);
            $franchise->email = trim($request->email);
            $franchise->phone = trim($request->phone);
            $franchise->address = trim($request->address);
    		$franchise->password = bcrypt($request->password);	

            //echo '<pre>' ; print_r($franchise);die;    
                   
            if($franchise->save()){
            Session::flash('success','Franchise Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
            //$this->queueActivationKeyNotification($franchise);
        return \Redirect::to('admin/franchises');
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
        
        $franchises = Franchise::find($id);
        return view('admin.franchises.edit',["franchises" => $franchises]);
       
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
       //echo '<pre>';print_r($request->file('image'));die;
        $franchise = Franchise::find($id);
		
        $this->validate($request, [
            'name'               => 'required',
            'phone'            => 'required',
            'email'                 => 'required|email|unique:franchises,email,'.$id,
            /*'password'              => 'min:6|max:20',*/
            'password_confirmation' => 'same:password',
        ],[
                'name.required'     => 'Name is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
            ]);
        
            $franchise->name = trim($request->name);
            $franchise->status = ($request->status == 'on')?1:0;
            //$franchise->slug = trim($request->slug);
            $franchise->email = trim($request->email);
            $franchise->phone = trim($request->phone);
            $franchise->address = trim($request->address);

            if (!empty($request->password)) {
                $franchise->password = bcrypt($request->password);
            }
              

           
		 if($franchise->save()){
            Session::flash('success','Franchise Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
		
        return \Redirect::to('admin/franchises');
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
        $franchise = Franchise::find($id);    
        
         if($franchise->delete()){
            Session::flash('success','Franchise Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        // hard delete
        //DB::delete('delete from w_coin_index where coin_index_id = ?',[$id]);
        return \Redirect::to('admin/franchises');
    }

}
