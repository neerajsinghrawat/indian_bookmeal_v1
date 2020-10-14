<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\RegistersUsers;
use App\Traits\ActivationKeyTrait;
use Intervention\Image\ImageManagerStatic as Image;
use Session;

class StaffsController extends Controller
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
    	$staffs = Staff::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.staffs.index',["staffs" => $staffs]);
    }

 /**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */  
     public function add()
    {
      
        return view('admin.staffs.add');
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

            'first_name'               => 'required',
            'last_name'               => 'required',
            'phone'            => 'required|unique:staffs',
            'email'                 => 'required|email|unique:staffs',
            'password'              => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password',
        ],[
                'first_name.required'     => 'Name is required',
                'last_name.required'     => 'Name is required',
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

        $staff = new Staff;
        
            $staff->first_name = trim($request->first_name);
            $staff->last_name = trim($request->last_name);
            $staff->status = ($request->status == 'on')?1:0;
            //$franchise->slug = trim($request->slug);
            $staff->email = trim($request->email);
            $staff->phone = trim($request->phone);
            $staff->mobile = trim($request->mobile);
            $staff->address = trim($request->address);
    		$staff->password = bcrypt($request->password);	
            $staff->description = $request->description;

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/staff');
            $image->move($destinationPath, $name);        
            $staff->image =  $name;
               
            $fullPath = public_path('image/staff/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/staff/200x200/'.$name));                      
            }
        } 
                   
            if($staff->save()){
            Session::flash('success','Staff Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
            //$this->queueActivationKeyNotification($franchise);
        return \Redirect::to('admin/staffs');
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
        
        $staffs = Staff::find($id);
        return view('admin.staffs.edit',["staffs" => $staffs]);
       
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
        $staff = Staff::find($id);

        $this->validate($request, [

            'first_name'               => 'required',
            'last_name'               => 'required',
            'phone'            => 'required|unique:staffs,phone,'.$id,
            'email'                 => 'required|email|unique:staffs,email,'.$id,
            /*'password'              => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password',*/
        ],[
                'first_name.required'     => 'Name is required',
                'last_name.required'     => 'Name is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                /*'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',*/
            ]);
        
           $staff->first_name = trim($request->first_name);
            $staff->last_name = trim($request->last_name);
            $staff->status = ($request->status == 'on')?1:0;
            $staff->mobile = trim($request->mobile);
            $staff->email = trim($request->email);
            $staff->phone = trim($request->phone);
            $staff->address = trim($request->address);
            $staff->description = $request->description;
            //$staff->password = bcrypt($request->password);  

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/staff');
            $image->move($destinationPath, $name);        
            $staff->image =  $name;
               
            $fullPath = public_path('image/staff/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/staff/200x200/'.$name));                      
            }
        } 
                   
            if($staff->save()){
            Session::flash('success','Staff Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
            //$this->queueActivationKeyNotification($franchise);
        return \Redirect::to('admin/staffs');
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
