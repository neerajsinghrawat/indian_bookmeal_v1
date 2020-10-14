@extends('layouts.front')
<?php $title = (!empty($product_details->meta_title))? $product_details->meta_title:(ucwords($product_details->category->name).' | '.ucwords($product_details->name));?>
@section('title', $title)
@section('description', (!empty($product_details->meta_description))? $product_details->meta_description:'')
@section('keywords', (!empty($product_details->meta_keyword))? $product_details->meta_keyword:'')
@section('content')

<style type="text/css">
       .rslides {
  position: relative;
  list-style: none;
  overflow: hidden;
  width: 100%;
  padding: 0;
  margin: 0;
  }

.rslides li {
  -webkit-backface-visibility: hidden;
  position: absolute;
  display: none;
  width: 100%;
  left: 0;
  top: 0;
  }

.rslides li:first-child {
  position: relative;
  display: block;
  float: left;
  }

.rslides img {
  display: block;
  height: auto;
  float: left;
  width: 100%;
  border: 0;
  }

  .shopdetail .nav-tabs{
    margin:50px 0 30px;
}
.shopdetail .nav-tabs > li:hover a,
.shopdetail .nav-tabs > li a.active{
    background:#ddae71;
    color:#fff;
    border:none;
}
.shopdetail .nav-tabs > li a{
    color:#000;
    text-transform:uppercase;
    font-weight:700;
    font-size: 16px;
    line-height:14px;
    border:none ;
    padding:20px 17px;
}

.shopdetail #tab-review .box{
    border-bottom:1px solid #e5e5e5;
    margin-bottom:20px; 
}
.shopdetail #tab-review .box:last-child{
    border-bottom:0px solid #e5e5e5; 
}
.shopdetail #tab-review .box img{ 
    border-radius:4px;
    float:left;
    margin-right:20px;
}
.shopdetail #tab-review .box .detail{
    margin:0 0 16px 120px;
}
.shopdetail #tab-review .box .detail h2{
    font-size:16px;
    font-weight:600;
    color:#000;
    margin:0 0 2px;
}
.shopdetail #tab-review .box .detail span{
    font-size:14px;
    color:#b2b2b2;
}
.shopdetail #tab-review .box .detail .rating{
    margin:8px 0 10px;
}
.shopdetail #tab-review .box .detail p{
    font-size: 14px;
    margin:0;
}
.shopdetail #form-review .form-group{
    margin-bottom:0;
}
.shopdetail #form-review .form-control{
    min-height:45px;
    box-shadow:none;
    margin:0 0 30px;
    resize: none;
}
.shopdetail #form-review .form-control:focus{
    border-color: #e54c2a;
}
.shopdetail #form-review .rating{
    margin-bottom: 30px;
}
.shopdetail #form-review .rating p{
    font-size:14px;
    color:#000;
    text-transform:uppercase;
    margin:0 0 10px;
}
.shopdetail #form-review .rating i{
    color:#b2b2b2;
}
.qtypara{
    width: 150px;
    margin:0 5px;
    position:relative;
}
.qtypara .minus {
    position: absolute;
    left:0;
    cursor: pointer;
    top:13px;
}
.qtypara .add {
    position: absolute;
    cursor: pointer;
    right:0;
    top:13px;
}
.qtypara .add .icofont {
    border-radius: 0 15px 15px 0;
}
.qtypara .icofont{
    background-color:#e5e5e5;
    color:#A4A4A4;
    font-size:14px;
    border-radius: 15px 0 0 15px;
    padding: 9px 17px;
}
.qtypara .icofont:hover{
    background-color:#e54c2a;
    color:#fff;
}
.qtypara .form-control{
    height:37px;
    text-align:center;
    border-radius:40px;
    padding: 2px 50px;
    border-color: #e5e5e5;
}
.qtypara .form-control:focus{
    box-shadow: none;
    border-color: #e5e5e5;
}    
.tabcontent {
  display: none;
} 
</style>
<meta name="csrf-token" content="{{ csrf_token() }}" />   

        <!-- Section -->
        <section class="section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Product Single -->
                        <div class="shopdetail product-single">
                            <div class="product-image">
                                <?php if(!empty($productImages) && count($productImages) > 1){ ?>


                                <div class="container-product-slider">
                                    <div class="exzoom hidden" id="exzoom">
                                        <div class="exzoom_img_box">
                                            <ul class='rslides'>
                                            <?php foreach($productImages as $product_img){ ?>
                                                <li><img src="{{$product_img}}"/></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                        
                                    </div>
                                    </div>
                                <?php }else{ ?>
                                        <div class="image">
                                        <?php 

                                            $iImgPath = asset('image/no_product_image.jpg');
                                                  if(isset($product_details->image) && !empty($product_details->image)){
                                                    $iImgPath = asset('image/product/'.$product_details->image);
                                                  }
                                     ?>
                                        <img src="{{ $iImgPath }}" title="thumb image" alt="thumb image" class="img-fluid" style="width: 730px; height: 370px;" />
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Product Single -->
                        <div class="shopdetail product-single">
                            
                            <form id="booking-form" class="booking-form">
                                        {{ csrf_field() }}
                                <div class="product-content">
                                    <div class="product-header text-center">
                                        <h1 class="product-title">{{ ucwords($product_details->name) }}</h1>

                                        <span class="product-caption text-muted">
                                        </span>
                                        
                                    </div>
                                    <p class="lead"><?php echo $product_details->description ?></p>
                                    <hr class="hr-primary"><!-- 
                                    <h5 class="text-center text-muted">Order details</h5> -->
                                    <div class="panel-details-container">
                                        <!-- Panel Details / Size -->
                                        <!-- <div class="panel-details">
                                            <h5 class="panel-details-title">
                                                <label class="custom-control custom-radio">
                                                    <input name="radio_title_size" type="radio" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                                <a href="#panelDetailsSize" data-toggle="collapse">Size</a>
                                            </h5>
                                            <div id="panelDetailsSize" class="collapse">
                                                <div class="panel-details-content">
                                                    
                                            
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- Panel Details / Additions -->
                                        <?php if(!empty($product_details->productAttribute) && count($product_details->productAttribute) > 0){  ?>
                                        <div class="panel-details">
                                            <h5 class="panel-details-title">
                                                <label class="custom-control custom-radio">
                                                    
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                                <a href="#panelDetailsAdditions" data-toggle="collapse">Additions</a>
                                            </h5>
                                            <div id="panelDetailsAdditions" class="collapse">
                                                <div class="panel-details-content">
                                                    <div class="row">
                                            

                                            <?php
                                            $i = 1;
                                            foreach ($product_details->productAttribute as $key => $productitem) {

                                                $attribute_name = getAttributeName($productitem->attribute);
                                                       
                                                if (!empty($attribute_name)) {                                       
                                                  ?>
                                                
                                                                                                   
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input attributes" name="productAttribute[{{ $productitem->id }}]" value="{{$productitem->price}}" pricetype="{{$productitem->price_type}}" productAmount="{{$product_details->price}}">

                                                                    
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">{{$attribute_name}} ({{ getSiteCurrencyType().$productitem->price }})</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                            <?php } } ?> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <!-- Panel Details / Other -->
                                        <!-- <div class="panel-details">
                                            <h5 class="panel-details-title">
                                                <label class="custom-control custom-radio">
                                                    <input name="radio_title_other" type="radio" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                                <a href="#panelDetailsOther" data-toggle="collapse">Other</a>
                                            </h5>
                                            <div id="panelDetailsOther" class="collapse">
                                                <textarea cols="30" rows="4" class="form-control" placeholder="Put this any other informations..."></textarea>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                    </div>
                                    <h5 class="text-center text-muted">Order now!</h5>
                                    <div class="product-price text-center">{{ getSiteCurrencyType()}}<span class="totalPrice">{{$product_details->price }}</span></div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                             <div class="form-group text-center">
                                                <input type="number"  name="quantity" value="1" size="2" min="1" id="input-quantity1" class="form-control qty input-qty form-control-lg">
                                                
                                                <input type="hidden" class="product_id" name="product_id" value="{{ $product_details->id }}">

                                                <input type="hidden" class="slug_id" name="slug_id" value="{{ $product_details->slug }}">                                            
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                           
                                                <div class="buttons">
                                                <!-- <a href="shopping-cart.html" class="btn btn-theme-alt btn-md">Order Now</a> -->
                                                <?php if(Auth::check()){ 
                                                     $code_status = 0;
                                                  if (Session::has('postcode')) {
                                                    $code_status = Session::get('postcode.code_status');
                                                   }  ?>
                                                <button class="btn btn-outline-primary btn-lg btn-block addToCart">Add to cart</button>


                                                <?php }else{ ?>
                                                <a href="{{ URL::to('login/'.$product_details->slug) }}" class="btn btn-outline-primary btn-lg btn-block">Add to cart</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <a href="{{ URL::to('/') }}" class="btn btn-link">Back to menu</a>
                                    </div>
                                </div>
                            </form>
                            <h3 class="mt-5 mb-5 text-center">Reviews</h3>
                        <div class="complaint-tabs">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#active-complaint" class="nav-link text-center tablink" onclick="openPage('active-complaint', event)"  id="defaultOpen"><i class="ti ti-clip"></i> Reviews</a></li>
                                <li class="nav-item"><a href="#resolved-complaint" class="nav-link text-center tablink" onclick="openPage('resolved-complaint', event)" ><i class="ti ti-loop"></i> Add Reviews </a></li> 
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div id="active-complaint" class="tabcontent menu-category-content new-padding">
                                <div id="accordion_active_complaint">
                                <?php 
                                    if(!empty($productReviews) && count($productReviews) > 0){
                                        
                                        foreach($productReviews as $product_review){
                                        
                                        $img = asset('image/no_product_image.jpg');
                                        if(!empty($product_review->user->picture)){
                                            $img = asset('image/user/150x150/'.$product_review->user->picture);
                                        }
                                        
                                ?>                            
                                <!-- Blockquote -->
                                <blockquote class="blockquote blockquote-lganimated" data-animation="fadeIn">
                                    <div class="blockquote-content dark">
                                        <div class="rate rate-sm mb-3"> 
                                            <?php for($i = 1; $i <=5; $i++){ ?>
                                                        
                                                <i class="fa fa-star <?php echo ($i <= $product_review->rating) ? 'active' : ''; ?>"></i>
                                            <?php } ?>
                                        </div>
                                        <p><?php echo $product_review->review; ?></p>
                                    </div>
                                    <footer>
                                        <img src="{{ $img }}" alt="image">
                                        <span class="name"><?php echo $product_review->user->first_name .' '.$product_review->user->last_name; ?><span class="text-muted">, <?php $post_time = strtotime($product_review->created_at);
                                            $time = time() - $post_time; // to get the time since that moment
                                            $time = ($time<1)? 1 : $time;
                                            $tokens = array (
                                            31536000 => 'year',
                                            2592000 => 'month',
                                            604800 => 'week',
                                            86400 => 'day',
                                            3600 => 'hour',
                                            60 => 'minute',
                                            1 => 'second'
                                            );

                                            foreach ($tokens as $unit => $text) {
                                            if ($time < $unit) continue;
                                            $numberOfUnits = floor($time / $unit);
                                            echo  $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
                                            break;
                                             
                                            } ?></span></span>

                                    </footer>
                                </blockquote>
                                <?php } } ?>                                
                                </div>
                            </div>
                            <div id="resolved-complaint" class="tabcontent menu-category-content new-padding">
                              <div id="resolved_active_complaint">

                            <div class="submit-complaint">
                                <form class="form-horizontal" id="form-review" action="{{ url('/save_product_review') }}" enctype="multipart/form-data" method="POST" >
                                                         {{ csrf_field() }}

                                                    <div class="form-group row required">
                                                        <div class="col-sm-12">
                                                            <textarea name="review" rows="5" id="input-review" placeholder="Your Reviews*" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                        <p> Your Rating*</p>
                                                             <div class="rate">
                                                             
                                                            <span number='1' class="starRating rate"><i class="fa fa-star"></i></span>
                                                            <span number='2' class="starRating rate"><i class="fa fa-star"></i></span>
                                                            <span number='3' class="starRating rate"><i class="fa fa-star"></i></span>
                                                           <span number='4' class="starRating rate"> <i class="fa fa-star"></i></span>
                                                           <span number='5' class="starRating rate"> <i class="fa fa-star"></i></span>
                                                        </div>
                                                        </div>
                                                    </div><br>
                                                    <div class="buttons clearfix">
                                                    <input type="hidden" value="" class="rating_value" name="rating">
                                                    <input type="hidden" name="product_id" value="<?php echo $product_details->id ?>">
                                                    <input type="hidden" name="product_slug" value="<?php echo $product_details->slug; ?>">
                                                        <button type="submit" id="button-review" name="submit" value='saveProductReview'  class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                            </div>
                             </div>
                            </div>

                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
    .ui-autocomplete
    {
        position:absolute;
        cursor:default;
        z-index:4000 !important
    }
</style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <script src="{{ asset('js/fornt/product_slider/jssor.slider-28.0.0.min.js') }}" type="text/javascript"></script>
<script>
  /*$(function() {
    $(".rslides").responsiveSlides();
  });*/
</script>
<script type="text/javascript">

var baseUrl = '{{ URL::to('/') }}';

</script>
<script type="text/javascript">
    
 function openPage(pageName,elmnt) {
   // alert('jhhgc');
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.currentTarget.className += " active";
}
</script>
<script type="text/javascript"> 
$(document).ready(function() {

  var baseUrl = '{{ URL::to('/') }}';
      
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
 // var form = $( "#addToCartForm" ).serialize();

  $('.postcodesubmit').click(function(){
        
        var code = $('#postalAutoComplete').val(); 

            $.ajax({
      
                url: baseUrl+'/products/ajax_search_postalcode',
                
                type: 'post',
                
                data: {code: code,_token: CSRF_TOKEN},
                
                dataType: 'json',
                
                success: function(result) {

                  if (result.code_status == 1) {
                   $('<div id="successFlashMsg" class="msg msg-ok alert alert-success"><p>Food delivery able to your Postcode</p></div>').prependTo('.msgpostcode');
                  
                    $('.postcode_html').html(result.code);
                    window.setTimeout(function(){location.reload()},5000);
                  }else {

                    $('<div id="successFlashMsg" class="msg msg-ok alert alert-danger"><p>Food delivery not able to your Postcode</p></div>').prependTo('.msgpostcode');
                  }           
                  
                  
                  setTimeout(function(){
                    $("#successFlashMsg").fadeOut('slow');
                  },5000);
                  
                  
                
                }
                
              });
          
  });  
});
</script>

<script type="text/javascript"> 
$(document).ready(function() {

  var baseUrl = '{{ URL::to('/') }}';
      
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
 // var form = $( "#addToCartForm" ).serialize();

  $('.addToCart').click(function(){
        
        var productqty = $('.qty').val();     
        var productid = $('.product_id').val();     
        var slug = $('.slug_id').val();     
        //alert(productid);
        //alert(CSRF_TOKEN);
            $.ajax({
      
                url: baseUrl+'/products/add_to_cart_new',
                
                type: 'post',
                
                data: $('#booking-form').serialize(),
                
                dataType: 'json',
                
                success: function(result) {

                  //alert(result.response);
                  //$('#successFlashMsg').delay(1000).hide('highlight', {color: '#66cc66'}, 1500);
                  if (result.response == 1) {
                   $('<div id="successFlashMsg" class="msg msg-ok alert alert-success"><p>Item is successfully added into cart !</p></div>').prependTo('.msgcart');
                  
                    $('.notificationaa').html(result.cart_count);
                  }else {

                    $('<div id="successFlashMsg" class="msg msg-ok alert alert-danger"><p>Item is not added into cart!</p></div>').prependTo('.msgcart');
                  }           
                  
                  
                  setTimeout(function(){
                    $("#successFlashMsg").fadeOut('slow');
                  },5000);
                  
                  
                
                }
                
              });
          
  });  
});
</script>


<script>
	$(document).ready(function(){
		
        $('.starRating').click(function(){
            
            var star = $(this).attr('number');
            
            $('.rating_value').val(star);
            
             $( ".starRating" ).each(function() {
                        
                        var star_number = $(this).attr('number');
                        
                        if(star_number <= star){
                            $(this).children().addClass('active');
                        }else{
                            $(this).children().removeClass('active');
                        }
                  });
            
        });
		/*$('.attributes').click(function(){
			parseFloat();
            var pricetype = $(this).attr('pricetype');
            var amount = $(this).val();
			var productAmount = $(this).attr('productAmount');
			
		});*/

          /*$(document).on('click','.attributes',function(){
            var pricetype = $(this).attr('pricetype');
            var amount = $(this).val();
            var productAmount = $(this).attr('productAmount');

            if($(this).prop('checked')){
                var totalPrice = parseFloat(0);
                if (pricetype == 'Increment') {
                    totalPrice = parseFloat(productAmount)+parseFloat(amount);
                } else if (pricetype == 'Decrement'){
                    totalPrice = parseFloat(productAmount)-parseFloat(amount);
                }else{
                    totalPrice = parseFloat(productAmount);
                }
               $(".totalPrice").html(totalPrice);
            }else{
                $(".totalPrice").html(parseFloat(productAmount));
            }

          });*/

		
	});
</script>

		
@endsection



