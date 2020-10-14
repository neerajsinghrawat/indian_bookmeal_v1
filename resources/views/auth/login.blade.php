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
                                    <h4 class="mb-0">Login</h4>
                                    <p class="lead text-muted mb-0">Don't have an account? So <a href="{{ route('register') }}">Register</a> And starts less than a minute</p></p>
                                </div>
                            </div>
                           
                            <form method="post" enctype="multipart/form-data" autocomplete="off" action="{{ route('login') }}">
                            {{ csrf_field() }}
                                <div class="utility-box-content">
                                            <div class="form-group">
                                                <i class="icofont icofont-ui-message"></i><input type="email" name="email" value="" placeholder="EMAIL" id="email" class="form-control" required/>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group">
                                                <i class="icofont icofont-lock"></i><input type="password" name="password" value="" placeholder="PASSWORD" id="input-password" class="form-control" required/>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                            <a class="float-right" href="{{ url('/forgot-password') }}">Forgot Password?</a>
                                </div>
                                <button class="utility-box-btn btn btn-secondary btn-block btn-lg" type="submit">SIGN IN</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>


            
            <!-- <div class="bread-crumb">
                <div class="container">
                    <div class="matter">
                        <h2>Login</h2>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ url('/') }}">HOME</a></li>
                            <li class="list-inline-item"><a href="#">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            

           
            <div class="login">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 commontop text-center">
                            <h4>Login to Your Account</h4>
                            <div class="divider style-1 center">
                                <span class="hr-simple left"></span>
                                <i class="icofont icofont-ui-press hr-icon"></i>
                                <span class="hr-simple right"></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur placerat nulla, in suscipit erat sodales id. Nullam ultricies eu turpis at accumsan. Mauris a sodales mi, eget lobortis nulla.</p>
                        </div>
                        <div class="col-lg-10 col-md-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="loginnow">
                                        <h5>Login</h5>
                                        <p>Don't have an account? So <a href="{{ route('register') }}">Register</a> And starts less than a minute</p>
                                        <form method="post" enctype="multipart/form-data" action="{{ route('login') }}">
                                          {{ csrf_field() }}
                                          
                                            <div class="form-group">
                                                <i class="icofont icofont-ui-message"></i><input type="email" name="email" value="" placeholder="EMAIL" id="email" class="form-control" required/>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group">
                                                <i class="icofont icofont-lock"></i><input type="password" name="password" value="" placeholder="PASSWORD" id="input-password" class="form-control" required/>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-6"><input type="submit" value="SIGN IN" class="btn btn-theme btn-md btn-wide" /></div>
                                                <div class="col-md-6">
                                                    <a class="clforgot_password" href="{{ url('/forgot-password') }}">Forgot Password?</a>
                                                </div>
                                                
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="loginto loginnow">
                                        <h5>Login via social accounts</h5>
                                        <ul class="list-unstyled text-center">
                                            <li><a href="{{ URL::to('/facebookRedirect') }}" target="_blank"><i class="icofont icofont-social-facebook"></i> Login with Facebook</a></li>
                                            <li><a href="{{ url('/twitterredirect') }}" target="_blank"><i class="icofont icofont-social-twitter"></i> Login with Twitter</a></li>
                                            <li><a href="{{ url('/redirect') }}" target="_blank"><i class="icofont icofont-social-google-plus"></i> Login with Google+</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            
@endsection
