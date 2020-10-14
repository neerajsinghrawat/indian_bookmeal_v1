<?php

namespace App\Http\Controllers\Admin;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\NewsLetter;
use App\Models\Contact;
use App\Models\TableReservation;
use Session;

class PagesController extends Controller
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
        $pages = Page::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.index',["pages" => $pages]);
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */ 

      public function add()
    {
        $prentpages = Page::where('parent_page','=',0)->where('status','=', 1)->get();
        return view('admin.pages.add',["prentpages" => $prentpages]);
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create(Request $request)
    {
        $header = 0;
        $footer = 0;
        $other = 0;
        foreach ($request->header as $key => $value) {
           if ($value == 'header') {
               $header = 1;
           }elseif ($value == 'footer') {
              $footer = 1;
           }elseif ($value == 'other'){
            $other = 1;
           }
        }

        //echo '<pre>';print_r($_POST);die;
        $page = new Page;

        $page->name = trim($request->name);
        $page->status = ($request->status == 'on')?1:0;
        $page->slug = trim($request->slug);
        $page->header_page = $header;
        $page->footer_page = $footer;
        $page->other_page = $other;
        $page->sort_number = $request->sort_number;
        $page->parent_page = $request->parent_page;
        $page->description = $request->description;
        $page->meta_title = $request->meta_title;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;
                
        if($page->save()){
            Session::flash('success','Page Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/pages');
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
        $pages = Page::find($id);
        $prentpages = Page::where('parent_page','=',0)->where('id','!=', $id)->where('status','=', 1)->get();
        return view('admin.pages.edit',["pages" => $pages,"prentpages" => $prentpages]);
       
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
        $header = 0;
        $footer = 0;
        $other = 0;
        foreach ($request->header as $key => $value) {
           if ($value == 'header') {
               $header = 1;
           }elseif ($value == 'footer') {
              $footer = 1;
           }elseif ($value == 'other'){
            $other = 1 ;
           }
        }

        $page = Page::find($id);

        $page->name = trim($request->name);
        $page->status = ($request->status == 'on')?1:0;
        $page->slug = trim($request->slug);
        $page->header_page = $header;
        $page->footer_page = $footer;
        $page->other_page = $other;
        $page->sort_number = $request->sort_number;
        $page->parent_page = $request->parent_page;
        $page->description = $request->description;
        $page->meta_title = $request->meta_title;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;
                
        if($page->save()){
            Session::flash('success','Page Save successfully');
        }else{
            Session::flash('error','Please try again.');
        }
        return \Redirect::to('admin/pages');
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
        $page = Page::find($id);    
        
        if($page->delete()){
            Session::flash('success','Page Delete successfully');
        }else{
            Session::flash('error','Please try again.');
        }
        
        return \Redirect::to('admin/pages');
    }

/**
 * Show the Admin dashboard.
 *
 * @return \Illuminate\Http\Response
 */
    public function getDashboard()
    {
        return view('admin.pages.dashboard');
    }
     
    public function getBlank()
    {
        return view('admin.pages.blank');
    }

 /**
 * Show all newsletters recoreds in table a new resource.
 *
 * @return \Illuminate\Http\Response
 */ 
    public function newsletter_list()
    {
         //die(Helper::$common->getproductsFeaturevalue());
        $newsletters = NewsLetter::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.newsletter_list',["newsletters" => $newsletters]);
    }
    
/**
 * Show all contact us recoreds in table a new resource.
 *
 * @return \Illuminate\Http\Response
 */ 
    public function contact_us()
    {
         //die(Helper::$common->getproductsFeaturevalue());
        $contacts = Contact::OrderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.contact_us',["contacts" => $contacts]);
    }

/**
 * Show all TableReservation recoreds in table a new resource.
 *
 * @return \Illuminate\Http\Response
 */ 
    public function book_table()
    {
        $conditions = array();
        if (isset($_GET['data'])) {
            //echo '<pre>';print_r($_GET['data']);die;

            if (isset($_GET['data']['name']) && !empty($_GET['data']['name'])) {
            $conditions[] = array('name','LIKE', '%'.$_GET['data']['name'].'%');
            }

            if (isset($_GET['data']['phone']) && !empty($_GET['data']['phone'])) {
            $conditions[] = array('phone','=', $_GET['data']['phone']);
            }
            if (isset($_GET['data']['email']) && !empty($_GET['data']['email'])) {
            $conditions[] = array('email','=', $_GET['data']['email']);
            }
            if (isset($_GET['data']['reservation_date']) && !empty($_GET['data']['reservation_date'])) {
            $conditions[] = array('reservation_date','=', date('Y-m-d',strtotime($_GET['data']['reservation_date'])));
            }
            if (isset($_GET['data']['reservation_time']) && !empty($_GET['data']['reservation_time'])) {
            $conditions[] = array('reservation_time','=', date('H:i:s',strtotime($_GET['data']['reservation_time'])));
            }
        }
        $tableReservations = TableReservation::where($conditions)->OrderBy('created_at','DESC')->paginate(20);
        return view('admin.pages.book_table',["tableReservations" => $tableReservations]);
    }


}