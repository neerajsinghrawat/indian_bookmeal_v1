@extends('layouts.admin')

@section('content')
<section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo URL::to('/'); ?>/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo URL::to('/'); ?>/admin/users">Users</a></li>
        <li class="active"><?php echo $userDetail->first_name . ' '.$userDetail->last_name ?></li>
      </ol>
    </section>

   <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $userDetail->first_name . ' '.$userDetail->last_name; ?></h3>

              <p class="text-muted text-center">Email: <?php echo $userDetail->email;  ?></p>
              <p class="text-muted text-center">Phone: <?php echo $userDetail->phone;  ?></p>
              <p class="text-muted text-center">Address: <?php echo $userDetail->address.', '.$userDetail->postcode;  ?></p>

              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
         <!-- <div class="box box-primary">
            <div class="box-header with-border">
            </div>
              <h3 class="box-title">Contact</h3>
            
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            
          </div> -->
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Active (<?php echo count($activeComplaintArr); ?>)</a></li>
              <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Resolved (<?php echo count($resolvedComplaintArr); ?>)</a></li>
              <!--<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Settings</a></li> -->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
                <!-- Post -->
				<?php  
					if(!empty($activeComplaintArr) && count($activeComplaintArr) >0){ 
						foreach($activeComplaintArr as $key => $active_complaint){
						
					
				?>
                <div class="post" id="<?php echo $key ?>">
                  <div class="user-block">
                    
                        <span class="username">
                          <a href="javascript:void(0)"> ORDER ID: <?php echo $key ?>
							<?php 
							$i = 1;
							foreach($active_complaint as $complaint){ 
								if($i == 1){
									echo $complaint['subject'];
								}
							$i++; } ?>
						  </a>
                         <!-- <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a> -->
                        </span>
                    <!--<span class="description">Shared publicly - 7:30 PM today</span> -->
                  </div>
                  <!-- /.user-block -->
                  <?php foreach($active_complaint as $complaint){  ?>
					<div class="<?php echo ($complaint['user_type'] == 'customer') ? 'user' : 'admin'; ?>_complaint_text"><span class="complaint_usertype"><?php echo ($complaint['user_type'] == 'customer') ? 'You: ' : 'Admin: '; ?></span> <!--<span class="complaint_subject"><?php echo $complaint['subject']; ?></span><br/>-->
					<span class="complaint_problem"><?php echo $complaint['problem']; ?> <br/><?php echo $complaint['created_at']; ?></span>
					</span>
						</div>
				<?php } ?>
				
				
				 <form action="{{ url('admin/users/save_complaint') }}" enctype="multipart/form-data" method="POST" >
				{{ csrf_field() }}
					<div class="col-md-12">Send Reply:</div>
					<div class="col-md-10">
						<input class="form-control input-sm" type="text" name="problem" placeholder="Type a comment">
					</div>
					<div class="col-md-2">
					<?php 
						$i = 1; 
						foreach($active_complaint as $complaint){
							if($i == 1){
					?>
					  <input type="hidden" name="order_number"  value="<?php echo (isset($complaint['order_number'])) ? $complaint['order_number'] : ''; ?>">
					  <input type="hidden" name="user_id" value="<?php echo (isset($complaint['user_id'])) ? $complaint['user_id'] : ''; ?>">
					<?php  } $i++; } ?>
					  <input type="submit" name="submitComplaint" class='btn btn-default' value="Send">
					</div>
					<div class="clearfix"></div>
				</form>
                </div>
				<?php } } ?>
                <!-- /.post -->
			</div>
			
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <?php 
					if(!empty($resolvedComplaintArr) && count($resolvedComplaintArr) >0){ 
						foreach($resolvedComplaintArr as $key => $resolved_complaint){ 
					
				?>
                <div class="post">
                  <div class="user-block">
                    
                        <span class="username">
                          <a href="#"> ORDER ID: <?php echo $key ?>
							<?php 
							$i = 1;
							foreach($resolved_complaint as $complaint){ 
								if($i == 1){
									echo $complaint['subject'];
								}
							$i++; } ?>
						  </a>
                         <!-- <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a> -->
                        </span>
                    <!--<span class="description">Shared publicly - 7:30 PM today</span> -->
                  </div>
                  <!-- /.user-block -->
                  <?php foreach($resolved_complaint as $complaint){  ?>
					<div class="<?php echo ($complaint['user_type'] == 'customer') ? 'user' : 'admin'; ?>_complaint_text"><span class="complaint_usertype"><?php echo ($complaint['user_type'] == 'customer') ? 'You: ' : 'Admin: '; ?></span> <!--<span class="complaint_subject"><?php echo $complaint['subject']; ?></span><br/>-->
					<span class="complaint_problem"><?php echo $complaint['problem']; ?> <br/><?php echo $complaint['created_at']; ?></span>
					</span>
						</div>
				<?php } ?>
				
				<!-- <form action="{{ url('admin/users/save_complaint') }}" enctype="multipart/form-data" method="POST" >
				{{ csrf_field() }}
					<div class="col-md-12">Send Reply:</div>
					<div class="col-md-10">
						<input class="form-control input-sm" type="text" name="problem" placeholder="Type a comment">
					</div>
					<div class="col-md-2">
					  <input type="hidden" name="order_number"  value="<?php echo (isset($resolved_complaint[0]['order_number'])) ? $resolved_complaint[0]['order_number'] : ''; ?>">
					  <input type="hidden" name="user_id" value="<?php echo (isset($resolved_complaint[0]['user_id'])) ? $resolved_complaint[0]['user_id'] : ''; ?>">
					  <input type="submit" name="submitComplaint" class='btn btn-default' value="Send">
					</div>
					<div class="clearfix"></div>
				</form> -->
                  
                </div>
				<?php } } ?>
			 </div>
              <!-- /.tab-pane -->

              <!--<div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              -->
			  <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    <div><div class="row docs-premium-template">
                    <div class="col-sm-12 col-md-12">
                <div class="box box-solid">
                    <div class="box-body">
                        <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                            Orders
                        </h4>
                        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>S.No.</th>
              <th>Order ID</th>
              <th>Amount</th>
              <th>Payment Status</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php
				if(!empty($orders)){
					$i = 1;
					foreach($orders as $order){
					
			?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $order->order_number; ?></td>
              <td>$<?php echo $order->total_amount; ?></td>
              <td><?php echo $order->payment_status; ?></td>
              <td><?php echo date('d M Y H:i A', strtotime($order->created_at)); ?></td>
              <td><a href="{{ URL::to('admin/orders/'.$order['order_number']) }}"><i class="fa fa-eye"></i></a></td>
            </tr>
				<?php $i++; } } ?>
            
            </tbody>
          </table>
        </div>

						</div>
                </div>
            </div>
			
			</div>
</div></section>
@endsection



