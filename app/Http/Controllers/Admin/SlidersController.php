<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
class SlidersController extends Controller
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
        $sliders = Slider::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.sliders.index',["sliders" => $sliders]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */     
     public function add()
    {
        
        return view('admin.sliders.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //echo '<pre>';print_r($request->all());die;
        $slider = new Slider;

        $slider->title = trim($request->title);
		
        $slider->sub_title = trim($request->sub_title);
        $slider->description = trim($request->description);
        $slider->button_text = trim($request->button_text);
        $slider->button_url = trim($request->button_url);
        $slider->status = ($request->status == 'on')?1:0;

        $image = $request->file('image');

            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/slider');
            $image->move($destinationPath, $name);        
            $slider->image =  $name;
               
            $fullPath = public_path('image/slider/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(100, 100)->save(public_path('/image/slider/100x100/'.$name));                      
            }        
                
        if($slider->save()){
            Session::flash('success','Slider Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/sliders');
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
        $sliders = Slider::find($id);
       
        return view('admin.sliders.edit',["sliders" => $sliders]);
       
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
        $slider = Slider::find($id);
        
        $slider->title = trim($request->title);
        $slider->sub_title = trim($request->sub_title);
        $slider->description = trim($request->description);
		$slider->button_text = trim($request->button_text);
        $slider->button_url = trim($request->button_url);
        $slider->status = ($request->status == 'on')?1:0;


        if (!empty($request->file('image'))) {
            $image = $request->file('image');

            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/slider');
            $image->move($destinationPath, $name);        
            $slider->image =  $name;
               
            $fullPath = public_path('image/slider/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(100, 100)->save(public_path('/image/slider/100x100/'.$name));                      
            }        
        }      
        if($slider->save()){
            Session::flash('success','Slider Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/sliders');
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
        $slider = Slider::find($id);    
        
        if($slider->delete()){
            Session::flash('success','Slider Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/sliders');
    }
}
