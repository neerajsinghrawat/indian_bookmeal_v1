<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Session;
class TestimonialsController extends Controller
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
        $testimonials = Testimonial::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.testimonials.index',["testimonials" => $testimonials]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */     
     public function add()
    {
        
        return view('admin.testimonials.add');
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
        $testimonial = new Testimonial;

        $testimonial->name = trim($request->name);
		
        $testimonial->designation = trim($request->designation);
        $testimonial->description = $request->description;
        $testimonial->status = ($request->status == 'on')?1:0;
        $testimonial->show_inhome_page = ($request->show_inhome_page == 'on')?1:0;

        if($testimonial->save()){
            Session::flash('success','Testimonial Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/testimonials');
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
        $testimonials = Testimonial::find($id);
       
        return view('admin.testimonials.edit',["testimonials" => $testimonials]);
       
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
        $testimonial = Testimonial::find($id);
        
       	$testimonial->name = trim($request->name);
		
        $testimonial->designation = trim($request->designation);
        $testimonial->description = $request->description;
        $testimonial->status = ($request->status == 'on')?1:0;
        $testimonial->show_inhome_page = ($request->show_inhome_page == 'on')?1:0;
        
        if($testimonial->save()){
            Session::flash('success','Testimonial Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/testimonials');
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
        $testimonial = Testimonial::find($id);    
        
        if($testimonial->delete()){
            Session::flash('success','Testimonial Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        return \Redirect::to('admin/testimonials');
    }
}
