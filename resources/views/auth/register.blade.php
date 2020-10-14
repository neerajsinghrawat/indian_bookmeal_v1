@extends('layouts.front')
@section('title','Register')
@section('description','Register')
@section('keywords', 'Register')
@section('content')
        <section class="section section-lg bg-dark">

            <!-- Video BG -->

            <!-- BG Video -->
            <div class="bg-video dark-overlay" data-src="{{asset('/public/css/front/img/video_3.mp4')}}" data-type="video/mp4"></div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <!-- Book a Table -->
                        <div class="utility-box">
                            <div class="utility-box-title bg-dark dark">
                                <div class="bg-image"><img src="{{asset('css/front/img/modal-review.jpg')}}" alt=""></div>
                                <div>
                                    <span class="icon icon-primary"><i class="ti ti-bookmark-alt"></i></span>
                                    <h4 class="mb-0">Register</h4>

                                        
                                    <p class="lead text-muted mb-0">Do You have an account? So <a href="{{ route('login') }}">login</a> And starts less than a minute</p>
                                </div>
                            </div>
                           
                            <form method="post" enctype="multipart/form-data" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <div class="utility-box-content">

                                            <div class="form-group">
                                                <i class="icofont icofont-ui-user"></i><input type="text" name="first_name" value="" placeholder="FIRST NAME" id="input-name" class="form-control" required/>
                                            @if ($errors->has('first_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                            <div class="form-group">
                                                <i class="icofont icofont-ui-user"></i><input type="text" name="last_name" value="" placeholder="LAST NAME" id="input-name" class="form-control" required/>
                                            @if ($errors->has('last_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group">
                                                <i class="icofont icofont-ui-message"></i><input type="text" name="email" value="" placeholder="EMAIL" id="email" class="form-control" required/>
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

                                            <div class="form-group">
                                                <i class="icofont icofont-lock"></i><input type="password" name="password_confirmation" value="" placeholder="REPEAT PASSWORD" id="input-confirm" class="form-control" required/>
                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif  
                                            </div>

                                            <div class="form-group">
                                                <i class="icofont icofont-ui-user"></i><input type="phone" name="phone" value="" placeholder="PHONE NO." id="input-name" class="form-control" required/>
                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group">
                                                <i class="icofont icofont-ui-user"></i><input type="text" name="address" value="" placeholder="ADDRESS" id="input-name" class="form-control" required/>
                                             @if ($errors->has('address'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group">
                                                <i class="icofont icofont-ui-user"></i><input type="text" name="postcode" value="" placeholder="POSTCODE" id="input-name" class="form-control" required/>
                                            @if ($errors->has('postcode'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('postcode') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <!-- <div class="form-group">
                                                <div class="links">
                                                    <label><input type="checkbox" class="checkbox-inline"/> By signing up I agree with <a href="#">terms & conditions.</a> </label>
                                                </div>
                                            </div> -->
                                </div>
                                <button class="utility-box-btn btn btn-secondary btn-block btn-lg" type="submit">SIGN UP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>

@endsection
