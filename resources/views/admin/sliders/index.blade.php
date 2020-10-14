@extends('layouts.admin')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Slider Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Slider Manager</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
                 
			         <h3 class="box-title"><a href="{{ URL::to('admin/sliders/add') }}" class="btn float-right btn-block btn-primary">Add New</a> </h3>
                 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No.</th>
				  <th>Title</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($sliders[0]) && !empty($sliders)) {
					
				 $index = 0;
				 foreach ($sliders as $slider): 
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td>
					          
            <td><?php echo $slider['title']; ?></td>
            <td><?php $iImgPath = asset('image/slider/'.$slider['image']); ?>
			<img src="<?php echo $iImgPath ?>" class="img-thumbnail" style="max-width:100px">
			</td>  				  
					  <td><?php echo ($slider['status'] == 1) ? '<small class="label bg-green">Active</small>' : '<small class="label bg-red">Inactive</small>'; ?></td>
					  <td><?php echo (date('d-m-Y',strtotime($slider['created_at']))); ?></td>
					  
					 <td><a href="{{ URL::to('admin/sliders/edit/'.$slider['id']) }}"><i class="fa fa-edit"></i></a>
            <a  onclick="return confirm('Are you sure?');" href="{{ URL::to('admin/sliders/delete/'.$slider['id']) }}" ><i class="fa fa-trash" ></i></a>
  					
  					    
					  </td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $sliders->render() !!}
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



