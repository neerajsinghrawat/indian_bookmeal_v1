<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Country;
use App\Models\ProductImage;
use App\Models\Feature;
use App\Models\FeatureValue;
use App\Models\FeatureGroup;
use App\Models\ProductFeature;
use App\Models\ProductTag;
use App\Models\ProductItem;
use App\Models\ProductAttribute;
use App\Models\ProductFeatureAttribute;

use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
class ProductsController extends Controller
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
        $conditions = array();
        if (isset($_GET['data'])) {

            if (isset($_GET['data']['name']) && !empty($_GET['data']['name'])) {
            $conditions[] = array('name','LIKE', '%'.$_GET['data']['name'].'%');
            }

            if (isset($_GET['data']['category_id']) && !empty($_GET['data']['category_id'])) {
            $conditions[] = array('category_id','=', $_GET['data']['category_id']);
            }
        }
        $category_list = Category::where('status','=', 1)->where('parent_id','=', 0)->get();

    	$products = Product::where($conditions)->OrderBy('created_at','DESC')->paginate(10);
        return view('admin.products.index',["products" => $products,"category_list" => $category_list]);
    }


/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */  
     public function add()
    {
       	$productFeatureAttributes = array();
        $category_list = Category::where('status','=', 1)->where('parent_id','=', 7)->get();
        $productFeatures = ProductFeature::where('status','=', 1)->get();
        $product_featureAttributes = ProductFeatureAttribute::with('productFeature')->where('status','=', 1)->get()->toArray();
        foreach ($product_featureAttributes as $key => $value) {
           $productFeatureAttributes[$value['product_feature_id']][] = $value;
        }

        //echo '<pre>';print_r($productFeatureAttributes);die;

        return view('admin.products.add',["category_list" => $category_list,"productFeatures" => $productFeatures,"productFeatureAttributes" => $productFeatureAttributes]);
    }


/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function create(Request $request)
    {
       
/*		$this->validate($request, [
            'image' => 'required',
        ]);*/

        //echo '<pre>';print_r($_POST);die;
        $product = new Product;
        
            $product->name = trim($request->name);
            $product->status = ($request->status == 'on')?1:0;
            $product->is_popular = ($request->is_popular == 'on')?1:0;
            $product->slug = trim($request->slug);
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->description = $request->description;
            $product->allergen_key = $request->allergen_key;
            $product->server_text_heading = $request->server_text_heading;
            $product->meta_title = $request->meta_title;
            $product->meta_keyword = $request->meta_keyword;
            $product->meta_description = $request->meta_description;
            $product->short_description = $request->short_description;
            $product->is_varaible_product = ($request->is_varaible_product == 'on')?1:0;
          
          
            if (!empty($request->file('image'))) {
          	$image = $request->file('image');
            $unq_id = uniqid();   
      
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/product');
            $image->move($destinationPath, $name);        
            $product->image =  $name;
               
            $fullPath = public_path('image/product/'.$name);         
                            
            $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

            if(!empty($fullPath)){

                $source = \Tinify\fromFile($fullPath);
                $source->toFile($fullPath);  
                Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/product/200x200/'.$name));     

                Image::make($destinationPath.'/'.$name)->resize(400, 330)->save(public_path('/image/product/400x330/'.$name));                      
            }
            }

            if (!empty($request->ProductFeature)) {

                 $product->product_feature = implode($request->ProductFeature, ',');
                
            }
		       
            if($product->save()){
               
                if (!empty($request->Productattribute)) {

                    foreach ($request->Productattribute as $key => $productFeature_add) {
                        foreach ($productFeature_add as $value) {

                            $ProductAttribute = new ProductAttribute;

                            $ProductAttribute->product_id = $product->id;
                            $ProductAttribute->is_same_price = (isset($value['is_same_price']) && $value['is_same_price'] == 1)?1:0;
                            $ProductAttribute->attribute = $value['attribute'];                            
                            $ProductAttribute->feature_id = $key;                            
                            if (isset($value['price_type'])) {
                                $ProductAttribute->price_type = $value['price_type'];
                                $ProductAttribute->price = $value['price'];
                            }
                            $ProductAttribute->save(); 
                        }
                        
                    }

                }
                Session::flash('success','Product Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }

        return \Redirect::to('admin/products');
    }


/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function edit($id)
    {
    	$productFeatureAttributes = array();
        $products = Product::where('id','=',$id)->with('productTag','productItem','productAttribute')->first();
        //echo '<pre>';print_r($products);die;
        $category_list = Category::where('status','=', 1)->where('parent_id','=', 7)->get();

        $sub_category_list = Category::where('status','=', 1)->where('parent_id','=', $products->category_id)->get();
        $productFeatures = ProductFeature::where('status','=', 1)->get();
        $product_featureAttributes = ProductFeatureAttribute::with('productFeature')->where('status','=', 1)->get()->toArray();
        foreach ($product_featureAttributes as $key => $value) {
           $productFeatureAttributes[$value['product_feature_id']][] = $value;
        }

        /*
        foreach ($productFeatureItems as $key => $value) {
            $productFeatureItemsarr[$value['product_feature_id']] = $value;
        }*/

        //echo '<pre>';print_r($products);die;
     
        return view('admin.products.edit',["products" => $products,"category_list" => $category_list,"sub_category_list" => $sub_category_list,"productFeatureAttributes" => $productFeatureAttributes,"productFeatures" => $productFeatures]);
       
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

        $product = Product::find($id);


		
        $category = Category::select('name')->where('id','=',$request->category_id)->first();

        $sub_category = Category::select('name')->where('id','=',$request->sub_category_id)->first();

        $categorynew = (!empty($category['name']))?$category['name']:'';
        $sub_categorynew = (!empty($sub_category['name']))?$sub_category['name']:'';

        //$changeslug = $request->slug;
       
        $newslug = $request->slug;
                /*        $request->slug 
          toLowerCase();
          replace(/[^a-zA-Z0-9]+/g,'-');*/

            $product->name = trim($request->name);
            $product->status = ($request->status == 'on')?1:0;
            $product->is_popular = ($request->is_popular == 'on')?1:0;
            $product->slug = trim($newslug);
            $product->model_no = $request->model_no;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->stock_status = $request->stock_status;

            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->short_description = $request->short_description;
            $product->description = $request->description;                    
            $product->allergen_key = $request->allergen_key;  
            $product->server_text_heading = $request->server_text_heading;                              
            $product->meta_title = $request->meta_title;                    
            $product->meta_keyword = $request->meta_keyword;                    
            $product->meta_description = $request->meta_description;                    
            $product->short_description = $request->short_description;                    
            $product->is_varaible_product = ($request->is_varaible_product == 'on')?1:0;
                   
        if (!empty($request->file('image'))) {

            $image = $request->file('image');
            $unq_id = uniqid(); 
            $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/product');
            $image->move($destinationPath, $name);
            
            $product->image =  $name;

            $fullPath = public_path('image/product/'.$name);
                                
              $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

                if(!empty($fullPath)){

                    $source = \Tinify\fromFile($fullPath);
                    $source->toFile($fullPath);
                    Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/product/200x200/'.$name));
                    Image::make($destinationPath.'/'.$name)->resize(400, 330)->save(public_path('/image/product/400x330/'.$name));
                }

        }

            if (!empty($request->ProductFeature)) {

                 $product->product_feature = implode($request->ProductFeature, ',');
                
            }
               
            if($product->save()){

               
                if (!empty($request->Productattribute)) {
                    //$this->productFeature_delete($id);
                    foreach ($request->Productattribute as $key => $productFeature_add) {
                        foreach ($productFeature_add as $value) {
                            if (isset($value['id']) && !empty($value['id'])) {
                                $ProductAttribute = ProductAttribute::find($value['id']);
                            }else{
                                $ProductAttribute = new ProductAttribute;
                            }
                            
                            

                            $ProductAttribute->product_id = $product->id;
                            $ProductAttribute->is_same_price = (isset($value['is_same_price']) && $value['is_same_price'] == 1)?1:0;
                            $ProductAttribute->attribute = $value['attribute'];                            
                            $ProductAttribute->feature_id = $key;                            
                            if (isset($value['price_type'])) {
                                $ProductAttribute->price_type = $value['price_type'];
                                $ProductAttribute->price = $value['price'];
                            }
                            $ProductAttribute->save(); 
                        }
                        
                    }

                }
              

                Session::flash('success','Product Update successfully');
            }else{
                Session::flash('error','Please try again.');
            }
		
        return \Redirect::to('admin/products');
    }
    

 /**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function tag_delete($id)
{
    $productstag = ProductTag::where('product_id','=',$id)->get();

    foreach ($productstag as $key => $protag) {

        $productTag = ProductTag::find($protag->id);
        $productTag->delete();
    }

} 
/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function item_delete($id)
{
    $product_items = ProductItem::where('product_id','=',$id)->get();

    foreach ($product_items as $key => $productitem) {

        $productItem = ProductItem::find($productitem->id);
        $productItem->delete();
    }

}

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function productFeature_delete($id)
{
    $product_items = ProductAttribute::where('product_id','=',$id)->get();

    foreach ($product_items as $key => $productitem) {

        $productItem = ProductAttribute::find($productitem->id);
        $productItem->delete();
    }

}


/**
 * Remove the specified resource from storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function delete_ajax_tag(Request $request)
    {
        //die($request);
       // echo '<pre>';print_r($_POST);die();
        $result = 0;
        $productTag = ProductTag::where('id','=', $request->tag_id)->first();   
        $product_tag = ProductTag::find($productTag->id);  
        
        if($product_tag->delete()){
            $result = 1;
        }

        return response()->json(['success'=> $result]);
    }

/**
 * Remove the specified resource from storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function delete_ajax_item(Request $request)
    {
        //die($request);
       //echo '<pre>';print_r($_POST);die();
        $result = 0;
        /*$productItem = ProductAttribute::where('id','=', $request['item_id'])->first();  
          echo '<pre>';print_r($productItem);die();*/
        $product_item = ProductAttribute::find($request['item_id']);  
       // echo '<pre>';print_r($product_item);die();
        if($product_item->delete()){
            $result = 1;
        }

        return response()->json(['success'=> $result]);
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
        $product = Product::find($id);    
        
        if($product->delete()){
                Session::flash('success','Product Delete successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        // hard delete
        //DB::delete('delete from w_coin_index where coin_index_id = ?',[$id]);
        return \Redirect::to('admin/products');
    }

/**
 * Remove the specified resource from storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function delete_images(Request $request)
    {
        //die($request);
       // echo '<pre>';print_r($_POST);die();
        $result = 0;
        $productimg = ProductImage::where('id','=', $request->image_id)->first();   
        $product_image = ProductImage::find($productimg->id);  
        
        if($product_image->delete()){
            $result = 1;
        }

        return response()->json(['success'=> $result]);
    }

/**
 * Show the form for creating a new resource.
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function add_more_image($id)
    {
        //$product = ProductImage::find($id);
        $allimages = ProductImage::where('product_id','=', $id)->get();
        return view('admin.products.add_more_image',["id" => $id,"allimages" => $allimages]);
    }


/**
 * Show the form for creating a new resource.
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function add_feature($id)
    {
    	//$product = ProductImage::find($id);
        $products = Product::where('id','=', $id)->first();
        $productFeatures = FeatureGroup::where('category_id','=',$products->category_id)->where('status','=',1)->get();
        $productFeaturesvalue = ProductFeature::where('product_id','=', $id)->get();
    
        $featureArr = array();

        //->toArray()
        
        foreach($productFeaturesvalue as $feature){
        
            if($feature['type'] == 'multiselect' ){
                $featureArr[$feature['feature_id']][]  = $feature['feature_value_id'];
            }else if($feature['type'] == 'text' ){
                $featureArr[$feature['feature_id']]  = $feature['value'];
            }else{
                $featureArr[$feature['feature_id']]  = $feature['feature_value_id'];
            }
            
        }
    

        //echo '<pre>';print_r($featureArr);die;
		return view('admin.products.add_feature',["id" => $id, "productFeatures" => $productFeatures,"featureArr" =>$featureArr]);
    }


/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function save_feature_value(Request $request)
    {
        //echo '<pre>';print_r($request->request);
      $productFeatureValueArr = array();
      $i = 0;
      foreach($request->products as $productKey => $productFeature){
        $getFeatureArr = $this->getFeatureArr($productKey);
        if(is_array($productFeature)){
       
            foreach($productFeature as $value){
                    $productFeatureValueArr[$i]['ProductFeature']['product_id'] = $request->product_id;
                    $productFeatureValueArr[$i]['ProductFeature']['feature_id'] = $productKey;
                    $productFeatureValueArr[$i]['ProductFeature']['feature_value_id'] = $value;
                    $productFeatureValueArr[$i]['ProductFeature']['type'] = (!empty($getFeatureArr)?$getFeatureArr['type']:''); 
                    $productFeatureValueArr[$i]['ProductFeature']['value'] = $this->getFeatureValueByID($value); 
                    $i++;
                }
                 
        }else{
                $productFeatureValueArr[$i]['ProductFeature']['product_id'] = $request->product_id;
                $productFeatureValueArr[$i]['ProductFeature']['feature_id'] = $productKey;
                $productFeatureValueArr[$i]['ProductFeature']['feature_value_id'] = (!empty($getFeatureArr)?(($getFeatureArr['type']=='text')?0:$productFeature):'');  
                $productFeatureValueArr[$i]['ProductFeature']['type'] = (!empty($getFeatureArr)?$getFeatureArr['type']:''); 
                $productFeatureValueArr[$i]['ProductFeature']['value'] = (!empty($getFeatureArr)?(($getFeatureArr['type']=='text')?$productFeature:$this->getFeatureValueByID($productFeature)):''); 
                $i++;

            }
       } 

       
        if (!empty($productFeatureValueArr)) {

            DB::table('product_features')->where('product_id', $request->product_id)->delete(); 
            
            foreach($productFeatureValueArr as $value){
                $productFeature = new ProductFeature;
               
                $productFeature->product_id = $value['ProductFeature']['product_id'];
                $productFeature->feature_id = $value['ProductFeature']['feature_id'];
                $productFeature->feature_value_id = $value['ProductFeature']['feature_value_id'];
                $productFeature->type = $value['ProductFeature']['type'];
                $productFeature->value = $value['ProductFeature']['value'];
                     
                           
                $productFeature->save();
            }
        }


       return \Redirect::to('admin/products');

    }


/**
 * getFeatureType method
 *
 * @param  int  $id
 * @return feature value if exist
 */     
    public function getFeatureArr($id){
    
        $feature = Feature::where('id','=', $id)->first();
       
        return (!empty($feature)?$feature:'');
    
    }

/**
 * getFeatureValueByID method
 *
 * @param  int  $id
 * @return feature value if exist
 */     
    public function getFeatureValueByID($id){
        
        $featureValues = FeatureValue::where('id','=',$id)->first();
        
        return (!empty($featureValues)?$featureValues->value:'');
        
    }

/**
 * Show the form for creating a new resource.
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function save_more_image(Request $request)
    {
       $this->validate($request, [
            'image' => 'required',
        ]);       
       foreach ($request->file('image') as $key => $value) {
        $product_image = new ProductImage;

        $image = $value ;    
        $unq_id = uniqid();   
       // echo $unq_id;die;
        $name = time().$unq_id.'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image/product');
        $image->move($destinationPath, $name);
        $product_image->image =  $name;
        $product_image->product_id =  $request->product_id;

        $fullPath = public_path('image/product/'.$name);
                                
              $tiny =  \Tinify\setKey('ios00qQ2g1v6pzNFcDkxqczLT6uDjBFN');

                if(!empty($fullPath)){

                    $source = \Tinify\fromFile($fullPath);
                    $source->toFile($fullPath);
                    Image::make($destinationPath.'/'.$name)->resize(200, 200)->save(public_path('/image/product/200x200/'.$name));
                Image::make($destinationPath.'/'.$name)->resize(400, 330)->save(public_path('/image/product/400x330/'.$name));
                }

                
           if($product_image->save()){
                Session::flash('success','Product Image Save successfully');
            }else{
                Session::flash('error','Please try again.');
            }
        }
        
        return \Redirect::to('admin/products');
    }



/**
 * ajax for sub category.
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function getAjaxsubcategoryList(Request $request)
    {
      
    $subcategory = Category::where('status','=', 1)->where('parent_id','=', $request->category_id)->get();
  // echo '<pre>';print_r($subcategory);die;
    return view('admin.products.getAjaxsubcategoryList',["subcategory" => $subcategory]);

    }

/**
 * Show the form for creating a new resource.
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function pay()
    {
    
    return view('admin.products.pay');
        
    }
}
