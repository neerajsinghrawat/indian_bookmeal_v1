@extends('layouts.front')
@section('title',  (!empty($slug))?'Tag ~'.$slug:'Tag')
@section('description', (!empty($slug))? $slug:'')
@section('keywords', (!empty($slug))? $slug:'')
@section('content')

            <div class="bread-crumb">
                <div class="container">
                    <div class="matter">
                        <h2>Tag ~ {{ $slug }}</h2>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ url('/') }}">HOME</a></li>
                            <li class="list-inline-item"><a href="#">Tag</a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)">{{ $slug }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->

            <!-- Shop Start -->
            <div class="shop" style="background:none">
                <div class="container">
                    <div class="row">
                    
                        <div class="col-md-12 mainpage">
                            <!-- Product View Start -->
<div class="commontop "><h4>Tag: {{ $slug }}</h4></div>
                            

<hr/>
                            <div class="row">
                                <!-- Product List Start -->
                                <!-- Single Product Start -->
<?php if (isset($product_list) && count($product_list) > 0 ) {                                   
foreach ($product_list as $key => $product) { 
           $iImgPath = asset('image/no_product_image.jpg');
      if(isset($product['image']) && !empty($product['image'])){
        $iImgPath = asset('image/product/200x200/'.$product['image']);
      } ?>
                                <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="product-thumb">
                                        <div class="image">
                                            <a class="link" href="{{ URL::to('product/'.$product['slug']) }}"><img src="{{ $iImgPath }}" alt="Food image" title="Food image" class="img-fluid" /></a>

                                        </div>
                                        <div class="caption">
                                            <a href="{{ URL::to('product/'.$product['slug']) }}"><h4>{{ ucwords($product->name) }}</h4></a>
<!--                                     <?php  //$avg_rating = getProductAverageRating($productReviews);  ?>
                                           
                                    <div class="rating">
                                      <?php //for($i = 1; $i <=5; $i++){ ?>
                                        
                                            <i class="icofont icofont-star  <?php //echo ($i <= $avg_rating) ? 'selected_star_rating' : 'not_selected_star_rating'; ?>"></i>
                                        <?php //} ?>
                                    </div> -->
                                            <div class="price">${{ $product->price }}</div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <?php } }?>
                                <!-- Single Product End -->
                                <!-- Single Product Start -->
                               
                                <!-- Product List End -->
                            </div>
                            <!-- Product View End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Shop End -->

  
 
@endsection

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
