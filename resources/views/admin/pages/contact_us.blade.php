@extends('layouts.admin')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Contact us Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Contact us Manager</a></li>
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
                  <th>Name</th>
                  <th>Phone No.</th>
                  <th>Email</th>                  
                  <th>Message</th>
                  <th>Created</th>
                </tr>
                </thead>
                <tbody>
				<?php

				
				if (isset($contacts[0]) && !empty($contacts)) {
					
				 $index = 0;
				 foreach ($contacts as $contact): 
				 $index++;
				 ?>
					<tr>
					  <td><?php echo $index; ?></td>
            <td><?php echo $contact->name; ?></td>          
            <td><?php echo $contact->phone; ?></td>          
            <td><?php echo $contact->email; ?></td>				  
					 	<td><a href="" data-toggle="modal" data-target="#myModal_<?php echo $contact->id; ?>">Message</a></td>
            <td><?php echo (date('d-m-Y',strtotime($contact['created_at']))); ?></td>
            
            
					</tr>

          <div id="myModal_<?php echo $contact->id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Message</h4>
            </div>
            <div class="modal-body">
            <?php echo $contact->message; ?>
            </div>                 
          </div>
        </div>
      </div>
               <?php endforeach; }
               ?> 

                 </tbody>

              </table>
              {!! $contacts->render() !!}
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



