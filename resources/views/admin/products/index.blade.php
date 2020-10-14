@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Product Manager</a></li>
      </ol>
    </section>
    <!-- Main content -->
   <section class="content-header">
      <div class="row">
      <div class="col-xs-12">
          <!-- Horizontal Form -->
          <div class="box ">
           
            <form class="form-horizontal" action="" method="get" name="search_method">
              <div class="box-body">

                <label for="inputEmail3" class="col-sm-2">Product Searching :-</label>
                <div  class="col-sm-10">
                <div class="form-group">
                   <div class="col-xs-3">
                    <input type="text" class="form-control" name="data[name]" value="<?php echo (isset($_REQUEST['data']['name'])) ?$_REQUEST['data']['name']:'';?>" placeholder="Enter Product Name">
                  </div>

                  <div class="col-xs-3">
                    <select class="form-control" name="data[category_id]" >
                      <option value="">-Select Category-</option>
                        @foreach($category_list as $category)
                            <option  value="{{ $category->id }}" <?php echo (isset($_REQUEST['data']['category_id']) && ($_REQUEST['data']['category_id'] == $category->id)) ?'selected':'';?>>{{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-xs-2">
                     <button type="Submit" class="btn btn-block btn-info">Search</button>                     
                  </div>
                  <div class="col-xs-2">
                      <a href="{{ URL::to('admin/products') }}" class="btn btn-block btn-danger">Reset</a>
                  </div>
                </div>
                
              </div>
              </div>
              <!-- /.box-body -->
              
              <!-- /.box-footer -->
            </form>
          </div>
     
        </div>
      </div>
    </section>
    <section class="content" style="min-height: 29px;">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
                 
			         <h3 class="box-title"><a href="{{ URL::to('admin/products/add/') }}" class="btn float-right btn-block btn-primary">Add New</a> </h3>
                 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No.</th><!-- 
                  <th>Main Category</th>
                  <th>Sub Category</th> -->
                  <th>Category</th>
                  <th>Product Name</th>
                  <th>Status</th>
                  <th>Product status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
        //echo '<pre>';print_r($products[0]);die;
				
				if (isset($products[0]) && !empty($products)) {
					
				 $index = 0;
				 foreach ($products as $product_data): 
        //echo '<pre>';print_r($product_data->category['name']);die;
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td><!-- 
            <td><?php echo ucwords($product_data->category['name']); ?></td>   -->          
            <td><?php echo ucwords($product_data->categorysub['name']); ?></td>            
            <td><?php echo $product_data['name']; ?></td>     				  
            <td><?php echo ($product_data['status'] == 1) ? '<small class="label bg-green">Active</small>' : '<small class="label bg-red">Inactive</small>'; ?></td>

					  <td><?php echo ($product_data['is_popular'] == 1) ? '<small class="label bg-green">Popular</small>' : '<small class="label bg-yellow">Normal</small>'; ?></td>
					  <td><?php echo (date('Y-m-d',strtotime($product_data['created_at']))); ?></td>
					  
					 <td><a href="{{ URL::to('admin/products/edit/'.$product_data['id']) }}"><i class="fa fa-edit"></i></a>
  					
  					    <a  onclick="return confirm('Are you sure?');" href="{{ URL::to('admin/products/delete/'.$product_data['id']) }}" ><i class="fa fa-trash"></i></a><br>

                <a class="btn btn-info btn-xs" href="{{ URL::to('admin/products/add_more_image/'.$product_data['id']) }}"><i class="fa fa-plus-circle"></i> Images</a> &nbsp;
                <a class="btn btn-info btn-xs" href="{{ URL::to('admin/products/view_reviews/'.$product_data['id']) }}"> View Review & Ratings</a>

                <!-- <a class="btn btn-info btn-xs" href="{{ URL::to('admin/products/add_feature/'.$product_data['id']) }}"><i class="fa fa-plus-circle"></i> Features</a> -->
					  </td>
            
					</tr>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $products->render() !!}
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



