<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;

class CategoriesController extends Controller
{

/**
 * menu_list funcation pass variables in header.
 *
 * @return \Illuminate\Http\Response
 */
    public function menu_list()
    {

/*    	$category_list = Category::where('parent_id','=',0)->where('status','=', 1)->get();

    	View::composer('partials.header', function($view)
			{
			    $view->with('category_list', $category_list);
			});*/
 
    }

    
}
