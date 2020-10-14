@extends('layouts.admin')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Staff Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Staff Manager</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
                 
			         <h3 class="box-title"><a href="{{ URL::to('admin/staffs/add') }}" class="btn float-right btn-block btn-primary">Add New</a> </h3>
                 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No.</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Mobile No.</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($staffs[0]) && !empty($staffs)) {
					
				 $index = 0;
				 foreach ($staffs as $staff): 
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td>
            <td><?php echo $staff['first_name']; ?></td>           
            <td><?php echo $staff['last_name']; ?></td>           
            <td><?php echo $staff['email']; ?></td>           
            <td><?php echo $staff['phone']; ?></td>           
					  				  
					  <td><?php echo ($staff['status'] == 1) ? '<small class="label bg-green">Active</small>' : '<small class="label bg-red">Inactive</small>'; ?></td>
					  <td><?php echo (date('d-m-Y',strtotime($staff['created_at']))); ?></td>
					  
					 <td><a href="{{ URL::to('admin/staffs/edit/'.$staff['id']) }}"><i class="fa fa-edit"></i></a>
  					
<!--   					    <a href="{{ URL::to('admin/staffs/delete/'.$staff['id']) }}" ><i class="fa fa-trash" ></i></a> -->
					  </td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $staffs->render() !!}
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

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



