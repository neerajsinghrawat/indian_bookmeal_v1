    <!-- Header -->
    <header id="header" class="light">

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Logo -->
                    <div class="module module-logo dark">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('image/setting/'.$setting->logo) }}" alt="Logo" >
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <!-- Navigation -->
                    <nav class="module module-navigation left mr-4">
                        <ul id="nav-main" class="nav nav-main">
                            <li class=""><a href="{{ url('/') }}">Home</a></li>
                            <li class=""><a href="{{ url('/about-us') }}">About</a></li>
                            <li class=""><a href="{{ URL::to('category/menu') }}">Menu</a></li>
                            
                            <li class=""><a href="{{ url('/contact-us') }}">Contact</a></li>
                        @if (Auth::guest())
                            <li class=""><a href="{{ route('login') }}">Login</a></li>
                            <li class="lidesign"><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="has-dropdown lidesign">
                                <a href="#">My Account</a>
                                <div class="dropdown-container setTpo">
                                    <ul class="dropdown-mega">
                                        <li ><a href="<?php echo URL::to('/').'/dashboard'; ?>">Dashboard</a></li>
                                   <li class="border_none"> <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout ({{ Auth::user()->username }})</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                    </li>
                                    </ul>
                                </div>
                            </li>
                        @endif                    
                        </ul>
                    </nav>
                    <div class="module left">
                        <a href="#odder" data-toggle="modal" class="btn btn-outline-secondary"><span>Book A Table</span></a>
                        <?php if ($setting['is_delivery'] == 1){ ?>
                        <a href="#postCode-modal" data-toggle="modal" class="btn btn-outline-secondary"><span><?php echo (Session::has('postcode'))?Session::get('postcode.postcode').' <i class="ti ti-pencil"></i>':'Post Code'; ?></span></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="#" class="module module-cart right productfrontcartdetail" data-toggle="panel-cart">
                        <span class="cart-icon">
                            <i class="ti ti-shopping-cart"></i>
                            <span class="notificationaa"><?php echo (Session::has('cart_count'))?Session::get('cart_count'):$cart_count;?></span>
                        </span>
                        <span class="cart-value">{{getSiteCurrencyType()}}<span class="notification_amount">
                        {{number_format($cart_amount, 2, '.','')}}</span></span>
                    </a>
                </div>
                
            </div>
        </div>

    </header>
    <!-- Header / End -->

    <!-- Header -->
    <header id="header-mobile" class="light">

        <div class="module module-nav-toggle">
            <a href="#" id="nav-toggle" data-toggle="panel-mobile"><span></span><span></span><span></span><span></span></a>
        </div>

        <div class="module module-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('image/setting/'.$setting->logo) }}" alt="">
            </a>
        </div>

        <a href="#" class="module module-cart" data-toggle="panel-cart">
            <i class="ti ti-shopping-cart"></i>
            <span class="notificationaa">0</span>
        </a>

    </header>
    <!-- Header / End -->