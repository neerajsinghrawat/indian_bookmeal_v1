<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Blog;
use Session;

class BlogsController extends Controller
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
    	$blogs = Blog::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.blogs.index',["blogs" => $blogs]);
    }
    

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */     
     public function add()
    {
       
     return view('admin.blogs.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        

        $blog = new Blog;

        $blog->name = trim($request->name);
        $blog->slug = trim($request->slug);       
        $blog->description = $request->description;       
        $blog->meta_title = $request->meta_title;       
        $blog->meta_keyword = $request->meta_keyword;       
        $blog->meta_description = $request->meta_description; 
        $blog->featured = ($request->featured == 'on')?1:0; 
        $blog->status = ($request->status == 'on')?1:0; 

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/blog');
            $image->move($destinationPath, $name);        
            $blog->image =  $name;
               
            $fullPath = public_path('image/blog/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/blog/200x200/'.$name));                      
            }
        }        

        if($blog->save()){

        	Session::flash('success','Blog Save successfully');
        }else{
        	Session::flash('error','Please try again.');
        }

        return \Redirect::to('admin/blogs');
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
        $blogs = Blog::find($id);
       

        return view('admin.blogs.edit',["blogs" =>$blogs]);


        
       
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
        $blog = Blog::find($id);
		
        $blog->name = trim($request->name);
        $blog->slug = trim($request->slug);       
        $blog->description = $request->description;       
        $blog->meta_title = $request->meta_title;       
        $blog->meta_keyword = $request->meta_keyword;       
        $blog->meta_description = $request->meta_description; 
        $blog->featured = ($request->featured == 'on')?1:0; 
        $blog->status = ($request->status == 'on')?1:0; 

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/blog');
            $image->move($destinationPath, $name);        
            $blog->image =  $name;
               
            $fullPath = public_path('image/blog/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/blog/200x200/'.$name));                      
            }
        }        

        if($blog->save()){

            Session::flash('success','Blog Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }

        return \Redirect::to('admin/blogs');
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
		$blog = Blog::find($id);    
		
		if($blog->delete()){
        	Session::flash('success','Blog delete successfully');
        }else{
        	Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/blogs');
    }

}
