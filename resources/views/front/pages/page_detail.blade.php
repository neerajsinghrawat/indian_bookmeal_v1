@extends('layouts.front')
@section('title', (!empty($pageabout_us->meta_title))? $pageabout_us->meta_title:'Page')
@section('description', (!empty($pageabout_us->meta_description))? $pageabout_us->meta_description:'')
@section('keywords', (!empty($pageabout_us->meta_keyword))? $pageabout_us->meta_keyword:'')
@section('content')
                       <!-- Breadcrumb Start -->
            <div class="bread-crumb">
                <div class="container">
                    <div class="matter">
                        <h2><?php echo (!empty($pageabout_us->name))? ucwords($pageabout_us->name):''; ?></h2>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="<?php echo URL::to('/'); ?>">HOME</a></li>
                            <li class="list-inline-item"><a href="#"><?php echo (!empty($pageabout_us->name))? ucwords($pageabout_us->name):''; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->





            <!-- Service Start  -->
            <div class="service">
                <div class="container">
                    <div class="row ">
                        <!-- Title Content Start -->
                        <div class="col-sm-12 col-xs-12 commontop text-center">
                            <h4><?php echo (!empty($pageabout_us->name))? ucwords($pageabout_us->name):'' ; ?></h4>
                            <div class="divider style-1 center">
                                <span class="hr-simple left"></span>
                                <i class="icofont icofont-ui-press hr-icon"></i>
                                <span class="hr-simple right"></span>
                            </div>
                            <?php echo (!empty($pageabout_us->description))? ucwords($pageabout_us->description):''; ?>
                        </div>
                        <!-- Title Content End -->

                    </div>
                </div>
            </div>
            <!-- Service End   -->


@endsection
