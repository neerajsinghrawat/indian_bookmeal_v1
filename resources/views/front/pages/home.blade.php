@extends('layouts.front')
 <?php $model = new App\Models\Setting;
       $setting = get_data($model); ?>
@section('title', 'Home')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />


                    
        <!-- Section - Main -->
        <section class="section section-main section-main-2 bg-dark dark">

            <div id="section-main-2-slider" class="section-slider inner-controls">
            <?php foreach ($sliders as $key => $slider) {  
               $iImgPath = asset('image/no_product_image.jpg');
              if(isset($slider->image) && !empty($slider->image)){
                $iImgPath = asset('image/slider/'.$slider->image);
              } ?>                
                <!-- Slide -->
                <div class="slide">
                    <div class="bg-image zooming"><img src="{{  $iImgPath }}" alt=""></div>
                    <div class="container v-center">
                        <h1 class="display-2 mb-2"><?php echo $slider->title ?></h1>
                        <h4 class="text-muted mb-5"><?php echo $slider->sub_title ?></h4>
                        <a href="<?php echo $slider->button_url ?>" class="btn btn-outline-primary btn-lg"><span><?php echo $slider->button_text ?></span></a>
                    </div>
                </div>
                <?php } ?>

            </div>

        </section>

        <!-- Section - About -->
        <section class="section section-bg-edge">

            <div class="image right col-md-6 offset-md-6">
                <div class="bg-image"><img src="{{asset('css/front/img/bg-food.jpg')}}" alt=""></div>
            </div>

            <div class="container">
                <div class="col-lg-5 col-md-9">
                    <h1>The best food in London!</h1>
                    <p class="lead text-muted mb-5">Donec a eros metus. Vivamus volutpat leo dictum risus ullamcorper condimentum. Cras sollicitudin varius condimentum. Praesent a dolor sem....</p>
                    <div class="blockquotes">
                        <!-- Blockquote -->
                        <?php if (!empty($testimonials)) {
                
                            foreach ($testimonials as $key => $testimonial) {  
                                if($key == 0){ ?>
                        
                            <blockquote class="blockquote light animated visible" data-animation="fadeInLeft">
                                <div class="blockquote-content">
                                    <div class="rate rate-sm mb-3"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star"></i></div>
                                    <p class="fontSize"><?php echo $testimonial->description; ?></p>
                                </div>
                                <footer>
                                    <span class="name"><?php echo $testimonial->name; ?><span class="text-muted">, <?php echo $testimonial->designation; ?></span></span>
                                </footer>
                            </blockquote>
                        <?php }else{ ?>
                        <!-- Blockquote -->
                            <blockquote class="blockquote animated visible" data-animation="fadeInRight" data-animation-delay="300">
                                <div class="blockquote-content dark">
                                    <div class="rate rate-sm mb-3"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star"></i></div>
                                    <p><?php echo $testimonial->description; ?></p>
                                </div>
                                <footer>
                                    <span class="name"><?php echo $testimonial->name; ?><span class="text-muted">, <?php echo $testimonial->designation; ?></span></span>
                                </footer>
                            </blockquote>
                        <?php } } }else{ ?>
                            <blockquote class="blockquote light animated" data-animation="fadeInLeft">
                                <div class="blockquote-content">
                                    <div class="rate rate-sm mb-3"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star"></i></div>
                                    <p>It’ was amazing feeling for my belly!</p>
                                </div>
                                <footer>
                                    <span class="name">Mark Johnson<span class="text-muted">, Google</span></span>
                                </footer>
                            </blockquote>                        
                        <?php } ?>
                    </div>
                </div>
            </div>

        </section>

        <!-- Section - Steps -->
    

        <!-- Section - Menu -->
        <section class="section pb-0 protrude">

            <div class="container">
                <h1 class="mb-6">Our menu</h1>
            </div>

            <div class="menu-sample-carousel carousel inner-controls" data-slick='{
                "dots": true,
                "slidesToShow": 3,
                "slidesToScroll": 1,
                "infinite": true,
                "responsive": [
                    {
                        "breakpoint": 991,
                        "settings": {
                            "slidesToShow": 2,
                            "slidesToScroll": 1
                        }
                    },
                    {
                        "breakpoint": 690,
                        "settings": {
                            "slidesToShow": 1,
                            "slidesToScroll": 1
                        }
                    }
                ]
            }'>
                <!-- Menu Sample -->
                
            <?php if (!empty($ourmenu_category_list)) {
                
            foreach ($ourmenu_category_list as $key => $ourmenu_category) {  
               /*$iImgPath = asset('image/no_product_image.jpg');
              if(isset($slider->image) && !empty($slider->image)){
                $iImgPath = asset('image/slider/'.$slider->image);
              }*/ ?>                
                <div class="menu-sample">
                    <a href="{{ URL::to('category/menu') }}">
                        <img src="{{ asset('image/category/'.$ourmenu_category->image) }}" alt="" class="image imgwidthHeight">
                        <h3 class="title frontTitle">{{strtolower($ourmenu_category->name)}}</h3>
                    </a>
                </div>
                <?php } } ?>
            </div>

        </section>

        <!-- Section - Offers -->
        <!-- <section class="section bg-light">

            <div class="container">
                <h1 class="text-center mb-6">Special offers</h1>
                <div class="carousel" data-slick='{"dots": true}'>
                    
                    <div class="special-offer">
                        <img src="{{asset('css/front/img/special-burger.jpg')}}" alt="" class="special-offer-image">
                        <div class="special-offer-content">
                            <h2 class="mb-2">Free Burger</h2>
                            <h5 class="text-muted mb-5">Get free burger from orders higher that $40!</h5>
                            <ul class="list-check text-lg mb-0">
                                <li>Only on Tuesdays</li>
                                <li class="false">Order higher that $40</li>
                                <li>Unless one burger ordered</li>
                            </ul>
                        </div>
                    </div>
                    <div class="special-offer">
                        <img src="{{asset('css/front/img/special-pizza.jpg')}}" alt="" class="special-offer-image">
                        <div class="special-offer-content">
                            <h2 class="mb-2">Free Small Pizza</h2>
                            <h5 class="text-muted mb-5">Get free burger from orders higher that $40!</h5>
                            <ul class="list-check text-lg mb-0">
                                <li>Only on Weekends</li>
                                <li class="false">Order higher that $40</li>
                            </ul>
                        </div>
                    </div>
                    <div class="special-offer">
                        <img src="{{asset('css/front/img/special-dish.jpg')}}" alt="" class="special-offer-image">
                        <div class="special-offer-content">
                            <h2 class="mb-2">Chip Friday</h2>
                            <h5 class="text-muted mb-5">10% Off for all dishes!</h5>
                            <ul class="list-check text-lg mb-0">
                                <li>Only on Friday</li>
                                <li>All products</li>
                                <li>Online order</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </section> -->

<section class="section bg-light">

            <div class="container">
                <div class="row no-gutters justify-content-center">
                    <div class="col-md-8" role="tablist">
                        <h1 class="mb-6 text-center"><strong>Our</strong> Bestsellers</h1>
                        <!-- Menu Category / Burgers -->
                        <?php if (!empty($productsArr)) {
                          foreach ($productsArr as $key => $product) {
                          $keyarr=explode('~', $key);
                          //echo '<pre>';print_r($keyarr);die; ?>
                        <div id="{{ (isset($keyarr[2]))?$keyarr[2]:'' }}" class="menu-category">
                            <div class="menu-category-title">
                                <div class="bg-image"><img src="<?php echo(isset($keyarr[1]))?asset('image/category/'.$keyarr[1]):'none';  ?>" alt="category"></div>
                                <h2 class="title categoryTitle">{{ (isset($keyarr[0]))?strtolower($keyarr[0]):'' }}</h2>
                            </div>
                            <div class="menu-category-content">
                              <?php 
                                foreach ($product as $key => $food) {  
                                           
                               ?>
                                <!-- Menu Item -->
                                <div class="menu-item menu-list-item">
                                    <div class="row align-items-center">
                                        <div class="col-sm-7 mb-2 mb-sm-0">
                                            <h6 class="mb-0"><a href="#">{{ ucwords($food['name']) }}</a></h6>
                                            <span class="text-muted text-sm">
                                            <?php  $product_items = getProductitems($food['id']); ?>
                                            <?php 
                                              $i = 1;
                                              if(isset($product_items) && count($product_items) > 0 ){
                                              
                                                foreach ($product_items as $key => $product_item) {
                                                   $slashs = ($i < count($product_items)) ? ', ' : '';
                                                   echo ucwords($product_item->title.$slashs);
                                                   $i++; 
                                                 } 

                                               } ?>
                                                </span>




                                        </div>
                                          <div class="col-sm-2 text-sm-right paddingRight">

                                            <span class="text-md mr-4 left"><span class="text-muted">from</span> <?php echo getSiteCurrencyType(); ?><span data-product-base-price>{{ $food['price'] }}</span></span>
                                          </div>
                                        <div class="col-sm-3 text-sm-right">
                                            
                                           
                                            <a href="#productModal" data-toggle="modal" class="btn btn-outline-secondary productDetail" product_id="{{$food['id']}}"><span>Add to cart</span></a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>
                        <?php } }?>
                    </div>
                </div>
            </div>

        </section>       
<section class="section section-extended dark">

            <div class="container bg-dark marginLeft">
                <div class="row positionLeft">
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-shopping-cart"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2"><a href="menu-list-collapse.html">Pick a dish</a></h4>
                                <p class="text-muted mb-0">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-wallet"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2">Make a payment</h4>
                                <p class="text-muted mb-0">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-package"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2">Recieve your food!</h4>
                                <p class="text-muted mb-3">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>



<section class="section section-lg dark bg-dark">

            <!-- BG Image -->
            <div class="bg-image bg-fixed"><img src="{{asset('css/front/img/bg-burger2.jpg')}}" alt=""></div>

            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 text-center">                        
                        <h1 class="display-2"><strong>Book a Table</strong></h1>
                        <h4 class="text-muted mb-5">Book Your table online!</h4>
                        <a href="#odder" data-toggle="modal" class="btn btn-outline-primary btn-lg"><span>Book a Table</span></a>
                    </div>
                </div>
            </div>

        </section>  

 <div class="modal fade" id="productModal" role="dialog">
    <div class="modal-dialog" role="document">

        <div class="modal-content" id="product_detail">
        </div>
    </div>
</div>             
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script><!-- 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script type="text/javascript"> 
$(document).ready(function() {

  var baseUrl = '{{ URL::to('/') }}';
      
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
 // var form = $( "#addToCartForm" ).serialize();

  $('.addToCart').click(function(){
        
        var productid = $(this).attr('product_id');     
        //alert(productid);
        
            $.ajax({
      
                url: baseUrl+'/products/add_to_cart',
                
                type: 'post',
                
                data: {productid: productid,_token: CSRF_TOKEN},
                
                dataType: 'json',
                
                success: function(result) {

                  /*alert(result.response);
                  //$('#successFlashMsg').delay(1000).hide('highlight', {color: '#66cc66'}, 1500);*/
                  
                  $('<div id="successFlashMsg" class="msg msg-ok alert alert-success"><p>Item is successfully added into cart !</p></div>').prependTo('body');
                  
                  $('.display-cart').html(result.cart_count);
                  
                  //$('#totalProductInCart').html(result.totalProduct);
                  
                  //$('#totalAmountInCart').html(result.totalAmount);
                  
                  
                  
                  setTimeout(function(){
                    $("#successFlashMsg").fadeOut('slow');
                  },2000);
                  
                  
                
                }
                
              });
          
  });


  $('.productDetail').click(function(){
        
        var productid = $(this).attr('product_id');     
        //alert(productid);
        
            $.ajax({
      
                url: baseUrl+'/products/product_detail',
                
                type: 'post',
                
                data: {productid: productid,_token: CSRF_TOKEN},
                
                dataType: 'html',
                
                success: function(result) {

                //console.log(result);
                  
                  $('#product_detail').html(result);
                  
                  
                  
                  
                
                }
                
              });
          
  });  

  
  $(document).on('click','.submitCart',function(){
   
        var baseUrl = '{{ URL::to('/') }}';
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url : baseUrl+'/products/add_to_cart_new',
            type : 'POST',
            data : $('#AddToCART').serialize(),
            dataType : 'json',
            success : function(result){
              
            }
          }).done(function(result){
            
                  if (result.response == 1) {
                   $('<div id="successFlashMsg" class="msg msg-ok alert alert-success"><p>Item is successfully added into cart !</p></div>').prependTo('.msgcart');
                  
                    $('.notificationaa').html(result.cart_count);
                    $('.notification_amount').html(result.cart_amount);
                  }else {

                    $('<div id="successFlashMsg" class="msg msg-ok alert alert-danger"><p>Item is not added into cart!</p></div>').prependTo('.msgcart');
                  }    
                  setTimeout(function(){
                    $("#successFlashMsg").fadeOut('slow');
                  },2000);

          });    
  
  });
});
</script>
@endsection