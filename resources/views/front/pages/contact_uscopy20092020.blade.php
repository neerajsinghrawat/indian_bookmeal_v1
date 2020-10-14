@extends('layouts.front')
@section('title','Contact Us')
@section('description','Contact Us')
@section('keywords', 'Contact Us')
@section('content')
        <!-- Page Title -->
        <div class="page-title bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                        <h1 class="mb-0">Contact Us</h1>
                        <h4 class="text-muted mb-0">Some informations about our restaurant</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section -->
        <section class="section">

            <div class="container">
                <div class="row align-items-center">
                        <div class="col-sm-12 col-xs-12">
                            <!--  Contact form Start  -->
                       <form action="{{ route('pages.contactus_save.post') }}" class="form-horizontal" method="POST" >
                            {{ csrf_field() }}
                                <div class="form-group row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <i class="icofont icofont-ui-user"></i>
                                        <input type="text" name="name" id="input-name" class="form-control" placeholder="name" required="required" />
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <i class="icofont icofont-ui-message"></i>
                                        <input type="text" name="email" id="input-email" class="form-control" placeholder="email" required="required" />
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <i class="icofont icofont-phone"></i>   
                                        <input type="text" name="phone" id="input-phone" class="form-control" placeholder="mobile number"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <i class="icofont icofont-pencil-alt-5"></i>
                                        <textarea name="message" id="input-enquiry" class="form-control" rows="5" placeholder="message"></textarea>
                                    </div>
                                </div>
                                <div class="buttons text-center">
                                    <input class="btn btn-outline-secondary btn-sm" type="submit" value="Send Message" />
                                </div>
                            </form>
                            <!--  Contact form End  -->
                        </div>                    
                    <div class="col-lg-4 offset-lg-1 col-md-6 mb-5 mb-md-0">
                        <img src="assets/img/logo-horizontal-dark.svg" alt="" class="mb-5" width="130">
                        <h4 class="mb-0">Soup Restaurant</h4>
                        <span class="text-muted">{{ $setting->address}}</span>
                        <hr class="hr-md">
                        <div class="row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <h6 class="mb-1 text-muted">Phone:</h6>
                                {{ $setting->mobile }}<br> {{ $setting->phone }}
                            </div>
                            <div class="col-sm-6">
                                <h6 class="mb-1 text-muted">E-mail:</h6>
                                <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a><br><a href="mailto:{{ $setting->email }}">{{ $setting->email2 }}</a>
                            </div>
                        </div>
                        <hr class="hr-md">
                        <h6 class="mb-3 text-muted">Follow Us!</h6>
                       
                        <?php if(!empty($setting->facebook)){  ?>
                            <a href="<?php echo $setting->facebook;?>" target="_blank" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
                        <?php } ?>
                        <?php if(!empty($setting->twitter)){  ?> 
                            <a href="<?php echo $setting->twitter;?>" target="_blank" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a><?php } ?>
                        <?php if(!empty($setting->g_plus)){  ?> 
                            <a href="<?php echo $setting->g_plus;?>" target="_blank" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a><?php } ?>
                        <?php if(!empty($setting->youtube_link)){  ?> 
                            <a href="<?php echo $setting->youtube_link;?>" target="_blank" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
                        <?php } ?>
                    </div>
                    <div class="col-lg-5 offset-lg-2 col-md-6">
                        <iframe src="http://maps.google.com/maps?q={{ $setting->latitude}}, {{ $setting->longitude}}&z=15&output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>
                    </div>
                </div>
            </div>

        </section>


@endsection
