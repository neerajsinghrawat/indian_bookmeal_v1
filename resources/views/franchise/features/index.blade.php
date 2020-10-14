@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Features Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Features Manager</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
                 
			         <h3 class="box-title"><a href="{{ URL::to('admin/features/add/') }}" class="btn float-right btn-block btn-primary">Add New</a> </h3>
                 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Category</th>
                  <th>Feature Name</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
        //echo '<pre>';print_r($features[0]);die;
				
				if (isset($features[0]) && !empty($features)) {
					
				 $index = 0;
				 foreach ($features as $feature): 
				 $index++;
				 ?>
					<tr>
					   <td><?php echo $index; ?></td>
            <td><?php echo ucwords($feature->category['name']); ?></td>            
            <td><?php echo $feature['name']; ?></td>           
					 <!--  <td><?php //echo $product_data['model_no']; ?></td>		 -->			  
					  <td><?php echo ($feature['status'] == 1) ? '<small class="label bg-green">Active</small>' : '<small class="label bg-red">Inactive</small>'; ?></td>
					  <td><?php echo (date('Y-m-d',strtotime($feature['created_at']))); ?></td>
					  
					    <td><a href="{{ URL::to('admin/features/edit/'.$feature['id']) }}"><i class="fa fa-edit"></i></a>
            
               <!--<a href="" ><i class="fa fa-trash"></i></a> --><br>
                <a class="btn btn-info btn-xs" href="{{ URL::to('admin/features/add_feature_value/'.$feature['id']) }}"><i class="fa fa-plus-circle"></i> Feature Value</a>
              </td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $features->render() !!}
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
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



