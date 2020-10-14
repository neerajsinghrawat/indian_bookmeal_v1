@extends('layouts.front')
@section('title', (!empty($pageabout_us->meta_title))? $pageabout_us->meta_title:'Page')
@section('description', (!empty($pageabout_us->meta_description))? $pageabout_us->meta_description:'')
@section('keywords', (!empty($pageabout_us->meta_keyword))? $pageabout_us->meta_keyword:'')
@section('content')
                       <!-- Breadcrumb Start -->
        <!-- Page Title -->
        <div class="page-title border-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 offset-lg-3 text-center">
                        <h1 class="mb-0">About Us</h1>
                        <!-- <h4 class="text-muted mb-0">Some informations about our restaurant</h4> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Section -->
        <section class="section section-bg-edge">

            <div class="image left bottom col-md-7">
                <div class="bg-image"><img src="{{asset('css/front/img/bg-chef.jpg')}}" alt=""></div>
            </div>

            <div class="container">
                <div class="col-lg-5 offset-lg-5 col-md-9 offset-md-3">
                    <div class="rate mb-5 rate-lg"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star"></i></div>
                    <h2>The best food in London!</h2>
                    
                        <?php echo $pageabout_us->description; ?>
                    
                </div>
            </div>

        </section>

        <!-- Section -->
        <!-- <section class="section section-lg dark bg-dark">

            
            <div class="bg-image bg-parallax"><img src="http://assets.suelo.pl/soup/img/photos/bg-croissant.jpg" alt=""></div>

            <div class="container text-center">
                <div class="col-lg-8 offset-lg-2">
                    <h2 class="mb-3">Would you like to visit Us?</h2>
                    <h5 class="text-muted">Book a table even right now or make an online order!</h5>
                    <a href="menu-list-navigation.html" class="btn btn-primary"><span>Order Online</span></a>
                    <a href="book-a-table.html" class="btn btn-outline-primary"><span>Book a table</span></a>
                </div>
            </div>

        </section> -->
@endsection
