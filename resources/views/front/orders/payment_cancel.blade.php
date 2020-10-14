@extends('layouts.front')
@section('title','Payment Cancel')
@section('description','Payment Cancel')
@section('keywords','Payment Cancel')
@section('content')

<div class="bread-crumb">
                <div class="container">
                    <div class="matter">
                        <h2>Payment Cancel</h2>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="<?php echo URL::to('/'); ?>">HOME</a></li>
                            <li class="list-inline-item"><a href="#">Payment Cancel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->
			
<!-- Service Start  -->
            <div class="page-not-found">
                <div class="container">
                    <div class="row ">
                        <!-- Title Content Start -->
                        <div class="col-sm-12 col-xs-12 commontop text-center">
                            <h4>Error</h4>
                            <div class="divider style-1 center">
                                <span class="hr-simple left"></span>
                                <i class="icofont icofont-ui-press hr-icon"></i>
                                <span class="hr-simple right"></span>
                            </div>
                            <div class="thanks-content">
                                <h3><i class="icofont icofont-close" style="color:red"></i> Error. <br>Your payment was Canceled.</h3>
                               
                                <a class="btn btn-theme btn-wide" href="<?php echo URL::to('/'); ?>">Go to home</a>
                            </div>
                        </div>
                        <!-- Title Content End -->
                    </div>
                </div>
            </div>
            <!-- Service End   -->

			
@endsection
