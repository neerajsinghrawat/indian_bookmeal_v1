@extends('layouts.front')
@section('title',  (!empty($categories->meta_title))?ucwords($categories->meta_title):'Menu')
@section('description', (!empty($categories->meta_description))? $categories->meta_description:'')
@section('keywords', (!empty($categories->meta_keyword))? $categories->meta_keyword:'')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Page Title -->
        <div class="page-title bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <h1 class="mb-0">Menu List</h1>
                        <!-- <h4 class="text-muted mb-0">Some informations about our restaurant</h4> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <!-- Menu Navigation -->
                        <nav id="menu-navigation" class="stick-to-content" data-local-scroll>
                            <ul class="nav nav-menu bg-dark dark">
                              
                              <?php $i = 1;
                                if (!empty($categories)) {
                                  //echo '<pre>';print_r($categories);die;
                                  foreach ($categories as $key => $category) {
                                    $is_show_cat = getCategoryProductCount($category['id']);

                                    if ($is_show_cat > 0) {
                                     
                                     ?>
                                <li><a href="{{ URL::to('category/menu') }}#<?php echo $category['slug']; ?>"><?php echo $category['name']; ?></a></li>
                                <?php } } } ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-9">
                        <!-- Menu Category / Burgers -->
                        <?php if (!empty($products)) {
                          foreach ($products as $key => $product) {
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
        </div>


<div class="modal fade" id="productModal" role="dialog">
    <div class="modal-dialog" role="document">

        <div class="modal-content" id="product_detail">
        </div>
    </div>
</div>

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>

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

                  location.reload();
                  
                  
                
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
 
/*  $(document).on('change','.qty',function(){
    var qty = $(this).val();
    alert(qty);
    var amount = $(this).attr('amount');
    var totalPrice = parseFloat(0);
    if (qty != '') {
      var productAmount = parseFloat(amount)*qty;
      if($(document).on('.attributes:checked').length){
        
        $(document).on(".attributes:checked").each(function() {
          //alert('55');
          var pricetype = $(this).attr('pricetype');
          var amount = $(this).attr('amount');
          //var productAmount = $(this).attr('productAmount');
          alert(amount);
          
          if (pricetype == 'Increment') {
              productAmount += parseFloat(productAmount)+parseFloat(amount);
          } else if (pricetype == 'Decrement'){
              productAmount -= parseFloat(productAmount)-parseFloat(amount);
          }else{
              productAmount = parseFloat(productAmount);
          }
        });
        
         $(".totalPrice").html(productAmount);
         $('.totalAmount').val(productAmount);      
      }else{
          $(".totalPrice").html(parseFloat(productAmount));
          //$('.totalAmount').val(totalPrice);
      }      
    }else{
      alert('Please select qty');
    }


  });*/  
  
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
                  location.reload();

          });    
  
  });
});
</script>
@endsection

