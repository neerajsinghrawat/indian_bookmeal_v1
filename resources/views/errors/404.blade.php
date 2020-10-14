@extends('layouts.front')

@section('content')



            <!-- Breadcrumb Start -->
            <div class="bread-crumb">
                <div class="container">
                    <div class="matter">
                        <h2>Page Not Found</h2>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="<?php echo URL::to('/'); ?>">HOME</a></li>
                            <li class="list-inline-item"><a href="#">Page not found</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->


            <!-- Service Start  -->
            <div class="page-not-found">
                <div class="container">
                    <div class="row ">
                        <div class="col-sm-12 col-xs-12">

                        </div>

                        <!-- Title Content Start -->
                        <div class="col-sm-12 col-xs-12 commontop text-center">
                            <h4>Page not found!</h4>
                            <div class="divider style-1 center">
                                <span class="hr-simple left"></span>
                                <i class="icofont icofont-ui-press hr-icon"></i>
                                <span class="hr-simple right"></span>
                            </div>
                            <div class="error-content">
                                <h2>404</h2>
                                <h3>Oops! Looks like something going rong</h3>
                                <p>We can’t seem to find the page you’re looking for make sure that you have typed the currect URL</p>
                                <a class="btn btn-theme btn-wide" href="<?php echo URL::to('/'); ?>">Go to home</a>
                            </div>
                        </div>
                        <!-- Title Content End -->

                    </div>
                </div>
            </div>
            <!-- Service End   -->

  
@endsection


