@extends('layouts.front')
@section('title','Our Clients')
@section('description','Our Clients')
@section('keywords', 'Our Clients')
@section('content')

         <!-- Section -->
        <section class="section section-lg bg-dark">

            <!-- Video BG -->

            <!-- BG Video -->
            <div class="bg-video dark-overlay" data-src="http://assets.suelo.pl/soup/video/video_3.mp4" data-type="video/mp4"></div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        
                        <!-- Book a Table -->
                        <div class="utility-box">
                            <div class="utility-box-title bg-dark dark">
                                <div class="bg-image"><img src="http://assets.suelo.pl/soup/img/photos/modal-review.jpg" alt=""></div>
                                <div>
                                    <span class="icon icon-primary"><i class="ti ti-bookmark-alt"></i></span>
                                    <h4 class="mb-0">Book a table</h4>
                                    <p class="lead text-muted mb-0">Details about your reservation.</p>
                                </div>
                            </div> 
                            <div class="row">
                            <div class="col-sm-6 special-offer-content">
                                <div class="bg-white p-4 p-md-5 mb-4">
                            <h4 class="border-bottom pb-4">Check Availability</h4>
                                <h4 class="mb-0"><b>Opening Times</b></h4><br>
                                
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6 class="mb-1 text-muted">Week days</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="mb-1 text-muted">09.00 – 24:00</h6>
                                    </div>
                                </div>
                                <hr class="hr-md">                               
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6 class="mb-1 text-muted">Week days</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="mb-1 text-muted">09.00 – 24:00</h6>
                                    </div>
                                </div>
                                <hr class="hr-md">                             
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6 class="mb-1 text-muted">Week days</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6 class="mb-1 text-muted">09.00 – 24:00</h6>
                                    </div>
                                </div><br>
                        <h4 class="mb-0"><b>Call Us Now</b></h4>
                         <h6 class="mb-1 text-muted">1231541315</h6>
                                

                                </div>
                            </div>
                            <div class="col-sm-6">
                               
                                <form action="#" id="booking-form" class="booking-form" data-validate>
                                    <div class="utility-box-content">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>People:</label>
                                                    <select class="form-control">
                                                        <option value="2">2 people</option>
                                                        <option value="3">3 people</option>
                                                        <option value="4">4 people</option>
                                                        <option value="5">5 people</option>
                                                        <option value="6">6 people</option>
                                                        <option value="7">7 people</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Date:</label>
                                                    <input type="date" name="date" class="form-control" required>
                                                </div>
                                            </div>                                            
                                        </div>   

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Time:</label>
                                                    <select class="form-control">
                                                        <option value="2">2 people</option>
                                                        <option value="3">3 people</option>
                                                        <option value="4">4 people</option>
                                                        <option value="5">5 people</option>
                                                        <option value="6">6 people</option>
                                                        <option value="7">7 people</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Name:</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Phone Number:</label>
                                                    <input type="text" name="phone_number" class="form-control" required>
                                                </div>
                                            </div>
                                        </div><br>
                                        <button class="utility-box-btn btn btn-secondary btn-block btn-lg" type="submit">Make reservation!</button>
                                    </div>

                               
                                    
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
 
@endsection
