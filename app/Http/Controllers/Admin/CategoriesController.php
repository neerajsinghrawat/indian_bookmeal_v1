<?php

namespace App\Http\Controllers\Admin;
 
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Helper;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
class CategoriesController extends Controller
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
    	$category_list = Category::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.categories.index',["category_list" => $category_list])->with('title', 'Test');
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */ 

      public function add()
    {
    	$category_list = Category::where('parent_id','=',0)->where('status','=', 1)->get();
        return view('admin.categories.add',["category_list" => $category_list]);
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
		/*$this->validate($request, [

            'image' => 'required',

        ]);*/
        $start_time= date('H:i:s', strtotime($request->start_time));
        $end_time= date('H:i:s', strtotime($request->end_time));

        //echo '<pre>';print_r($start_time.'==>'.$end_time);die;
        $unqid= mt_rand(10000000, 99999999);
        $category = new Category;

        $category->name = trim($request->name);
        $category->status = ($request->status == 'on')?1:0;
        $category->slug = trim($request->slug.'-'.$unqid);
        $category->parent_id = 7;
        $category->start_time = $start_time;
        $category->end_time = $end_time;
        $category->meta_title = $request->meta_title;
        $category->meta_keyword = $request->meta_keyword;
        $category->meta_description = $request->meta_description;
       // $category->featured = ($request->featured == 'on')?1:0;;
      /*  
      	$image = $request->file('image');
        $unq_id = uniqid();   
       // echo $unq_id;die;
        $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image/category');
        $image->move($destinationPath, $name);
        //$this->save();

        $category->image =  $name;*/
				
          
            if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/category');
            $image->move($destinationPath, $name);        
            $category->image =  $name;
               
            $fullPath = public_path('image/category/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/category/200x200/'.$name));     

                //Image::make($destinationPath.'/'.$name)->resize(830, 170)->save(public_path('/image/category/830x170/'.$name));  
                Image::make($destinationPath.'/'.$name)->resize(600, 450)->save(public_path('/image/category/480x420/'.$name));                     
            }
            } 
            if (!empty($request->file('bannerImage'))) {
            $image = $request->file('bannerImage');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/category');
            $image->move($destinationPath, $name);        
            $category->bannerImage =  $name;
               
            $fullPath = public_path('image/category/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/category/200x200/'.$name));     

                Image::make($destinationPath.'/'.$name)->resize(830, 200)->save(public_path('/image/category/830x170/'.$name));  
                //Image::make($destinationPath.'/'.$name)->resize(480, 420)->save(public_path('/image/category/480x420/'.$name));                     
            }
            }                
		if($category->save()){
            Session::flash('success','Category Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/categories');
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
        $categories = Category::find($id);
        $category_list = Category::where('parent_id','=', 0)->where('id','!=', $id)->where('status','=', 1)->get();
        return view('admin.categories.edit',["categories" => $categories,"category_list" => $category_list]);
       
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
        $start_time= date('H:i:s', strtotime($request->start_time));
        $end_time= date('H:i:s', strtotime($request->end_time));

    	$unqid= mt_rand(10000000, 99999999);
        $category = Category::find($id);
		
        $category->name = trim($request->name);
        $category->status = ($request->status == 'on')?1:0;
        $category->slug = trim($request->slug);
         $category->start_time = $start_time;
        $category->end_time = $end_time;
        $category->parent_id = 7;
        $category->meta_title = $request->meta_title;
        $category->meta_keyword = $request->meta_keyword;
        $category->meta_description = $request->meta_description;
       /* $category->featured = ($request->featured == 'on')?1:0;;

        if (!empty($request->file('image'))) {
        $image = $request->file('image');
        $unq_id = uniqid();   
       // echo $unq_id;die;
        $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image/category');
        $image->move($destinationPath, $name);
        //$this->save();

        $category->image =  $name;
        }*/
        if (!empty($request->file('image'))) {

            $image = $request->file('image');
            $unq_id = uniqid(); 
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/category');
            $image->move($destinationPath, $name);
            
            $category->image =  $name;

            $fullPath = public_path('image/category/'.$name);
                                
              $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

                if(!empty($fullPath)){

                    $source = \Tinify\fromFile($fullPath);
                    $source->toFile($fullPath);
                    Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/category/200x200/'.$name));
                   // Image::make($destinationPath.'/'.$name)->resize(830, 170)->save(public_path('/image/category/830x170/'.$name));  
                    Image::make($destinationPath.'/'.$name)->resize(480, 420)->save(public_path('/image/category/480x420/'.$name)); 
                }

        }	

        if (!empty($request->file('bannerImage'))) {
            $image = $request->file('bannerImage');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/category');
            $image->move($destinationPath, $name);        
            $category->bannerImage =  $name;
               
            $fullPath = public_path('image/category/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/category/200x200/'.$name));     

                Image::make($destinationPath.'/'.$name)->resize(830, 200)->save(public_path('/image/category/830x170/'.$name));  
                //Image::make($destinationPath.'/'.$name)->resize(480, 420)->save(public_path('/image/category/480x420/'.$name));                     
            }
        }
		if($category->save()){
            Session::flash('success','Category Update successfully');
        }else{
            Session::flash('error','Please try again.');
        }
		
        return \Redirect::to('admin/categories');
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
		$category = Category::find($id);    
		
		if($category->delete()){
            Session::flash('success','Category Delete successfully');
        }else{
            Session::flash('error','Please try again.');
        }
		
        return \Redirect::to('admin/categories');
    }
    
}