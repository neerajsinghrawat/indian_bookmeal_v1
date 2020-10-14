@extends('layouts.front')
@section('title',  (isset($categories->meta_title) && !empty($categories->meta_title))?ucwords($categories->meta_title):'Menu')
@section('description', (isset($categories->meta_description) && !empty($categories->meta_description))? $categories->meta_description:'')
@section('keywords', (isset($categories->meta_keyword) && !empty($categories->meta_keyword))? $categories->meta_keyword:'')
@section('content')


<!-- Breadcrumb Start -->
<div class="bread-crumb">
    <div class="container">
        <div class="matter">
            <h2>{{ (isset($categories->name) && !empty($categories->name))?ucwords($categories->name):'Menu' }}</h2>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="{{ url('/') }}">HOME</a></li>
                <li class="list-inline-item"><a href="#">{{ (isset($categories->name) && !empty($categories->name))?ucwords($categories->name):'Menu' }}</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
<form method="get" id="product_listform">
<div class="shop">
                <div class="container">
                    <div class="row">
					
                        <div class="col-md-3">
						
                            <div class="left-side">
                        <h4>SEARCH FILTERS</h4>
                        <div class="search">
                            <!-- Search Filter Start -->
                            
                                <fieldset>
                                    <div class="form-group">
                                        <input name="data[product_name]" value="<?php echo (isset($_REQUEST['data']['product_name'])) ?$_REQUEST['data']['product_name']:'';?>" class="form-control" placeholder="Search Food" type="text">
                                        <button type="submit" value="submit" class="btn"><i class="icofont icofont-search"></i></button>
                                    </div>
                                </fieldset>
                            
                            <!-- Search Filter End -->
                        </div>

                        <div class="popular">
                            <!-- Tag Filter Start -->
                            <h3>popular tags </h3>
                            <div class="form-group product_list_box">

                                <input type="text"  id="tag_list_select" name="data[tag]" placeholder="Enter Tag" value="<?php echo (isset($_REQUEST['data']['tag'])) ?$_REQUEST['data']['tag']:'';?>">

                            </div>

                        </div>
                        <div class="rating">
                            <!-- Rating Filter Start -->
                            <h3>Rating</h3>
                            <ul class="list-unstyled">
                                <li>
                                    <label class="check">
                                        <input type="radio" name="data[rating]" value="5" class="checkclass ratingradio" <?php echo (isset($_REQUEST['data']['rating']) && ($_REQUEST['data']['rating'] == 5)) ?'checked':'';?>/>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                </li>
                                <li>
                                    <label class="check">
                                        <input type="radio" name="data[rating]" value="4" class="checkclass ratingradio" <?php echo (isset($_REQUEST['data']['rating']) && ($_REQUEST['data']['rating'] == 4)) ?'checked':'';?>/>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                </li>
                                <li>
                                    <label class="check">
                                        <input type="radio" name="data[rating]" value="3" class="checkclass  ratingradio" <?php echo (isset($_REQUEST['data']['rating']) && ($_REQUEST['data']['rating'] == 3)) ?'checked':'';?>/>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                </li>
                                <li>
                                    <label class="check">
                                        <input type="radio" name="data[rating]" value="2" class="checkclass ratingradio" <?php echo (isset($_REQUEST['data']['rating']) && ($_REQUEST['data']['rating'] == 2)) ?'checked':'';?>/>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                </li>
                                <li>
                                    <label class="check">
                                        <input type="radio" name="data[rating]" value="1" class="checkclass ratingradio" <?php echo (isset($_REQUEST['data']['rating']) && ($_REQUEST['data']['rating'] == 1)) ?'checked':'';?>/>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                    </label>
                                </li>                                        

                                <li>
                                    <label class="check">
                                        <input type="radio" name="data[rating]" value="0" class="checkclass ratingradio" <?php echo (isset($_REQUEST['data']['rating']) && ($_REQUEST['data']['rating'] == 0)) ?'checked':'';?>/>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                        <i class="icofont icofont-star not_selected_star_rating"></i>
                                    </label>
                                </li>
                            </ul>
                            <!-- Rating Filter End -->
                        </div>
                    </div>

							
                            <!-- Left Filter End -->
                        </div>
                       
					   <div class="col-lg-9 mainpage">
                    <!-- Product View Start -->
                    <div class="row sort">

                        <!-- Product Short Start -->
                        <div class="col-md-4">
                            <div class="form-group input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <label class="input-group-addon" for="input-sort">Sort By :    </label>
                                </div>
                                <select id="input-sort" class="form-control selectpicker bs-select-hidden searchproduct" name="data[sort]">
                                    <option value="newest"  <?php echo (isset($_REQUEST['data']['sort']) && ($_REQUEST['data']['sort'] == 'newest')) ?'selected':'';?>>Newest</option>
                                    <option value="low_to_high" <?php echo (isset($_REQUEST['data']['sort']) && ($_REQUEST['data']['sort'] == 'low_to_high')) ?'selected':'';?>>Low to High</option>
                                    <option value="high_to_low" <?php echo (isset($_REQUEST['data']['sort']) && ($_REQUEST['data']['sort'] == 'high_to_low')) ?'selected':'';?>>High to Low</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group input-group input-group-sm">
                                
                            </div>
                        </div>
                   
                        <div class="col-md-4 list d-sm-none d-md-block text-right">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" id="grid-view" class="btn btn-theme-alt btn-md btngrid" data-toggle="tooltip" title="Grid"><i class="icofont icofont-brand-microsoft"></i></button>
                                <button  type="button" id="list-view" class="btn btn-theme-alt btn-md btngrid" data-toggle="tooltip" title="List"><i class="icofont icofont-listine-dots"></i></button>
                            </div>
                        </div>
                        <!-- Product Short End -->
                    </div>
                     
                    <div class="row">
                    <?php 
                      if (isset($products[0]) && !empty($products[0])) {
                                                
                      foreach ($products as $key => $product) {  
                                     $iImgPath = asset('image/no_product_image.jpg');
                                    if(isset($product->image) && !empty($product->image)){
                                      $iImgPath = asset('image/product/200x200/'.$product->image);
                                    } ?>
                        <!-- Product List Start -->
                        <!-- Single Product Start -->
                        <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="product-thumb">
                                <div class="image">
                                    <a class="link" href="{{ URL::to('product/'.$product['slug']) }}"><img src="{{ $iImgPath }}" alt="{{ ucwords($product['name']) }}" title="{{ ucwords($product['name']) }}" class="img-fluid" /></a>
                               
							   
                                </div>
                                <div class="caption">
                                    <a href="{{ URL::to('product/'.$product['slug']) }}"><h4>{{ ucwords($product['name']) }}</h4></a>

                                    <?php  $avg_rating = getProductAverageRatingfor_many_items($product['id']);  ?>
                                   
                                    <div class="rating">
                                      <?php for($i = 1; $i <=5; $i++){ ?>
                                        
                                            <i class="icofont icofont-star  <?php echo ($i <= $avg_rating) ? 'selected_star_rating' : 'not_selected_star_rating'; ?>"></i>
                                        <?php } ?>
                                    </div>
                                    <div class="price"><?php echo getSiteCurrencyType(); ?>{{ $product['price'] }}
                                    </div>                
                                    <p><?php echo $product['short_description'] ?></p> 
                                    
                                </div>
                            </div>
                        </div>
                    <?php } } else{ ?>
                       <img src="{{ asset('image/no_product.png') }}">
                    <?php }?>
                    </div>

                    <div class="row">

                      <!--   <div class="col-sm-12 col-xs-12 text-center">
                                                                <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous"><i class="icofont icofont-double-left"></i></a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">01</a> 
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">02</a> 
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">03</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">04</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">...</a> 
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">18</a> 
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next"><i class="icofont icofont-double-right"></i></a>
                                </li>
                            </ul>
                            
                        </div> -->
                    </div>
                    <!-- Product View End -->
                </div>

					   </div>
                </div>
            </div>
			</form>
@endsection

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
  <script type="text/javascript">
$(document).ready(function(){
   //alert('mnlnj');
  $('.searchproduct').change(function(){
     $("#product_listform").submit();
    
  });  

  $('.ratingradio').click(function(){
     $("#product_listform").submit();
    
  });

     $('#tag_list_select').selectize({
    persist: false,
    createOnBlur: true,
    create: true,
    
    plugins: ['remove_button'],
    
    
     maxItems: null,
     valueField: 'id',
     searchField: 'title',
     options: [<?php foreach($tag_list as $key => $search){ ?>
      {id: '<?php echo $key; ?>', title: '<?php echo ucwords($search); ?>'},
   <?php } ?>
     ],
     render: {
      option: function(data, escape) {
       return '<div class="option">' +
         '<span class="title">' + escape(data.title) + '</span>' +
        '</div>';
      },
      item: function(data, escape) {
       return '<div class="item">'+ escape(data.title) + '</div>';
      }
     },
     create: function(input) {
      return {
       id: input,
       title: input
      };
     }
    });
});
  </script>