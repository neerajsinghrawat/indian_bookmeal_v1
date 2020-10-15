@extends('layouts.admin')

@section('content')

   

   
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order ID
        <small><?php echo $orderDetail->order_number; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo URL::to('/'); ?>/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="<?php echo URL::to('/'); ?>/admin/orders">Orders</li>
        <li class="active"><?php echo $orderDetail->order_number; ?></li>
      </ol>
    </section>

    <div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
      </div>
    </div>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> ORDER ID: <?php echo $orderDetail->order_number; ?>
            <small class="pull-right">Date: <?php echo date('d/m/Y H:i A', strtotime($orderDetail->created_at)); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <strong>Billed To:</strong>
          <address>
            <?php echo ucwords($orderDetail->user->first_name .' '.$orderDetail->user->last_name); ?><br>
            <?php echo $orderDetail->user->address; ?>,  <?php echo $orderDetail->user->postcode; ?><br>
            Phone: <?php echo $orderDetail->user->phone; ?><br>
            Email: <?php echo $orderDetail->user->email; ?>
          </address>
        </div>
		
		    <div class="col-sm-4 invoice-col">
          <?php if($orderDetail->take_order != 'takeaway'){ ?>
          <strong>Delivery Address:</strong>
          <address>
            <?php echo ucwords($orderDetail->user->first_name .' '.$orderDetail->user->last_name); ?><br>
            <?php echo $orderDetail->delivery_address; ?>,  <?php echo $orderDetail->delivery_postcode; ?><br>
            Phone: <?php echo $orderDetail->delivery_phone; ?><br>
          </address>
          <?php } ?>
        </div>
		
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          
          <b>Payment Type:</b> <?php echo ($orderDetail->payment_mode == 'cod')?'Cash on delivery':'Card'; ?><br>
          <b>Payment Status:</b> <?php echo ($orderDetail->payment_status == 'cod')?'Succeeded':$orderDetail->payment_status; ?><br>
          <?php if($orderDetail->payment_mode != 'cod' && !empty($orderDetail->payment_id)){ ?>
              <b>Txn Id:</b> <?php echo $orderDetail->payment_id;  ?><br>
          <?php } ?>
              <b>Order Type:</b> <?php echo ($orderDetail->take_order == 'takeaway')?'Take Away':'Home-Delivery';?><br>
              <b>Order Status:</b> <?php echo $orderDetail->order_status;?><br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
			  
              <th>Serial #</th>
              <th>Product</th>
              <th>Product Attribute</th>
              <th>Amount</th>
              <th>Qty</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
			
      			<?php 
      				if(!empty($orderDetail->order_items)){
      					$i = 1;
      					foreach($orderDetail->order_items as $order_item){ 
      					$attributes = getOrderAttributeDetail($order_item->id);
      					$iImgPath = asset('image/no_product_image.jpg');
      					  if(isset($order_item->image) && !empty($order_item->image)){
      						$iImgPath = asset('image/product/200x200/'.$order_item->image);
      					  }
      			?>

                  <?php  $categoryname = getcategoryname_byproduct_id($order_item->product_id);  ?>	
                  <tr class="<?php //echo (($order_item->is_pre_order == 1) && ($orderDetail->order_status == 'Order Confirmed')) ? 'background_color' : ''; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $order_item->product_name ?></td>
                    <td>{{$attributes['name']}}</td>
                    
                    <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($order_item->amount, 2, '.','') ?></td>
                    <td> <?php echo $order_item->qty ?></td>
                    <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($order_item->total_amount, 2, '.','') ?></td>
                  </tr>
      			<?php $i++; } } ?>
            
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          <img src="{{ asset('css/img/credit/visa.png') }}" alt="Visa">
          <img src="{{ asset('css/img/credit/mastercard.png') }}" alt="Mastercard">
          <img src="{{ asset('css/img/credit/american-express.png') }}" alt="American Express"><!-- 
          <img src="{{ asset('css/img/credit/paypal2.png') }}" alt="Paypal"> -->

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          
          <div class="table-responsive">
            <table class="table">
              <tbody>
              <tr>
                <th style="width:25%"></th>
                <th style="width:50%">Subtotal:</th>
                <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($orderDetail->subtotal, 2) ?></td>
              </tr>
              <!--<tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr> -->
             <?php if (!empty($orderDetail->coupon_discount)) { ?> <tr>
                <th></th>
                <?php if($orderDetail->coupon_type == 'percentage'){
                      $amount_coupon = $orderDetail->coupon_amount.'%' ;
                }else{
                  $amount_coupon = getSiteCurrencyType().' '.$orderDetail->coupon_amount;
                }  ?>
                <th>Coupon: <?php echo $orderDetail->coupon_code; ?>  <br/>(Discount: <?php echo number_format($amount_coupon, 2) ?>)</th>
                <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($orderDetail->coupon_discount, 2) ?></td>
              </tr> 
              <?php } ?>              
              <tr>
                <th></th>
                <th>Tax:</th>
                <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($orderDetail->tax_amount, 2) ?></td>
              </tr>              
              <tr>
                <th></th>
                <th>Shipping:</th>
                <td><?php echo getSiteCurrencyType(); ?><?php echo (!empty($orderDetail->shippingamount))?number_format($orderDetail->shippingamount, 2):0; ?></td>
              </tr>              
              <tr>
                <th></th>
                <th>Total:</th>
                <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($orderDetail->total_amount, 2); ?></td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <!--<div class="row no-print">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div> -->
	  
	 <?php if($orderDetail->take_order == 'takeaway'){ ?>
      <div class="row">
          <div class="col-xs-12">
          
            <ol class="progtrckr" data-progtrckr-steps="4">
              <li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['confirmed']) ? 'done' : 'todo'; ?>">Order Confirmed <?php echo isset($orderDeliveryStatusArr['confirmed']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['confirmed']->updated_at)).')' : '';  ?></li><!--
             --><li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['preparing_food']) ? 'done' : 'todo'; ?>">Food Pack and Assign <?php echo isset($orderDeliveryStatusArr['preparing_food']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['preparing_food']->updated_at)).')' : '';  ?></li><!--
             --><li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['food_prepared_packed']) ? 'done' : 'todo'; ?>">Out For Delivery <?php echo isset($orderDeliveryStatusArr['food_prepared_packed']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['food_prepared_packed']->updated_at)).')' : '';  ?></li><!--
             --><li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['food_collected']) ? 'done' : 'todo'; ?>">Delivered <?php echo isset($orderDeliveryStatusArr['food_collected']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['food_collected']->updated_at)).')' : '';  ?></li>
            </ol>

          </div>
      </div>
      <div class="clearfix"></div>
      <?php 
        if(isset($orderDeliveryStatusArr['assign_staff']) && !empty($orderDeliveryStatusArr['assign_staff'])){
      ?>
      <div class="row">
            <div class="col-xs-12">
              <div class="col-xs-4 col-xs-offset-3">
              
                <p class="text-muted well well-sm no-shadow" style="margin-top: 20px;">
                <?php if(!empty($deliveryUserDetailArr)){ ?>
                  <span><strong>Name: </strong> <?php echo $deliveryUserDetailArr['name']; ?></span><br/>
                  <span><strong>Email: </strong> <?php echo $deliveryUserDetailArr['email']; ?></span><br/>
                  <span><strong>Phone: </strong> <?php echo isset($deliveryUserDetailArr['phone']) ? $deliveryUserDetailArr['phone'] : ''; ?></span><br/>
                  <span><strong>Mobile: </strong> <?php echo isset($deliveryUserDetailArr['mobile']) ? $deliveryUserDetailArr['mobile'] : ''; ?></span>
                  
                <?php } ?>
                </p>
              </div>
            </div>
      </div>
      <?php  } ?>
      <div class="row">
        <div class="col-xs-12">

          <h3>Assign Delivery Staff</h3>
          </hr>
          <form action="<?php echo url('/').'/admin/orders/update_delivery_satff' ?>" enctype="multipart/form-data" method="POST" >
                 {{ csrf_field() }}

            <div class="form-group">
            <div class="col-xs-6">
              <label for="exampleInputEmail1">Delivery Staff</label>
              <select class="form-control delivery_staff_id" name="staff_id" required>
                <option value="">-Select-</option>
                <option value="admin">Admin</option>
                <?php 
                  if(!empty($staffs)){
                    foreach($staffs as $staff){
                ?>
                  <option value="<?php echo $staff->id; ?>"><?php echo $staff->first_name.' '.$staff->last_name; ?></option>
                <?php     
                    }
                  }
                ?>
              </select>
            </div>

            <div class="col-xs-6 order_status"  style="display:none">     
                <label for="exampleInputEmail1">Order Status</label>
                <?php $orderStatusArr = array('assign_staff' => 'Food Pack and Assign', 'out_for_delivery'=>'Out For Delivery','delivered'=>'Delivered'); ?>
                <select class="form-control " name="order_status">
                  <option value="">- Select -</option>
                  <?php 
                    if(!empty($orderStatusArr)){
                      foreach($orderStatusArr as $key => $order_status){
                  ?>
                    <option value="<?php echo $key.'~'.$order_status; ?>"><?php echo $order_status ?></option>
                  <?php 
                      }
                    }
                  ?>
                </select>
                
            </div> 
            </div> 

            <div class="clearfix"></div>
            <input type="hidden" name="order_number" value="<?php echo $orderDetail->order_number; ?>">
            <div class="box-footer">
             <label for="exampleInputEmail1"></label>
                  <button type="submit" id="submitbutton" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
   <?php }else{ ?>
      <div class="row">
          <div class="col-xs-12">
      		
      			<ol class="progtrckr" data-progtrckr-steps="4">
      				<li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['confirmed']) ? 'done' : 'todo'; ?>">Order Confirmed <?php echo isset($orderDeliveryStatusArr['confirmed']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['confirmed']->updated_at)).')' : '';  ?></li><!--
      			 --><li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['assign_staff']) ? 'done' : 'todo'; ?>">Food Pack and Assign <?php echo isset($orderDeliveryStatusArr['assign_staff']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['assign_staff']->updated_at)).')' : '';  ?></li><!--
      			 --><li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['out_for_delivery']) ? 'done' : 'todo'; ?>">Out For Delivery <?php echo isset($orderDeliveryStatusArr['out_for_delivery']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['out_for_delivery']->updated_at)).')' : '';  ?></li><!--
      			 --><li class="progtrckr-<?php echo isset($orderDeliveryStatusArr['delivered']) ? 'done' : 'todo'; ?>">Delivered <?php echo isset($orderDeliveryStatusArr['delivered']) ? '('.date('h:i A', strtotime($orderDeliveryStatusArr['delivered']->updated_at)).')' : '';  ?></li>
      		  </ol>

  		    </div>
      </div>
      <div class="clearfix"></div>
    	<?php 
    		if(isset($orderDeliveryStatusArr['assign_staff']) && !empty($orderDeliveryStatusArr['assign_staff'])){
    	?>
    	<div class="row">
            <div class="col-xs-12">
      				<div class="col-xs-4 col-xs-offset-3">
      				
      					<p class="text-muted well well-sm no-shadow" style="margin-top: 20px;">
      					<?php if(!empty($deliveryUserDetailArr)){ ?>
      						<span><strong>Name: </strong> <?php echo $deliveryUserDetailArr['name']; ?></span><br/>
      						<span><strong>Email: </strong> <?php echo $deliveryUserDetailArr['email']; ?></span><br/>
      						<span><strong>Phone: </strong> <?php echo isset($deliveryUserDetailArr['phone']) ? $deliveryUserDetailArr['phone'] : ''; ?></span><br/>
      						<span><strong>Mobile: </strong> <?php echo isset($deliveryUserDetailArr['mobile']) ? $deliveryUserDetailArr['mobile'] : ''; ?></span>
      						
      					<?php } ?>
      					</p>
      				</div>
    		    </div>
    	</div>
    	<?php  } ?>
      <div class="row">
        <div class="col-xs-12">

      		<h3>Assign Delivery Staff</h3>
      		</hr>
      		<form action="<?php echo url('/').'/admin/orders/update_delivery_satff' ?>" enctype="multipart/form-data" method="POST" >
                 {{ csrf_field() }}

            <div class="form-group">
            <div class="col-xs-6">
              <label for="exampleInputEmail1">Delivery Staff</label>
              <select class="form-control delivery_staff_id" name="staff_id" required>
                <option value="">-Select-</option>
                <option value="admin">Admin</option>
              	<?php 
              		if(!empty($staffs)){
              			foreach($staffs as $staff){
              	?>
              		<option value="<?php echo $staff->id; ?>"><?php echo $staff->first_name.' '.$staff->last_name; ?></option>
              	<?php			
              			}
              		}
              	?>
              </select>
            </div>

            <div class="col-xs-6 order_status"  style="display:none">			
            	  <label for="exampleInputEmail1">Order Status</label>
            	  <?php $orderStatusArr = array('assign_staff' => 'Food Pack and Assign', 'out_for_delivery'=>'Out For Delivery','delivered'=>'Delivered'); ?>
            	  <select class="form-control " name="order_status">
            			<option value="">- Select -</option>
            			<?php 
            				if(!empty($orderStatusArr)){
            					foreach($orderStatusArr as $key => $order_status){
            			?>
            				<option value="<?php echo $key.'~'.$order_status; ?>"><?php echo $order_status ?></option>
            			<?php 
            					}
            				}
            			?>
            	  </select>
            	  
            </div> 
            </div> 

            <div class="clearfix"></div>
            <input type="hidden" name="order_number" value="<?php echo $orderDetail->order_number; ?>">
            <div class="box-footer">
             <label for="exampleInputEmail1"></label>
                  <button type="submit" id="submitbutton" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
  <?php } ?>
	  
	 
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
	
	
	
	

<style>
ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3.5em;
}

ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}

ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 2.2em;
    width: 2.2em;
    line-height: 2.2em;
    border: none;
    border-radius: 2.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 2.2em;
    bottom: -1.2em;
}


</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
	/**/
	$(document).ready(function(){
		$('.delivery_staff_id').change(function(){
		 var staff_id = $(this).val();
			if(staff_id == "admin"){
				$('.order_status').show();
			}else{
				$('.order_status').hide();
			}
		})
	})
	
</script>
  
@endsection
