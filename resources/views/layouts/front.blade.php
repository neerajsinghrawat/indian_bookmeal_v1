 <?php $model = new App\Models\Setting;
       $setting = get_data($model);
       $dayoff = get_dayOff(); ?>
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Title -->
<title><?php echo (!empty($setting->site_title))? $setting->site_title:'';?> | @yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')"> 
<!-- Favicons -->
<link rel="shortcut icon" href="{{ asset('image/favicon-32x32.png') }}">
<link rel="apple-touch-icon" href="{{ asset('image/favicon-32x32.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('image/favicon-32x32.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('image/favicon-32x32.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('image/favicon-32x32.png') }}">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Raleway:wght@100;200;400;500&display=swap" rel="stylesheet">


<!-- CSS Core -->


<link rel="stylesheet" href="{{ asset('css/front/css/core.css') }}" />

<link rel="stylesheet" href="{{ asset('css/front/css/developement.css') }}" />
<!-- CSS Theme -->
<link id="theme" rel="stylesheet" href="{{ asset('css/front/css/theme-beige.css') }}" />
<!-- <link rel="stylesheet" href="{{ asset('css/front/css/font-awesome.min.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/front/css/bootstrap-datetimepicker.min.css') }}">

<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.min.css" rel="stylesheet"></link>
</head>

    <body>
        <meta name="csrf-token" content="{{ csrf_token() }}" />  
        @include('partials._front_messages')
        
    <div id="body-wrapper" class="animsition">
            

            <!--  Header Start  -->
        @include('partials.header')
            <!-- Header End   -->


    <div id="content">
                <!-- Order Start  -->
    @yield('content')
                <!-- Order End  -->

                <!-- Popular Dishes Start -->

                <!-- Popular Dishes End -->

                <!-- Food Menu Start -->

                <!-- Food Menu End -->

                <!-- Reservation Start -->

                <!-- Reservation End  -->

                <!-- Blog Start -->

                <!-- Blog End -->

                <!-- Newsletter Start -->

                <!-- Newsletter End -->

                <!-- Footer Start -->
    @include('partials.footer')
                <!-- Footer End  -->

    </div>
    <div id="panel-cart">
        <div class="panel-cart-container">
            <div class="panel-cart-title">
                <h5 class="title">Your Cart</h5>
                <button class="close addressClose" data-toggle="panel-cart"><i class="ti ti-close"></i></button>
            </div>
            <div class="panel-cart-content cart-details product_front_cartdetail">
                
                <!-- <div class="cart-empty">
                    <i class="ti ti-shopping-cart"></i>
                    <p>Your cart is empty...</p>
                </div> -->
            </div>
        </div>
        
        @if (Auth::guest())
        <a href="{{ URL::to('login/shopping-cart') }}" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span>Go to checkout</span></a>
        @else
        <a href="{{ URL::to('shopping-cart') }}" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span>Go to checkout</span></a>
        @endif
    </div>

    <!-- Panel Mobile -->
    <nav id="panel-mobile">
        <div class="module module-logo bg-dark dark">
            <a href="#">
                <img src="" alt="" width="88">
            </a>
            <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
        </div>
        <nav class="module module-navigation"></nav>
        <div class="module module-social">
            <h6 class="text-sm mb-3">Follow Us!</h6>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
        </div>
    </nav>

    <!-- Body Overlay -->
    <div id="body-overlay"></div>
</div>
<!-- Modal / Product -->
<div class="modal fade" id="productcartDetail" role="dialog">
    <div class="modal-dialog" role="document" >
       <div class="modal-content" id="product_cartdetail">
        </div>
    </div>
</div>

<!-- Video Modal / Demo -->
<div class="modal modal-video fade" id="modalVideo" role="dialog">
    <button class="close" data-dismiss="modal"><i class="ti ti-close"></i></button>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <iframe height="500"></iframe>
        </div>
    </div>
</div>

<!-- Modal / COVID -->
<div class="modal fade" id="covid-modal" role="dialog" data-timeout="1000" data-set-cookie="covid-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-lg dark bg-dark">
                <div class="bg-image"><img src="{{asset('css/front/img/modal-covid.jpg')}}" alt=""></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
            </div>
            <div class="modal-body">
                <h3>We are COVID-19 safe!</h3>
                <p>In sed massa tempus, dapibus est pulvinar, pellentesque tellus. Donec ultricies magna nec mauris ornare venenatis. Duis fermentum est diam, in molestie tellus venenatis id. In ut efficitur mi, vel hendrerit libero. Phasellus ac vulputate lorem, pharetra tempor leo. Fusce eu dui libero.</p>
                <button class="btn btn-secondary" data-dismiss="modal"><span>Ok, thanks!</span></button>
            </div>
        </div>
    </div>
</div>


<!-- Modal / COVID -->
<?php 

if ($setting['is_delivery'] == 1) {

 $showpopup = '';
if(Session::has('postcode')){
    $showpopup = '';
}else{
    //$showpopup = 'data-timeout="1000"';
    $showpopup = '';
} ?>
<div class="modal fade" id="postCode-modal" role="dialog" <?php echo $showpopup; ?> style="margin-top: 100px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-lg dark bg-dark">
                <div class="bg-image"><img src="{{asset('css/front/img/modal-covid.jpg')}}" alt=""></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
            </div>
            <div class="modal-body">
                <h3>Check Food Delivery Available on Your Post Code!</h3>
                               
                                <form action="" id="checkPost-Code" class="checkPost-Code">
                                    {{ csrf_field() }}
                                    <div class="utility-box-content"><div id="dispmsg" style="color: red"><b></b></div><div id="dispmsgSuccess" style="color: green"><b></b></div>
                                
                                        <div class="form-group">
                                            <input type="text" name="post_code" class="form-control postalAutoComplete" id="post_code" placeholder="Enter Post code" value="<?php echo (Session::has('postcode'))?Session::get('postcode.postcode'):''; ?>">
                                        </div>
                                        <br>
                                        <!-- <button class="utility-box-btn btn btn-secondary btn-block btn-lg saveTablereservation" type="button">Make reservation!</button> -->
                                    </div>

                                        <button class="btn btn-secondary checkPostCode" type="button"><span>Check</span></button>
                                    
                                </form>
                
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="modal fade product-modal" id="odder" role="dialog">
    <div class="modal-dialog odder" role="document" style="/*
    margin-right: 660px;*/
    margin-top: 100px;">
            <div class="container" style="width: 1119px;height: 1165px;">
                <div class="row justify-content-center">
                    <div class="col-lg-10  modal-content" style="padding-left: 0px;
    padding-right: 0px;">
                        
                        <!-- Book a Table -->
                        <div class="utility-box">
                            <div class="utility-box-title bg-dark dark">

                                <div class="bg-image"><img src="{{asset('css/front/img/modal-review.jpg')}}" alt=""></div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
                                <div class="row">
                                    <div class="col-md-1">
                                            <span class="icon icon-primary"><i class="ti ti-bookmark-alt"></i></span>
                                     </div>
                                     <div class="col-md-6">
                                    <h4 class="mb-0">Book a table</h4>
                                    <p class="lead text-muted mb-0">Details about your reservation.</p>
                                </div>

                                </div>

                            </div> 
                            <div class="row">
                            <div class="col-sm-6 special-offer-content">
                                <div class="bg-white p-4 p-md-5 mb-4">
                            
                                <h4 class="mb-0"><b>Opening Times</b></h4><br>
                                <?php 
                                foreach ($setting->openingTime as $key => $value) {
                                   //echo '<pre>';print_r($value);die;
                                ?>
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6 class="mb-1 text-muted">{{ ucfirst($value->day_name) }}</h6>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <?php if($value->is_close == 1){ ?>
                                        <h6 class="mb-1 text-muted">Day Off</h6>
                                        <?php }else{ ?>
                                        <h6 class="mb-1 text-muted">{{ date('h:i A', strtotime($value->start_time)) }} – {{ date('h:i A', strtotime($value->end_time)) }}</h6>
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr class="hr-md" style="margin-top: 10px;margin-bottom: 10px;"> 
                                <?php } ?>
                                <br>
                        <h4 class="mb-0"><b>Call Us Now</b></h4>
                         <h6 class="mb-1 text-muted"><i class="ti ti-mobile"> {{ $setting->table_reservation_phone_number }}</i></h6>
                                

                                </div>
                            </div>
                            <div class="col-sm-6">

                                    <?php if($setting->is_book_table_applied == 1){ ?>
                               
                                <form action="" id="booking-form" class="booking-form">
                                    {{ csrf_field() }}
                                    <div class="utility-box-content"><div id="dispmsg" style="color: red"><b></b></div><div id="dispmsgSuccess" style="color: green"><b></b></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>People<span class="required_2">&#x2731;</span></b></label>
                                                    <div class="select-container">
                                                    <select class="form-control" name="people_count" required>
                                                        <?php foreach ($people_count as $value) {  ?>
                                                        <option value="{{$value}}">{{$value}} people</option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>Date <span class="required_2">&#x2731;</span></b></label>
                                                    <input type="text" name="reservation_date" class="form-control required_3 datepicker" id="date" data-date-format="mm/dd/yyyy" required>
                                                </div>
                                            </div>                                            
                                        </div>   

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>Time<span class="required_2">&#x2731;</span></b></label>
                                                    <div class="select-container">
                                                    <select name="reservation_time" class="form-control required_3 timeArray" required>
                                                        <?php foreach ($timearray as $value) {
                                                             ?>
                                                        <option value="{{$value}}">{{$value}} </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>Name <span class="required_2">&#x2731;</span></b></label>
                                                    <input type="text" name="name" class="form-control required_3" required id="name">
                                                </div>
                                            </div>
                                        </div>
                                                <div class="form-group">
                                                    <label><b>Email <span class="required_2">&#x2731;</span></b></label>
                                                    <input type="email" name="email" class="form-control required_3" id="email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>Phone Number <span class="required_2">&#x2731;</span></b></label>
                                                    <input type="text" id="phone" name="phone" class="form-control required_3" required>
                                                </div>
                                        <br>
                                        <button class="utility-box-btn btn btn-secondary btn-block btn-lg saveTablereservation" type="button">Make reservation!</button>
                                    </div>

                               
                                    
                                </form>
                                <?php }else{ ?>
                                <div class="bg-white p-4 p-md-5 mb-4 text-center">
                                    <h4 class="mb-0"><b></b></h4><br>
                                </div>
                                <div class="bg-white p-4 p-md-5 mb-4 text-center">
                                    <h4 class="mb-0"><b>Table reservation is not aviable for now please check back later or contact ({{ $setting->table_reservation_phone_number }}).</b></h4><br>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<!-- Cookies Bar -->
<div id="cookies-bar" class="body-bar cookies-bar">
    <div class="body-bar-container container">
        <div class="body-bar-text">
            <h4 class="mb-2">Cookies & GDPR</h4>
            <p>This is a sample Cookies / GDPR information. You can use it easily on your site and even add link to <a href="#">Privacy Policy</a>.</p>
        </div>
        <div class="body-bar-action">
            <button class="btn btn-primary" data-accept="cookies"><span>Accept</span></button>
        </div>
    </div>
</div>
<!-- JS Core -->
<script type="text/javascript">
    var baseUrl = '{{ URL::to('/') }}';
</script>
<!-- <script src="{{ asset('css/front/js/jquery.min.js') }}"></script> -->

<script src="{{ asset('css/front/js/core.js') }}"></script><!-- 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->



<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>

<script src="{{ asset('css/front/js/bootstrap-datetimepicker.js') }}"></script>

<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->
<script src="{{ asset('js/fornt/devlopment.js') }}"></script>
<script>
    $(document).ready(function(){
        //close_popup_msg

        $('body').on('click','.close_popup_msg',function(){
            $('#popup_overlay').hide();
            $('#messageModel').hide();
        });

        setTimeout(function(){
            $('#popup_overlay').hide();
            $('#messageModel').hide();
          },4000);
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
var dayoff = [<?php echo $dayoff ?>];
//alert(dayoff);
$('.datepicker').datetimepicker({
   //language:  'fr',
    startDate : '-0d',
   weekStart: 0,
   todayBtn:  1,
   autoclose: 1,
   todayHighlight: 1,
   startView: 2,
   minView: 2,
   forceParse: 0,
   daysOfWeekDisabled: dayoff
});

$(document).on('click','.attributes',function(){
    var totalAmount = $('.totalAmount').val();
    var totalPrice = parseFloat(0);
    var pricetype = $(this).attr('pricetype');
    var amount = $(this).attr('amount');
    var feature = $(this).attr('feature');
    var productAmount = $(this).attr('productAmount'); 
    var totalMainamount= parseFloat(productAmount);
    var isOtherAttr = 0;
    var qty = $('.qty').val();
    var notEdit = $(this).attr('notEdit');
         
     
     $(".attributes").each(function() {
        var otherpricetype = $(this).attr('pricetype');
        var otheritemamount = $(this).attr('amount');
        var otherfeature = $(this).attr('feature');
        

        if (otherfeature != feature) {
          if($(this).prop('checked')){
            //alert(otherpricetype);
            //alert(otheritemamount);
            if (otheritemamount != 0) {

                var otherAttrAmount = parseFloat(otheritemamount)
                var otherAttrPriceType = otherpricetype;
                //alert('pp'+otherAttrAmount);

                if (otherAttrPriceType == 'Increment') {
                    totalMainamount += parseFloat(otherAttrAmount);
                } else if (otherAttrPriceType == 'Decrement'){
                    totalMainamount -= parseFloat(otherAttrAmount);                
                }

                isOtherAttr = 1;

            }
             //alert(totalMainamount);

          }          
        }
       

     });      

     if (isOtherAttr == 0) {

       totalMainamount = parseFloat(productAmount);

     }

     //if (notEdit == 1) {
          if (pricetype == 'Increment') {
              totalMainamount += parseFloat(amount);
          } else if (pricetype == 'Decrement'){
              totalMainamount -= parseFloat(amount);
              
          }else{
              totalMainamount = parseFloat(totalMainamount);
          }      
     //}
//alert(totalMainamount);

          totalMainamount = parseFloat(totalMainamount) *qty;
          $(".totalPrice").html(totalMainamount);
          $('.totalAmount').val(totalMainamount);

  }); 

  $(document).on('change','.qty',function(){
    var productAmount = $(this).attr('amount');
    var totalPrice = parseFloat(0);
    var totalMainamount= parseFloat(productAmount);
    var isOtherAttr = 0;
    var qty = $(this).val();     

     
     $(".attributes").each(function() {
        var otherpricetype = $(this).attr('pricetype');
        var otheritemamount = $(this).attr('amount');
        var otherfeature = $(this).attr('feature');
        

        
          if($(this).prop('checked')){
            var otherAttrAmount = parseFloat(otheritemamount);
            var otherAttrPriceType = otherpricetype;

            //alert(otherAttrPriceType);

            if (otherAttrPriceType == 'Increment') {
                totalMainamount += parseFloat(otherAttrAmount);
            } else if (otherAttrPriceType == 'Decrement'){
                totalMainamount -= parseFloat(otherAttrAmount);                
            }
            //alert(totalMainamount);

            isOtherAttr = 1;
          }          
        

     });      


     if (isOtherAttr == 0) {

       totalMainamount = parseFloat(productAmount)*qty;

     }else{

        totalMainamount = parseFloat(totalMainamount) *qty;
     }
          

          
      
          $(".totalPrice").html(totalMainamount);
          $('.totalAmount').val(totalMainamount);

  });

  var baseUrl = '{{ URL::to('/') }}';
      
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'); 

  $(document).on('change','.datepicker',function(){

    var date = $(this).val();
    newyear = new Date(date);
    day = newyear.getDay();
    //alert(day);
        $.ajax({
  
            url: baseUrl+'/add_timedropdown',
            
            type: 'post',
            
            data: {day: day,_token: CSRF_TOKEN},
            
            dataType: 'json',
            
            success: function(result) {

              //alert(result.response);
              console.log(result);
              html ="";
              $(".timeArray").html($("<option>").attr('value','').text(''));
              $.each(result, function (i, elem) {
                    html += "<option value="+elem+">"+elem+"</option>";
                });
              $(".timeArray").append(html);
                                                
              $("#overlay, #PleaseWait").hide();
              
              
              
              
            
            }
            
          });

  }); 

    $('.saveTablereservation').click(function(){
   // alert('mnlksdfjio');
    var name= $('#name').val();
    var email= $('#email').val();
    var phone= $('#phone').val();
    var date= $('#date').val();
    if (name !='' && email !='' && phone !='' && date !='') {
        var baseUrl = '{{ URL::to('/') }}';
        var formData = $('#booking-form').serialize();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url : baseUrl+'/pages/save_table_reservation',
            type : 'POST',
            data : $('#booking-form').serialize(),
            dataType : 'json',
            success : function(result){
              
            }
          }).done(function(result){
            
            if(result['success'] == 1){

                $('#dispmsgSuccess').html(result['msg']).show();
                setTimeout(function(){ jQuery("#dispmsgSuccess").hide(); }, 3000);
                window.location.reload();

            }else{

                $('#dispmsg').html(result['msg']).show();
                setTimeout(function(){ jQuery("#dispmsg").hide(); }, 3000);

                //alert(result['msg']);
                
            }
          });
    }else{

                $('#dispmsg').html('Please fill all required fields').show();
                $(".required_3").each(function() {

                    var dataFill = $(this).val();

                    if (dataFill == '') {

                        //alert(dataFill);
                        $(this).css({'border-color':'red'});
                        
                    }else{

                        $(this).css({'border-color':'#e0e0e0'});


                    }



                });

                

                setTimeout(function(){ jQuery("#dispmsg").hide(); }, 3000);
    }
  
  });


    $('.checkPostCode').click(function(){
       
        var post_code= $('#post_code').val();
        //alert(post_code);
        if (post_code !='') {
            var baseUrl = '{{ URL::to('/') }}';
            var formData = $('#checkPost-Code').serialize();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
                url : baseUrl+'/pages/check_postalcode',
                type : 'POST',
                data : $('#checkPost-Code').serialize(),
                dataType : 'json',
                success : function(result){
                  
                }
              }).done(function(result){

                //alert(result);
                //console.log(result);
                if (result.success == 0) {
                    $('#dispmsg').html(result.msg).show();

                    setTimeout(function(){ jQuery("#dispmsg").hide(); }, 4000);
                }else{

                    window.location.reload();  
                }

                //window.location.reload();                    
                
              });
        }else{

            $('#dispmsg').html('Please fill post code').show();

            setTimeout(function(){ jQuery("#dispmsg").hide(); }, 3000);
        }
      
    });

  var baseUrl = '{{ URL::to('/') }}';
      
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $(document).on('click','.delete_cart',function(){
    //$('.delete_cart').click(function(){
        if(confirm('Are you sure you want to remove item from the cart?')){
            var cartid = $(this).attr('cart_id'); 
        
            $.ajax({
      
                url: baseUrl+'/delete-cart',
                
                type: 'post',
                
                data: {cartid: cartid,_token: CSRF_TOKEN},
                
                dataType: 'json',
                
                success: function(result) {

                  //alert(result.response);
                  
                  if (result.response == 1) {

                    $('.cart_'+cartid).remove();

                   $('<div id="successFlashMsg" class="msg msg-ok alert alert-success"><p>Item Remove from cart successfully !</p></div>').prependTo('.msgcart');
                  
                    $('.display-cart').html(result.cart_count);
                    location.reload();
                  }else {

                    $('<div id="successFlashMsg" class="msg msg-ok alert alert-danger"><p>Item is not Remove from cart!</p></div>').prependTo('.msgcart');
                  }           
                  
                  
                  setTimeout(function(){
                    $("#successFlashMsg").fadeOut('slow');
                  },5000);
                  
                  
                
                }
                
              });
        }

          
  });



  $(document).on('click','.productcartDetail',function(){
  
        
        var productid = $(this).attr('product_id');     
        var cartid = $(this).attr('cart_id');     
        //alert(productid);
        
            $.ajax({
      
                url: baseUrl+'/products/product_cart_detail',
                
                type: 'post',
                
                data: {productid: productid,cartid: cartid,_token: CSRF_TOKEN},
                
                dataType: 'html',
                
                success: function(result) {
                    //alert('jhghj');

                //console.log(result);
                  
                  $('#product_cartdetail').html(result);
                  
                  
                  
                  
                
                }
                
              });
          
  });

  $('.productfrontcartdetail').click(function(){
        
        var productid = 0; 
        
            $.ajax({
      
                url: baseUrl+'/products/product_front_cartdetail',
                
                type: 'post',
                
                data: {productid: productid,_token: CSRF_TOKEN},
                
                dataType: 'html',
                
                success: function(result) {                   
                  
                  $('.product_front_cartdetail').html(result);                 
                  
                
                }
                
              });
          
  });  
  
  $(document).on('click','.submitupdateCart',function(){
   
        var baseUrl = '{{ URL::to('/') }}';
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url : baseUrl+'/products/update_to_cart_new',
            type : 'POST',
            data : $('#updateToCART').serialize(),
            dataType : 'json',
            success : function(result){
              
            }
          }).done(function(result){
            
              if (result.response == 1) {
               $('<div id="successFlashMsg" class="msg msg-ok alert alert-success"><p>Item is successfully added into cart !</p></div>').prependTo('.msgcart');
              
                $('.notificationaa').html(result.cart_count);
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

    </body>

</html>
