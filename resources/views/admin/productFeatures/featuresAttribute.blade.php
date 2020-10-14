@extends('layouts.admin')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $productFeaturedata->value }} Features Attributes
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/admin/productFeatures') }}">Product Attributes</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
                 
			         <h3 class="box-title"><a href="{{ URL::to('admin/productFeatures/addfeatures_attribute/'.$productFeaturedata->id) }}" class="btn float-right btn-block btn-primary">Add New</a> </h3>
                 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No.</th>
				          <th>Name</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($productFeatureAttributes[0]) && !empty($productFeatureAttributes)) {
					
				 $index = 0;
				 foreach ($productFeatureAttributes as $testimonial): 
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td>
					          
            <td><?php echo $testimonial['name']; ?></td>
             				  
					  <td><?php echo ($testimonial['status'] == 1) ? '<small class="label bg-green">Active</small>' : '<small class="label bg-red">Inactive</small>'; ?></td>
					  <td><?php echo (date('d-m-Y',strtotime($testimonial['created_at']))); ?></td>
					  
					 <td><a href="{{ URL::to('admin/productFeatures/editfeatures_attribute/'.$testimonial['product_feature_id'].'/'.$testimonial['id']) }}"><i class="fa fa-edit"></i></a>
            <a  onclick="return confirm('Are you sure?');" href="{{ URL::to('admin/productFeatures/deletefeatures_attribute/'.$testimonial['product_feature_id'].'/'.$testimonial['id']) }}" ><i class="fa fa-trash" ></i></a>
  					    
					  </td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $productFeatureAttributes->render() !!}
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



