@extends('layouts.front')
@section('title', 'Cart')
@section('description', 'Cart')
@section('keywords', 'food','Cart')
 <?php $model = new App\Models\Setting;
       $setting = get_data($model); ?>
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />   

    <!-- Content -->
    <div id="content">

        <!-- Page Title -->
        <div class="page-title bg-dark dark">
            <!-- BG Image -->
            <div class="bg-image bg-parallax"><img src="{{asset('css/front/img/bg-croissant.jpg')}}" alt=""></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <h1 class="mb-0">Checkout</h1>
                        <!-- <h4 class="text-muted mb-0">Some informations about our restaurant</h4> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Section -->
        <section class="section bg-light">

            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="panel-cart-content cart-details shadow bg-white stick-to-content mb-4">
                            <div class="bg-dark dark p-4"><h5 class="mb-0">You order  <button class="apply_coupon btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#apply_coupon_popup">Apply Coupon</button></h5></div>
                             <form action="{{ route('payments.pay.post') }}" class="form-horizontal" method="post" id="paypalForm" enctype="multipart/form-data">
                            {{ csrf_field() }}   
                            <table class="table-cart">
                                <?php $total = 0;
                                if (!empty($cart_list[0])) {
                                        foreach ($cart_list as $key => $cartlistdetail) {  
                                                       $iImgPath = asset('image/no_product_image.jpg');
                                                      if(isset($cartlistdetail->product->image) && !empty($cartlistdetail->product->image)){
                                                        $iImgPath = asset('image/product/200x200/'.$cartlistdetail->product->image);
                                                      }
                                        $attributes = getAttributeDetail($cartlistdetail->productItem_ids) ;              
                                        $total += (($cartlistdetail->product->price+$attributes['amount']) * $cartlistdetail->qty);
                                 ?>
                                <tr class="cart_{{ $cartlistdetail->id }}">
                                    <td class="title">
                                        <span class="name"><a href="#productcartDetail" class="productcartDetail" data-toggle="modal" product_id="{{$cartlistdetail->product->id}}" 
        cart_id="{{$cartlistdetail->id }}">{{ ucwords($cartlistdetail->product->name) }}</a></span><br>
                                        <span class="caption text-muted">{{$attributes['name']}}</span>
                                    </td>
                                    <td class="price">{{ getSiteCurrencyType().number_format((($cartlistdetail->product->price+$attributes['amount']) * $cartlistdetail->qty), 2, '.','')  }}</td>
                                    <td class="actions">
                                        <!-- <a href="#product-modal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a> --><a href="#productcartDetail" data-toggle="modal" class="action-icon productcartDetail" product_id="{{ $cartlistdetail->product->id }}" cart_id="{{ $cartlistdetail->id }}"><i class="ti ti-pencil"></i></a>
                                       <span class="action-icon delete_cart delete_{{ $cartlistdetail->id }}" cart_id="{{ $cartlistdetail->id }}"><i class="ti ti-trash"></i></span>
                                    </td>
                                </tr>

                                <?php } }else { ?>
                                <tr>
                                    <td>No items found</td>
                                </tr>
                                <?php } ?>
                            </table>
                            <div class="cart-summarys" style="display: block;">
                                <div class="row setcartPdding">
                                    <div class="col-7 text-right text-muted">Order total:</div>
                                    <div class="col-5"><strong><span class="grand_total">{{ getSiteCurrencyType().number_format($total, 2, '.','')}}</span></strong></div>
                                </div>
                                <div class="row setcartPdding">
                                    <div class="col-7 text-right text-muted">Coupon discount:</div>
                                    <div class="col-5"><strong><span class="coupon_discount"><?php echo (!empty(Session::get('apply_coupon.amount')))?getSiteCurrencyType().number_format(Session::get('apply_coupon.amount'), 2, '.',''):getSiteCurrencyType().'0'; ?></span></strong></div>
                                </div>
                                <div class="row setcartPdding">
                                    <div class="col-7 text-right text-muted">Tax({{(!empty($shipping_taxes->tax_percent))?$shipping_taxes->tax_percent:'0'}}%):</div>
                                    <div class="col-5"><strong><span class="tax_total"><?php

                                                    $total_amount = $total;
                                                                if (!empty($shipping_taxes->tax_percent) && $shipping_taxes->tax_percent > 0) {   
                                                                    $total_amount = ($total * $shipping_taxes->tax_percent) / 100 + $total;       
                                                                    echo  ''.getSiteCurrencyType().number_format(($total * $shipping_taxes->tax_percent) / 100, 2, '.','');
                                                                } else{
                                                                  echo ''.getSiteCurrencyType().'0';
                                                                }?></span></strong></div>
                                </div>
                                <?php $newshipping_amount = 0; if($setting['is_delivery'] == 1){ ?>
                                <div class="row setcartPdding">
                                    <div class="col-7 text-right text-muted">Devliery:</div>
                                    <div class="col-5"><strong>{{getSiteCurrencyType()}}<span class="shipping_total"><?php  
                                                    if (!empty($shipping_taxes->shipping_amount) && $shipping_taxes->shipping_type == 'Paid' ) {
                                                         //$total_amount = $shipping_taxes->shipping_amount + $total_amount;
                                                         $newshipping_amount = $shipping_taxes->shipping_amount;

                                                               

                                                         //echo number_format($shipping_taxes->shipping_amount, 2, '.','');
                                                         echo '0';
                                                     }else{
                                                        echo 'Free';
                                                     } 


                                                    if ((Session::has('apply_coupon.amount')) && !empty(Session::get('apply_coupon.amount'))) {
                                                        if ($total_amount > Session::get('apply_coupon.amount')) {
                                                            $total_amount = $total_amount - Session::get('apply_coupon.amount');
                                                        }else{
                                                            $total_amount = 0;
                                                        }
                                                        
                                                    } ?></span></strong></div>
                                </div>
                                <?php } ?>
                                <hr class="hr-sm">
                                <div class="row setApplycoupon">
                                    <div class="col-7 text-right text-muted">Total:</div>
                                    <div class="col-5"><strong>{{getSiteCurrencyType()}}<span class="main_total"><?php echo number_format($total_amount, 2, '.',''); ?></span></strong></div>
                                </div>
                            </div>
                            <!-- <div class="cart-empty" style="display: none;">
                                <i class="ti ti-shopping-cart"></i>
                                <p>Your cart is empty...</p>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 order-lg-first">
                        <div class="bg-white p-4 p-md-5 mb-4">
                            <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Basic informations</h4>
                            <input type='hidden' name='user[id]' value='{{ Auth::user()->id }}'>
                                <fieldset>   
                                    <div class="form-group">
                                        <label>First Name:</label>
                                        <input name="" value="{{ Auth::user()->first_name }}" placeholder="First Name" id="input-firstname" class="form-control" type="text" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name:</label>
                                        <input name="" value="{{ Auth::user()->last_name }}" placeholder="Last Name" id="input-lastname" class="form-control" type="text" readonly>
                                    </div>
                                    <!-- <div class="form-group">
                                        <input name="email" value="" placeholder="Email" id="input-email" class="form-control" type="text">
                                    </div> -->
                                    <div class="form-group">
                                        <label>Phone Number:</label>
                                        <input name="" value="{{ Auth::user()->phone }}" placeholder="Phone Number" id="input-phone" class="form-control" type="number" readonly>
                                    </div>
                                </fieldset><br>


                            <?php 
                                    $display_show ='display: none';
                                    $disabled = "disabled=disabled";

                                if($setting['is_takeaway'] == 1 && $setting['is_delivery'] == 0){

                                    $display_show ='display: none';
                                    $disabled = "disabled=disabled";

                                }elseif($setting['is_takeaway'] == 0 && $setting['is_delivery'] == 1 && Session::has('postcode') && Session::get('postcode.code_status') == 1){

                                    $display_show ='display: block';
                                    $disabled = "";
                                }elseif($setting['is_takeaway'] == 0 && $setting['is_delivery'] == 0){
                                    $display_show ='display: none';
                                    $disabled = "disabled=disabled";
                                }
                                     
                             ?>   
                            <h4 class="border-bottom pb-4"><i class="ti ti-wallet mr-3 text-primary"></i>Take</h4>
                            <div class="row text-lg">
                                <?php  if($setting['is_delivery'] == 1 && Session::has('postcode') && Session::get('postcode.code_status') == 1) { ?>
                                <div class="col-md-4 col-sm-6 form-group">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="take_order" class="custom-control-input take_order" value="delivery" newshipping_amount="{{ $newshipping_amount }}" total_amount="{{$total_amount}}" <?php echo ($setting['is_takeaway'] == 0 && $setting['is_delivery'] == 1)?'checked="checked"':''; ?>>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Delivery</span>
                                    </label>
                                </div>
                                <?php } if ($setting['is_takeaway'] == 1 || ($setting['is_takeaway'] == 0 && $setting['is_delivery'] == 0)){ ?>
                                <div class="col-md-4 col-sm-6 form-group">
                                    <label class="custom-control custom-radio ">
                                        <input type="radio" name="take_order" class="custom-control-input take_order" value="takeaway" checked="checked" newshipping_amount="{{ $newshipping_amount }}" total_amount="{{$total_amount}}">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Take Away</span>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>  <br>                         

                                <div class="address_delivery" style="<?php echo $display_show; ?>"> 
                                    <h4 class="border-bottom pb-4"><i class="ti ti-package mr-3 text-primary"></i>Delivery</h4>
                                    <div class="icon_class row">
                                        <?php if(isset($addressesArr['home']->title)){ ?>
                                           <span class="deliveryAddress col-md-3" type="home" address_id="<?php echo $addressesArr['home']->id;?>" title="<?php echo $addressesArr['home']->title;?>" style="cursor:pointer;"><i class="ti ti-home" style="cursor:pointer;font-size: 20px;color: #ddae71;"/></i> &nbsp;&nbsp;<b><?php echo $addressesArr['home']->title;?></b>
                                           </span> 
                                        <?php } if(isset($addressesArr['office']->title)){?>
                                            <span class="deliveryAddress  col-md-3" type="office" address_id="<?php echo $addressesArr['office']->id;?>"  title="<?php echo $addressesArr['office']->title;?>" style="cursor:pointer;"><i class="ti ti-world" style="cursor:pointer;font-size: 20px;color: #ddae71;"/></i> &nbsp;&nbsp;<b><?php echo ucwords($addressesArr['office']->title);?></b></span>
                                        <?php } 
                                         if(isset($addressesArr['other']) && count($addressesArr['other']) > 0){
                                            foreach ($addressesArr['other'] as $key => $addressesAr) {  ?>
                                            <span class="deliveryAddress col-md-3" type="other" address_id="<?php echo $addressesAr->id;?>"  title="<?php echo $addressesAr->title;?>"  style="cursor:pointer;"><i class="icofont icofont-location-pin" style="cursor:pointer;color: #e54c2a;font-size: 30px;"/></i><b>{{ ucwords($addressesAr->title) }}</b>
                                            </span>
                                        <?php } } ?>
                                    </div><br>             
                                    <fieldset>
                                        <a href="#addAddress" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-bottom: 15px;"><i class="ti ti-plus"></i>  Add Address</a><br>               

                                        <h6 class="selectedDeliveryAddress">Default</h6>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="deliveryAddress[address]" placeholder="Address" id="delivery_address" class="form-control address_fields" <?php echo $disabled; ?>>{{ Auth::user()->address }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Post Code</label>
                                            <input name="deliveryAddress[postcode]" placeholder="Post Code" id="delivery_code" class="form-control postalAutoComplete address_fields" type="text" value="{{ Auth::user()->postcode }}" <?php echo $disabled; ?> >
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input name="deliveryAddress[phone]" placeholder="Post Code" id="delivery_phone" class="form-control address_fields" type="text" value="{{ Auth::user()->phone }}" <?php echo $disabled; ?>>
                                        </div>
                                        <input name="deliveryAddress[address_id]"  id="delivery_address_id" class="form-control address_fields" type="hidden" value="0" <?php echo $disabled; ?>>
                                    </fieldset><br>  
                                </div>


                            <h4 class="border-bottom pb-4"><i class="ti ti-wallet mr-3 text-primary"></i>Payment</h4>
                            <div class="row text-lg">
                                <?php if($payment_getway['stripe'] == 1){
                                     ?>
                                <div class="col-md-4 col-sm-6 form-group">
                                    <label class="custom-control custom-radio ">
                                        <input type="radio" name="payment_type" class="custom-control-input newPayment" value="Stripe">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Card</span>
                                    </label>
                                </div>
                                <?php } if($payment_getway['cod'] == 1) { ?>
                                <div class="col-md-4 col-sm-6 form-group">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="payment_type" class="custom-control-input newPayment" value="Cod" checked="checked">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Cash</span>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                                <fieldset class="stripe" style="display: none;">    
                        <div class='form-row row'>
                            <div class='col-md-12 form-group required'>
                                <label class='control-label'>Name on Card</label> 
                                <input name="stripe[name]" class='form-control feature_value_' type='text' required="required" disabled="disabled">
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-md-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number feature_value_' size='20'
                                    type='text' name="stripe[card_number]" required="required" disabled="disabled">
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc feature_value_' placeholder='ex. 311' size='4'
                                    type='text' name="stripe[cvv]" required="required" disabled="disabled">
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month feature_value_' placeholder='MM' size='2'
                                    type='number' name="stripe[expire_month]" required="required" disabled="disabled">
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year feature_value_' placeholder='YYYY' size='4'
                                    type='number' name="stripe[expire_year]" required="required" disabled="disabled"> 
                            </div>
                                </fieldset>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg"><span>Order now!</span></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>

        <!-- Footer / End -->

    </div>
    <!-- Content / End -->

    

<!-- apply_coupon_popup popup -->
<div id="apply_coupon_popup" class="modal fade " role="dialog">
    <div class="modal-dialog modal-lg">

      <div class="modal-content coupon_popup_size">
        <div class="modal-header">
          <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
          <h6 class="modal-title float-left">Apply Coupon</h6>
        </div>
        <div class="modal-body">
            <h6 class="modal-title float-left">KAARMA’s VOUCHER TERMS & CONDITIONS</h6><br><br>
            <ul class="list-posts">
                <li><span class="title">1. Vouchers are not transferable or exchangeable for cash.</span></li>
                <li><span class="title">2. Vouchers can be redeemed against online orders only that are paid by credit/debit card only. </span></li>

                <li><span class="title">3. Please note that change is not given should your order value be less than the face value of the voucher.</span></li>

                <li><span class="title">4. Limited to one voucher per transaction, you can use your vouchers to claim money off the basket total of your order at the checkout. </span></li>

                <li><span class="title">5. In the event of 2,000 redemptions made per voucher code, the voucher will automatically expire regardless of the expiry date. </span></li>

                <li><span class="title">6. Kaarma reserves the right, at any time and in its sole discretion, to add additional terms and conditions in relation to the voucher code. </span></li>

                <li><span class="title">7. All standard terms & conditions apply.</span></li>
                
            </ul>
            
            

          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Code</th>
                <th>Coupon Details</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($couponcode_list[0])) {
                
               $index = 0;
               foreach ($couponcode_list as $value): 
               $index++;
               ?>
                <tr class="<?php echo (Session::has('apply_coupon') && Session::get('apply_coupon.id') == $value['id'])?'coupon_color':'';?>" >
                  <td><?php echo ucwords($value['code']); ?></td>
                  <td><?php echo $value['description']; ?></td>            
                  <td > <a class="btn btn-theme btn-md btn-wide" href="<?php echo url('apply-coupon/'.$value['id'].'/'.$total) ?>"><?php echo (Session::has('apply_coupon') && Session::get('apply_coupon.id') == $value['id'])?'Applied':'Apply';?></a></td>                
                </tr>
                <?php endforeach; }else{ ?> 
                <tr><td colspan="3" class="text-center">No any coupon code for apply.</td></tr>
                <?php } ?>
            </tbody>
          </table>                    
        </div>                 
      </div>
    </div>
</div>


<div class="modal fade product-modal" id="addAddress" role="dialog">
    <div class="modal-dialog odder" role="document" style="margin-top: 100px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10  modal-content" style="padding-left: 0px; padding-right: 0px;">
                        
                        <!-- Book a Table -->
                        <div class="utility-box">
                            
                            <div class="col-sm-12">

                               
                                <form action="" id="submitAddressFrom" class="booking-form">
                                    {{ csrf_field() }}
                                    <div class="utility-box-content"><div id="dispmsg" style="color: red"><b></b></div><div id="dispmsgSuccess" style="color: green"><b></b></div>

                                    <button type="button" class="close newAddressClose" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input name="title" placeholder="Title" id="title" class="form-control removeLater required_3" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" placeholder="Address" id="delivery_address" class="form-control removeLater required_3" ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Post Code</label>
                                        <input name="postcode" placeholder="Post Code" id="delivery_code" class="form-control removeLater required_3" type="text" value="">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input name="phone" placeholder="Phone" id="delivery_phone" class="form-control removeLater required_3" type="text" value=""><input type="hidden" name="type" value="other">
                                    </div>
                                        <br>
                                        <button class="utility-box-btn btn btn-secondary btn-block btn-lg saveaddressButton" type="button">Save</button>
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

<script type="text/javascript">
    var baseUrl = '{{ URL::to('/') }}';
</script>
<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>

<script type="text/javascript"> 

$(window).load(function(){
   //alert('kjkjg');
    if($(".take_order").prop('checked', true)){

        var valnew = $("input[type=radio][name='take_order']:checked").val();;
        
        if (valnew == 'delivery') {
           var newshipping_amount=parseFloat($(".take_order").attr('newshipping_amount'));
           var total_amount=parseFloat($(".take_order").attr('total_amount'));
           //alert(newshipping_amount);
           var alltotal = parseFloat(total_amount)+parseFloat(newshipping_amount);

           $('.main_total').html(alltotal.toFixed(2));
           $('.shipping_total').html(newshipping_amount.toFixed(2));
           //alert(newshipping_amount);
          $(".address_delivery").show();         
          $(".address_fields").prop('disabled', false);                
        }else{
           var newshipping_amount=parseFloat(0);
           var total_amount=$(".take_order").attr('total_amount');

           var alltotal = parseFloat(total_amount)+parseFloat(newshipping_amount);

           $('.main_total').html(alltotal.toFixed(2));
           $('.shipping_total').html(newshipping_amount.toFixed(2));
             $(".address_delivery").hide(); 
             $(".address_fields").prop('disabled', 'disabled');

        }
         
      }else{
            $(".address_delivery").hide(); 
             $(".address_fields").prop('disabled', 'disabled');        
      }
  });
</script>
<script src="{{ asset('js/fornt/devlopment.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
  //$(document).on('click','.newPayment',function(){
    $('.newPayment').click(function(){
        //alert('kjhn');
    var valNew =$(this).val();
    
      if($(this).prop('checked')){

        if (valNew == 'Stripe') {
          $(".stripe").show();         
          $(".feature_value_").prop('disabled', false);                
        }else{
             $(".stripe").hide(); 
             $(".feature_value_").prop('disabled', 'disabled');

        }
         
      }else{
         $(".stripe").hide(); 
         $(".feature_value_").prop('disabled', 'disabled');        
      }
  });    


    $('.take_order').click(function(){
        //alert('kjhn');
        var valNew =$(this).val();
        //alert(valNew);
    
      if($(this).prop('checked')){

        if (valNew == 'delivery') {
           var newshipping_amount=parseFloat($(this).attr('newshipping_amount'));
           var total_amount=$(this).attr('total_amount');

           var alltotal = parseFloat(total_amount)+parseFloat(newshipping_amount);

           $('.main_total').html(alltotal);
           $('.shipping_total').html(newshipping_amount.toFixed(2));
           //alert(newshipping_amount);
          $(".address_delivery").show();         
          $(".address_fields").prop('disabled', false);                
        }else{
           var newshipping_amount=parseFloat(0);
           var total_amount=$(this).attr('total_amount');

           var alltotal = parseFloat(total_amount)+parseFloat(newshipping_amount);

           $('.main_total').html(alltotal.toFixed(2));
           $('.shipping_total').html(newshipping_amount.toFixed(2));
             $(".address_delivery").hide(); 
             $(".address_fields").prop('disabled', 'disabled');

        }
         
      }else{
            $(".address_delivery").hide(); 
             $(".address_fields").prop('disabled', 'disabled');        
      }
    });

  var baseUrl = '{{ URL::to('/') }}';
      
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  
  
  <?php if(Session::has('shoppingstep.user.address_id')){ ?>
  var address_id = '<?php echo Session::get('shoppingstep.user.address_id') ?>';
  
   $.ajax({
      
                url: baseUrl+'/products/ajaxSelectDeliveryAddress',
                
                type: 'post',
                
                data: {address_id: address_id,requestType : 'selectAddress',_token: CSRF_TOKEN},
                
                dataType: 'json',
                
                success: function(resultData) {
                    
                    if(resultData.result == 1){
                        
                       $('.selectedDeliveryAddress').html(resultData.delivery_title);
                        $('#delivery_address').val(resultData.delivery_address);
                        $('#delivery_code').val(resultData.delivery_postcode);
                        $('#delivery_phone').val(resultData.delivery_phone);
                        $('#delivery_address_id').val(resultData.delivery_address_id);
                    }
                           
                 
                
                }
                
              });
  <?php } ?>
 
});

$(document).ready(function() {

  var baseUrl = '{{ URL::to('/') }}';
      
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // var form = $( "#addToCartForm" ).serialize();
  $(document).on('click','.saveaddressButton',function(){
   
        var baseUrl = '{{ URL::to('/') }}';
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var title= $('#title').val();
    var delivery_address= $('#delivery_address').val();
    var delivery_code= $('#delivery_code').val();
    var delivery_phone= $('#delivery_phone').val();
    if (title !='' && delivery_address !='' && delivery_code !='' && delivery_phone !='') {

          $.ajax({
            url : baseUrl+'/users/add_address_new',
            type : 'POST',
            data : $('#submitAddressFrom').serialize(),
            dataType : 'json',
            success : function(resultData){
              
                    if(resultData.result == 1){
                       $('.selectedDeliveryAddress').html(resultData.delivery_title);
                        $('#delivery_address').val(resultData.delivery_address);
                        $('#delivery_code').val(resultData.delivery_postcode);
                        $('#delivery_phone').val(resultData.delivery_phone);
                        $('#delivery_address_id').val(resultData.delivery_address_id);
                    }
                    //$("#addAddress").hide();
                    $(".newAddressClose").trigger('click');
                    $(".removeLater").val('');
                    
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
  $('.button_change').click(function(){
         // alert('jkjbj');
        var qty = $(this).attr('qty'); 
       
        var cart_id = $(this).attr('cart_id');         
        var product_id = $(this).attr('product_id'); 
        var product_price = $(this).attr('product_price'); 
        var button_type = $(this).attr('button_type'); 
        
       
            $.ajax({
      
                url: baseUrl+'/products/update-cart',
                
                type: 'post',
                
                data: {qty: qty,product_id: product_id,product_price: product_price,button_type: button_type,cart_id: cart_id,_token: CSRF_TOKEN},
                
                dataType: 'json',
                
                success: function(result) {

                  //alert(result.total);
                  
                  if (result.response == 1) {
                   // alert('.cart_product_qty_'+result.cart_id+'===>'+result.qty);
                    //alert(result.qty);
                    $('.cart_product_total_'+result.cart_id).html('<?php echo getSiteCurrencyType(); ?>'+result.producttotal.toFixed(2));
                    $('.cart_product_qty_'+result.cart_id).attr('qty',result.qty);
                    $('.grand_total').html('SUBTOTAL - '+'<?php echo getSiteCurrencyType(); ?>'+result.total.toFixed(2));
                    $('.tax_total').html('TAX - '+'<?php echo getSiteCurrencyType(); ?>'+result.tax_amount.toFixed(2));

                    $('.coupon_discount').html('COUPON DISCOUNT - '+'<?php echo getSiteCurrencyType(); ?>'+result.coupon_discount.toFixed(2));

                    if (result.shippingamount == 0) {
                    $('.shipping_total').html('SHIPPING CHARGES - Free');

                    }else {
                        $('.shipping_total').html('SHIPPING CHARGES - '+'<?php echo getSiteCurrencyType(); ?>'+result.shippingamount.toFixed(2));

                    }
                    
                    $('.main_total').html('TOTAL AMOUNT - '+'<?php echo getSiteCurrencyType(); ?>'+result.Maintotal.toFixed(2));                   


                  }else {

                    $('.display-cart').html(result.cart_count);
                    location.reload();
                 
                  }           
                  
                  
                  setTimeout(function(){
                    $("#successFlashMsg").fadeOut('slow');
                  },5000);
                  
                  
                
                }
                
              });
          
  }); 


  $('.delete_cart').click(function(){
        
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
          
  });
  
  
  $('.deliveryAddress').click(function(){
      var address_type = $(this).attr('type');
      var address_id = $(this).attr('address_id');
      var address_title = $(this).attr('title');
      
      
      $.ajax({
      
                url: baseUrl+'/products/ajaxSelectDeliveryAddress',
                
                type: 'post',
                
                data: {address_id: address_id,address_type: address_type,requestType : 'selectAddress',_token: CSRF_TOKEN},
                
                dataType: 'json',
                
                success: function(resultData) {
                    
                    if(resultData.result == 1){
                       $('.selectedDeliveryAddress').html(address_title);
                        $('#delivery_address').val(resultData.delivery_address);
                        $('#delivery_code').val(resultData.delivery_postcode);
                        $('#delivery_phone').val(resultData.delivery_phone);
                        $('#delivery_address_id').val(resultData.delivery_address_id);
                    }
                           
                 
                
                }
                
              });
              
      
  })
});
</script>
@endsection