<?php


if (! function_exists('get_data')) {
    function get_data($model)
    {
    	$category_list = $model::first();
        return $category_list;
    }


    function get_count($user_id)
    {
    	$cart_count = DB::table('carts')->where('user_id', $user_id)->count();

        return $cart_count;
    }

    function get_cart_amount()
    {
    	$cart_count = DB::table('carts')->where('user_id', $user_id)->count();

        return $cart_count;
    }

    function get_dayOff()
    {	
    	$dayoff = array();
    	$dayarr = array('monday'=>1,'tuesday'=>2,'wednesday'=>3,'thursday'=>4,'friday'=>5,'saturday'=>6,'sunday'=>0);
    	$settings = DB::table('settings')->first();
    	$opening_times = DB::table('opening_times')->where('setting_id', $settings->id)->get();
    	foreach ($opening_times as $key => $value) {

    		if ($value->is_close == 1) {

    			$dayoff[]= $dayarr[$value->day_name];

    		}

    		
    	}
    	$dayoffdata = implode(', ', $dayoff);
    	//print_r($dayoffdata);die;

        return $dayoffdata;
    }

    function getAttributeName($attribute)
    {
    	
    	$attribute_name = '';
    	
		$product_feature_attributes = DB::table('product_feature_attributes')->where('id', $attribute)->first();
		if (!empty($product_feature_attributes)) {
			$attribute_name = $product_feature_attributes->name;
		}  		
    	    		
    	
    	//print_r($attribute_name);die;
        return $attribute_name;
    }

    function getAttributeDetail($attribute)
    {
    	
    	$attributeArr = unserialize($attribute);
    	$attribute_detail = array();
    	$attribute_detail['amount'] = 0;
    	$attribute_detail['name'] = '';
    	$attribute_detailname = '';
    	if (!empty($attribute)) {
	    	foreach ($attributeArr as $key => $value) {
	    		$product_feature_attributes = DB::table('product_attributes')->where('id', $value)->first();
	    		if (!empty($product_feature_attributes)) {
	    			
	    			$name = getAttributeName($product_feature_attributes->attribute);
	    			if ($product_feature_attributes->price_type == 'Increment') {
	    				$attribute_detail['amount'] +=$product_feature_attributes->price;
	    			}elseif ($product_feature_attributes->price_type == 'Decrement') {
	    				$attribute_detail['amount'] -=$product_feature_attributes->price;
	    				
	    			}

		    			//echo "<pre>";print_r(getAttributeName($product_feature_attributes->attribute));die;
		    			$attribute_detail['name'] .= $name.' ,';

	    			
	    		}  		
	    	    		
	    	}
    	}


    	//echo "<pre>";print_r($attribute_detail);die;
        return $attribute_detail;
    
    }

    function getOrderAttributeDetail($attribute)
    {
    	
    	//$attributeArr = unserialize($attribute);
    	$attribute_detail = array();
    	$attribute_detail['amount'] = 0;
    	$attribute_detail['name'] = '';
    	$attribute_detailname = '';
    	if (!empty($attribute)) {
    		//echo '<pre>';print_r($attribute);die;
	    		$product_feature_attributes = DB::table('order_attributes')->where('order_item_id', $attribute)->get();
	    		//echo '<pre>';print_r($product_feature_attributes);die;
	    		if (!empty($product_feature_attributes)) {
	    			foreach ($product_feature_attributes as $key => $value) {
	    				$attribute_detail['name'] .= $value->name.' ,';
	    			}
		    			

	    			
	    		}  		
	    	    		
	    	
    	}


    	//echo "<pre>";print_r($attribute_detail);die;
        return $attribute_detail;
    
    }
    function getCategoryProductCount($id)
    {
    	
    	//$attributeArr = unserialize($attribute);
    	$count = 0;
    	if (!empty($id)) {
    		
	    	$productsCount = DB::table('products')->where('sub_category_id', $id)->count();	    	    		//echo '<pre>';print_r($productsCount);die;	
	    	$count = $productsCount;
    	}

        return $count;
    
    }

    function getFeatureName($attribute)
    {
    
    	$attribute_name = '';
		$product_feature_attributes = DB::table('product_features')->where('id', $attribute)->first();
		if (!empty($product_feature_attributes)){
			$attribute_name = $product_feature_attributes->value;
		}  		
    	    		
    	
    	//print_r($attribute_name);die;
        return $attribute_name;
    }
    
    
    
    
   function getProductAverageRating($reviews){
		
		$avg_rating = 0;
		$totalRating = 0;
		if(!empty($reviews)){
			
			foreach($reviews as $review){
				$totalRating += $review['rating'];
			}
		
			if(($totalRating > 0) && (count($reviews) > 0)){
				$avg_rating = $totalRating / count($reviews);
			}
			
		}
		
		return $avg_rating;
	}


	function getProductAverageRatingfor_many_items($id)
	{
		
		$avg_rating = 0;
		$totalRating = 0;
		$reviews = DB::table('product_reviews')->where('product_id', $id)->get();
		//echo '<pre>';print_r($reviews);die;
		if(!empty($reviews)){
			
			foreach($reviews as $review){
				$totalRating += $review->rating;
			}
		
			if(($totalRating > 0) && (count($reviews) > 0)){
				$avg_rating = $totalRating / count($reviews);
			}
			
		}
		
		return $avg_rating;
	}


	function getProducttag($id){
		
		$tag = DB::table('product_tags')->where('product_id', $id)->get();
		
		return $tag;
	}	

	function getProductitems($id){
		
		$items = DB::table('product_items')->where('product_id', $id)->get();
		
		return $items;
	}
	
	
	function getOpenHours(){
		
		$openHours = DB::table('open_hours')->orderBy('sort_number')->get();
		
		return $openHours;
	}
    
    
     function getAllCurrencies(){
	     $result = array(
	                'GBP' => array('currency' => 'GBP','currency_symbol' => '£','currency_code' => 'GBP'),
					'USD' => array('currency' => 'USD','currency_symbol' => '$','currency_code' => 'USD'),
						);
	
	    	
		return $result;
   }
    
    
   function getSiteCurrencyType(){
	   
	   $site_setting = DB::table('settings')->select('site_currency_type')->first();
	  
	   $currencies = getAllCurrencies();
	   
	   
	   $result = (isset($site_setting->site_currency_type) && !empty($site_setting->site_currency_type)) ? $currencies[$site_setting->site_currency_type]['currency_symbol'] : '$';
	   
	   
	   return $result;
	  
   }

   function getuserdetail_byid($id)
   {
   		$userdetail = DB::table('users')->select('id','phone','first_name','last_name','username','email','address','postcode','city')->where('id', $id)->first();
		
		return $userdetail;
   }   

   function getProductSlugByProductId($product_id){
	 
	   $product_slug = DB::table('products')->select('slug')->where('id','=',$product_id)->first();
	   $result = !empty($product_slug) ? $product_slug->slug : '';
	   return $result;
   }

   function getmaincategoryname($id)
   {	
   		$category_name = array();
   		$category_name = DB::table('categories')->select('name')->where('id', $id)->first();

		return $category_name;
   }   

   function getsubcategoryname($id)
   {	
   		$category_name = array();
   		$category_name = DB::table('categories')->select('name')->where('id', $id)->first();

		return $category_name;
   }   

   function getcategoryname_byproduct_id($id)
   {	
   		$products = array();
   		$products = DB::table('products')->select('category_id','sub_category_id')->where('id', $id)->first();
   		$maincat = getmaincategoryname($products->category_id);
   		$subcat = getsubcategoryname($products->sub_category_id);
   		//echo '<pre>';print_r($maincat);die;
   		$subcategory_names = (!empty($subcat->name))?'/'.ucwords($subcat->name):'';
   		$catname = ucwords($maincat->name) .' '.$subcategory_names;
		return $catname;
   }   

   function getpreorder_byorder_id($id)
   {	
   		$preorder = array();
   		$preordernumber = 0;
   		$preorder = DB::table('order_items')->where('order_id', $id)->get();
   		foreach ($preorder as $key => $value) {
   			if ($value->is_pre_order == 1) {
   				$preordernumber = 1;
   			}
   		}

		return $preordernumber;
   }

	function getTimeArr(){
		
		$timearray=array('12:00 AM','01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM'); 
		
		return $timearray;
	}	
   


   
}
