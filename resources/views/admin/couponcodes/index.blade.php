@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Coupon code Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Coupon code Manager</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
                 
			         <h3 class="box-title"><a href="{{ URL::to('admin/couponcodes/add') }}" class="btn float-right btn-block btn-primary">Add New</a> </h3>
                 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Coupon code</th>
                  <th>Use times</th>
                  <th>Group</th>
                  <th>Expire date</th>
                  <th>Coupon Type</th>
                  <th>Amount / Percentage </th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($couponcodes[0]) && !empty($couponcodes)) {
					
				 $index = 0;
				 foreach ($couponcodes as $couponcode): 
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td>
            <td><?php echo $couponcode['code']; ?></td>  
            <td><?php echo $couponcode['use_code_times']; ?></td>          
            <td><?php echo $couponcode->group['name']; ?></td>          
            <td><?php echo date('d-m-Y', strtotime($couponcode['expire_date'])); ?></td>          
            <td><?php echo ucwords($couponcode['coupon_type']); ?></td>          
            <td><?php echo (($couponcode['coupon_type'] == 'amount')? '$'.$couponcode['amount']: $couponcode['amount'] .' %'); ?></td>				  
					  <td><?php echo ($couponcode['status'] == 1) ? '<small class="label bg-green">Active</small>' : '<small class="label bg-red">Inactive</small>'; ?></td>
					  <td><?php echo (date('d-m-Y',strtotime($couponcode['created_at']))); ?></td>
					  
					<td>
            <a href="{{ URL::to('admin/couponcodes/edit/'.$couponcode['id']) }}"><i class="fa fa-edit"></i></a>
  					<a  onclick="return confirm('Are you sure?');" href="{{ URL::to('admin/couponcodes/delete/'.$couponcode['id']) }}" ><i class="fa fa-trash" ></i></a>    
					</td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $couponcodes->render() !!}
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

  <!-- /.content-wrapper -->

  <script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script type="text/javascript">$(document).ready(function(){
	$('#example1_paginate').css('display','none');
	$('#example1_info').css('display','none');
});</script>
  
@endsection



