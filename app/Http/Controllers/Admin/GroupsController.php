<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Session;
class GroupsController extends Controller
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
    	$groups = Group::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.groups.index',["groups" => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
     public function add()
    {
    	
        return view('admin.groups.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $group = new Group;

        $group->name = trim($request->name);
        $group->status = ($request->status == 'on')?1:0;        
                
		if($group->save()){
            Session::flash('success','Group Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/groups');
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
        $groups = Group::find($id);
       
        return view('admin.groups.edit',["groups" => $groups]);
       
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
        $group = Group::find($id);
		
        $group->name = trim($request->name);
        $group->status = ($request->status == 'on')?1:0;

		  if($group->save()){
            Session::flash('success','Group Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
		
        return \Redirect::to('admin/groups');
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
