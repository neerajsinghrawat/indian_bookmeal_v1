@extends('layouts.staff')

@section('content')

   

   
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order ID
        <small><?php echo $orderDetail->order_number; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo URL::to('/'); ?>/staff"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo URL::to('/'); ?>/staff/orders">Orders</a></li>
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
          To
          <address>
            <strong><?php echo ucwords($orderDetail->user->first_name .' '.$orderDetail->user->last_name); ?></strong><br>
            <?php echo $orderDetail->user->address; ?>,  <?php echo $orderDetail->user->postcode; ?><br>
            Phone: <?php echo $orderDetail->user->phone; ?><br>
            Email: <?php echo $orderDetail->user->email; ?>
          </address>
        </div>


        <div class="col-sm-4 invoice-col">
          <strong>Delivery Address:</strong>
          <address>
            <?php echo ucwords($orderDetail->user->first_name .' '.$orderDetail->user->last_name); ?><br>
            <?php echo $orderDetail->delivery_address; ?>,  <?php echo $orderDetail->delivery_postcode; ?><br>
            Phone: <?php echo $orderDetail->delivery_phone; ?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Payment Type:</b> <?php echo ($orderDetail->payment_mode == 'cod')?'Cash on delivery':'Card'; ?><br>
          <b>Payment Status:</b> <?php echo ($orderDetail->payment_status == 'cod')?'Succeeded':$orderDetail->payment_status; ?><br>
          <?php if($orderDetail->payment_mode != 'cod' && !empty($orderDetail->payment_id)){ ?>
              <b>Txn Id:</b> <?php echo $orderDetail->payment_id;  ?><br>
          <?php } ?>
              <b>Order Type:</b> <?php echo ($orderDetail->take_order == 'takeaway')?'Take-Away':'Home-Delivery';?><br>
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
              <th>Amount</th>
              <th>Qty</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
			
			<?php 
				if(!empty($orderDetail->order_items)){
					$i = 1;
					foreach($orderDetail->order_items as $order_item){ 
					
					$iImgPath = asset('image/no_product_image.jpg');
					  if(isset($order_item->image) && !empty($order_item->image)){
						$iImgPath = asset('image/product/200x200/'.$order_item->image);
					  }
			?>
			
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $order_item->product_name ?></td>
              <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($order_item->amount, 2, '.',''); ?></td>
              <td> <?php echo $order_item->qty ?></td>
              <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($order_item->total_amount, 2, '.',''); ?></td>
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
          <img src="{{ asset('css/img/credit/american-express.png') }}" alt="American Express">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%">Subtotal:</th>
                <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($orderDetail->total_amount, 2) ?></td>
              </tr>
              <!--<tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr> -->
              <tr>
                <th>Total:</th>
                <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($orderDetail->total_amount, 2) ?></td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


	  
	  

	  
	  
	 
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  
@endsection
