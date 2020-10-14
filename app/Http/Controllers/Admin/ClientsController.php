<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Client;
use Session;

class ClientsController extends Controller
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
    	$clients = Client::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.clients.index',["clients" => $clients]);
    }
    

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */     
     public function add()
    {
       
     return view('admin.clients.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        

        $client = new Client;

        $client->title = trim($request->title);
        $client->url = trim($request->url);       
        $client->featured = ($request->featured == 'on')?1:0; 
        $client->status = ($request->status == 'on')?1:0; 

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/client');
            $image->move($destinationPath, $name);        
            $client->image =  $name;
               
            $fullPath = public_path('image/client/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/client/200x200/'.$name));                      
            }
        }        

        if($client->save()){

        	Session::flash('success','Client Save successfully');
        }else{
        	Session::flash('error','Please try again.');
        }

        return \Redirect::to('admin/clients');
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
        $clients = Client::find($id);
       

        return view('admin.clients.edit',["clients" =>$clients]);


        
       
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
        $client = Client::find($id);
		
        $client->title = trim($request->title);
        $client->url = trim($request->url);       
        $client->featured = ($request->featured == 'on')?1:0; 
        $client->status = ($request->status == 'on')?1:0; 

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/client');
            $image->move($destinationPath, $name);        
            $client->image =  $name;
               
            $fullPath = public_path('image/client/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/client/200x200/'.$name));                      
            }
        }        

        if($client->save()){

            Session::flash('success','Client Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }

        return \Redirect::to('admin/clients');
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
		$client = Client::find($id);    
		
		if($client->delete()){
        	Session::flash('success','Client delete successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/clients');
    }

}
