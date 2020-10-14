@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

<meta name="csrf-token" content="{{ csrf_token() }}" />
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
     <?php echo $productDetail->name ?>    (Rating: 
				<?php  $avg_rating = getProductAverageRating($productReviews);  
						echo $avg_rating.' of 5';  ?>
						)
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/products') }}" ><b class="a_tag_color">Product Manager</b></a></li>
        <li><b ><?php echo $productDetail->name ?></b></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            
            <div class="tab-content">
			
              <div class="active tab-pane" id="activity">
                <!-- Post -->
				<?php 
					if(!empty($productReviews)){
						foreach($productReviews as $product_review){
								$img = asset('image/no_product_image.jpg');
								if(!empty($product_review->user->picture)){
									$img = asset('image/user/150x150/'.$product_review->user->picture);
								}
				?>
                <div class="post">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="{{ $img }}" alt="user image">
                        <span class="username">
                          <a href="#"><?php echo $product_review->user->first_name .' '.$product_review->user->last_name; ?></a>
                          <a href="#" class="pull-right btn-box-tool">
							<div class="rating">Rating: <?php echo $product_review->rating.' of 5'; ?> </div>
						  </a>
                        </span>
                    <span class="description"><?php $post_time = strtotime($product_review->created_at);
													$time = time() - $post_time; // to get the time since that moment
													$time = ($time<1)? 1 : $time;
													$tokens = array (
														31536000 => 'year',
														2592000 => 'month',
														604800 => 'week',
														86400 => 'day',
														3600 => 'hour',
														60 => 'minute',
														1 => 'second'
													);
												
													foreach ($tokens as $unit => $text) {
														if ($time < $unit) continue;
														$numberOfUnits = floor($time / $unit);
														echo  $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
														break;
														 
													} ?></span>
                  </div>
                  <!-- /.user-block -->
                  <p>
                    <?php echo $product_review->review; ?>
                  </p>
                 </div>
                
				<?php } } ?>
				<!-- /.post -->

                  <!-- /.post -->
              </div>
              
			  </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      </div>
      <!-- /.row -->
    </section>
 

  
@endsection


