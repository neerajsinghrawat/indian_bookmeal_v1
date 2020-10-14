@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo URL::to('/'); ?>/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo URL::to('/'); ?>/admin/orders">Order Manager</a></li>
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
                  <th>Total</th>
                  <th>Date</th>
                  <th>Payment Status</th>
                  <th>Take</th>
                  <th>Order Status</th>
                  <th>Payment Mode</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($orders) && !empty($orders)) {
					
				 $index = 0;
				 foreach ($orders as $order): 
				 $index++;
				 ?>
         <?php  $preorder = getpreorder_byorder_id($order->id);  ?>  
					<tr class="<?php echo (($order->order_status == 'Order Confirmed'))?'background_color':''; ?>">
					  <td><?php echo $index; ?></td>
            <td><?php echo $order->order_number; ?></td>           
					  <td><?php echo ucwords($order->user['first_name'] .' '.$order->user['last_name']); ?></td>					  
					  <td><?php echo $order->user['email']; ?></td>
					  <td><?php echo getSiteCurrencyType(); ?><?php echo number_format($order->total_amount, 2, '.',''); ?></td>
					  <td><?php echo date('d/m/Y H:i A', strtotime($order->created_at)); ?></td>
            <td><?php echo $order->payment_status; ?></td>
					  <td><?php echo (!empty($order->take_order))?ucfirst($order->take_order):'Delivery'; ?></td>
            <td><small class="label bg-green"><?php echo $order->order_status; ?></small></td>            
					  <td>{{($order->payment_mode == 'cod')?'Cash on delivery':'Paid'}}</td>					  
					  <td><a href="{{ URL::to('admin/orders/'.$order->order_number) }}"><i class="fa fa-eye"></i></a>
					  </td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $orders->render() !!}
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



