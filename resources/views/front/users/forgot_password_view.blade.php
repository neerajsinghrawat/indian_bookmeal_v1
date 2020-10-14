@extends('layouts.front')
@section('title','Login')
@section('description','Login')
@section('keywords', 'Login')
@section('content')
        <section class="section section-lg bg-dark">

            <!-- Video BG -->

            <!-- BG Video -->
            <div class="bg-video dark-overlay" data-src="{{asset('public/css/front/img/video_3.mp4')}}" data-type="video/mp4"></div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <!-- Book a Table -->
                        <div class="utility-box">
                            <div class="utility-box-title bg-dark dark">
                                <div class="bg-image"><img src="{{asset('css/front/img/modal-review.jpg')}}" alt=""></div>
                                <div>
                                    <span class="icon icon-primary"><i class="ti ti-bookmark-alt"></i></span>
                                    <h4 class="mb-0">Forgot Password</h4>
                                    <p class="lead text-muted mb-0">Don't have an account? So <a href="{{ route('register') }}">Register</a> And starts less than a minute</p></p>
                                </div>
                            </div>
                           
                            <form method="post" enctype="multipart/form-data" action="{{ route('forgot_password') }}">
                                          {{ csrf_field() }}
                                <div class="utility-box-content">
                                            <div class="form-group">
                                                <i class="icofont icofont-ui-message"></i><input type="email" name="email" value="" placeholder="Enter Register Email Id" id="email" class="form-control" required/>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                            
                                </div>
                                <button class="utility-box-btn btn btn-secondary btn-block btn-lg" type="submit">SEND</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
            


            <!-- Login Start -->
            <!-- <div class="login">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 commontop text-center">
                            <h4>Forgot Password</h4>
                            <div class="divider style-1 center">
                                <span class="hr-simple left"></span>
                                <i class="icofont icofont-ui-press hr-icon"></i>
                                <span class="hr-simple right"></span>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <div class="row">
                                <div class="col-sm-10 col-md-12">
                                    <div class="loginnow forgotpasswordnow">
                                        <form method="post" enctype="multipart/form-data" action="{{ route('forgot_password') }}">
                                          {{ csrf_field() }}
                                          
                                            <div class="form-group">
                                                <i class="icofont icofont-ui-message"></i><input type="email" name="email" value="" placeholder="Enter Register Email Id" id="email" class="form-control" required/>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" value="SEND" class="btn btn-theme btn-md btn-wide" />
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Login End -->
@endsection
