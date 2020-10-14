@extends('layouts.staff')

@section('content')
    <!-- Content Header (Page header) -->

<meta name="csrf-token" content="{{ csrf_token() }}" />
    <section class="content-header">
      <h1>
        Order List
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo URL::to('/'); ?>/staff"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo URL::to('/'); ?>/staff/orders">Order List</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
                 
			        
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Order ID</th>
                  <th>Customer</th>
                  <th>Email</th>
                  <th>Mobile No.</th>
                  <th>Total</th>
                  <th>Date</th>
                  <th>Payment Status</th>
                  <th>Order Status</th>
                  <th>Take</th>
                  <th>Action</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($order_list) && !empty($order_list)) {
					
				 $index = 0;
				 foreach ($order_list as $order): 

         //echo '<pre>';print_r($order);die;
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td>
            <td><?php echo $order->order['order_number']; ?></td>  
            <?php $user_detail = getuserdetail_byid($order->order['user_id']); ?>

					  <td><?php echo ((!empty($user_detail)) && (!empty($user_detail->username)))?$user_detail->username:''; ?></td>					  
            <td><?php echo ((!empty($user_detail)) && (!empty($user_detail->email)))?$user_detail->email:''; ?></td>
					  <td><?php echo ((!empty($user_detail)) && (!empty($user_detail->phone)))?$user_detail->phone:''; ?></td>
					  <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($order->order['total_amount'], 2, '.',''); ?></td>
					  <td><?php echo date('d/m/Y H:i A', strtotime($order->order['created_at'])); ?></td>
					  <td><?php echo $order->order['payment_status']; ?></td>
            <td><small class="label bg-green"><?php echo $order->order['order_status']; ?></small></td>
            <td><?php echo (!empty($order->take_order))?ucfirst($order->take_order):'Delivery'; ?></td>           
					   
            
            <td>
              <?php if($order->order['order_status'] != 'Delivered'){ ?>
              <select name="order_status" class="order_status" order_status="<?php echo $order->order['order_status']; ?>" order_number="{{ $order->order['order_number'] }}">
            <option value="">- Select Status -</option>     
             <?php if($order->order['order_status'] != 'Out For Delivery'){ ?><option value="out_for_delivery~Out For Delivery">Out For Delivery</option> <?php } ?>   
            <option value="delivered~Delivered">Delivered</option>     
            </select>
            <?php } ?></td>
            
					  
					 <td><a href="{{ URL::to('staff/orders/'.$order->order['order_number']) }}"><i class="fa fa-eye"></i></a>
  					
  					   
					  </td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $order_list->render() !!}
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

 
@endsection
<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
      var baseUrl = '{{ URL::to('/') }}';
     $('.order_status').change(function(){
        var order_status = $(this).val();
        var order_number = $(this).attr('order_number');

              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       // alert(CSRF_TOKEN);
      $.ajax({
      
      url: baseUrl+'/staff/orders/update_delivery_satff',
      
      type: 'post',
      
      data: {order_status: order_status,order_number: order_number,_token: CSRF_TOKEN},
      
      dataType: 'html',
      
      success: function(result) {
      
      if (result == 1) {
        location.reload();
      }
      
      }
      
      });

    });
  });
</script>


