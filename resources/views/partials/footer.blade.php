
<footer id="footer" class="bg-dark dark">

    <div class="container">
        <!-- Footer 1st Row -->
        <div class="footer-first-row row">
            <div class="col-lg-3 text-center">
                <a href="{{ url('/') }}"><img src="{{ asset('image/setting/'.$setting->logo) }}" alt="logo"  class="mt-5 mb-5"></a>
            </div>
            <div class="col-lg-1 text-center"></div> 
            <div class="col-lg-4 col-md-6">
                <h5 class="text-muted">{{ $setting->site_title}}</h5>
                <ul class="list-posts">
                    <li>
                        <span class="title">{{ $setting->address}}</span>
                        <!-- <span class="date">February 14, 2015</span> -->
                    </li>
                    <li>
                        <h6 class="mb-1 text-muted">Phone</h6>
                        <i class="ti ti-mobile"> {{ $setting->mobile }}  <span> &nbsp; &nbsp;</span> {{ $setting->phone }}</i>
                    </li>
                    <li>
                       
                        <h6 class="mb-1 text-muted">E-mail</h6>
                        <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a><br>
                        <a href="mailto:{{ $setting->email }}">{{ $setting->email2 }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5 class="text-muted">Subscribe Us!</h5>
                <!-- MailChimp Form -->
                        <form action="{{ route('pages.create_newsletter.post') }}" method="POST" class="mb-5">
                        {{ csrf_field() }}
                        <div class="input-group">  
                        <input name="email" id="mce-EMAIL" type="email" class="form-control" placeholder="Tap your e-mail..." required>
                        <span class="input-group-btn">
                            <input class="btn btn-primary" type="submit" value="send">
                                <!-- <span class="description">Send</span>
                                <span class="success">
                                    <svg x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/></svg>
                                </span>
                                <span class="error">Try again...</span> -->
                            
                        </span>
                    </div>
                </form>
                <h5 class="text-muted mb-3">Social Media</h5>
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
        </div>
        <!-- Footer 2nd Row -->
        <div class="footer-second-row">
            <span class="text-muted">copyright © {{date('Y')}} {{ $setting->site_title}} All Rights Reserved</span>
        </div>
    </div>

    <!-- Back To Top -->
    <button id="back-to-top" class="back-to-top"><i class="ti ti-angle-up"></i></button>

</footer>
<!-- Footer / End