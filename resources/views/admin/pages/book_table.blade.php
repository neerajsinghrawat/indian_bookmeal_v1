@extends('layouts.admin')
<?php $timearray = getTimeArr(); ?>

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Table Reservations Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Table Reservations Manager</a></li>
      </ol>
    </section>
   <section class="content-header">
      <div class="row">
      <div class="col-xs-12">
          <!-- Horizontal Form -->
          <div class="box ">
           
            <form class="form-horizontal" action="{{ URL::to('admin/book_table') }}" method="get" name="search_method">
              <div class="box-body">

                <label for="inputEmail3" class="col-sm-12">Searching :-</label>
                <div  class="col-sm-12">
                <div class="form-group">
                  <div class="col-xs-2">
                    <input type="text" class="form-control" name="data[name]" value="<?php echo (isset($_REQUEST['data']['name'])) ?$_REQUEST['data']['name']:'';?>" placeholder="Enter Name">
                  </div>
                  <div class="col-xs-2">
                    <input type="text" class="form-control" name="data[phone]" value="<?php echo (isset($_REQUEST['data']['phone'])) ?$_REQUEST['data']['phone']:'';?>" placeholder="Enter Phone">
                  </div>
                  <div class="col-xs-2">
                    <input type="email" class="form-control" name="data[email]" value="<?php echo (isset($_REQUEST['data']['email'])) ?$_REQUEST['data']['email']:'';?>" placeholder="Enter Email">
                  </div>
                  <div class="col-xs-2">                    
                    <input type="date" name="data[reservation_date]" class="form-control" id="date" value="<?php echo (isset($_REQUEST['data']['reservation_date'])) ?$_REQUEST['data']['reservation_date']:'';?>" placeholder="Enter Date" >
                  </div>
                  <div class="col-xs-2">  
                    <select name="data[reservation_time]" class="form-control">
                      <option value="">-Select Time-</option>
                        <?php foreach ($timearray as $value) {
                             ?>
                        <option value="{{$value}}" <?php echo (isset($_REQUEST['data']['reservation_time']) && $_REQUEST['data']['reservation_time'] == $value) ?'selected':'';?>>{{$value}}</option>
                        <?php } ?>
                    </select>
                  </div>
                                                    
                                                    
                  
                  <div class="col-xs-1">
                     <button type="Submit" class="btn btn-block btn-info">Search</button>                     
                  </div>
                  <div class="col-xs-1">
                      <a href="{{ URL::to('admin/book_table') }}" class="btn btn-block btn-danger">Reset</a>
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
                  <th>Name</th>
                  <th>Phone No.</th>
                  <th>Email</th>
                  <th>Table Book date</th>
                  <th>Time</th>
                  <th>People Count</th>
                  <th>Created</th>

                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($tableReservations[0]) && !empty($tableReservations)) {
					
				 $index = 0;
				 foreach ($tableReservations as $contact): 
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td>
            <td><?php echo $contact->name; ?></td>          
            <td><?php echo $contact->phone; ?></td>          
            <td><?php echo $contact->email; ?></td>         
            <td><?php echo (date('d-m-Y',strtotime($contact->reservation_date))); ?></td>         
            <td><?php echo (date('h:i A',strtotime($contact->reservation_time))); ?></td>         
            <td><?php echo $contact->people_count; ?></td>	
            <td><?php echo (date('d-m-Y',strtotime($contact['created_at']))); ?></td>
            
            
					</tr>

          
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $tableReservations->render() !!}
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



