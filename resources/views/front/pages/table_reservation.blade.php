@extends('layouts.front')
@section('title','Our Clients')
@section('description','Our Clients')
@section('keywords', 'Our Clients')
<?php $timearray = getTimeArr(); ?>
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
                                    <!-- <span class="icon icon-primary"><i class="ti ti-bookmark-alt"></i></span> -->
                                    <h4 class="mb-0">Book a table</h4>
                                    <p class="lead text-muted mb-0">Details about your reservation.</p>
                                </div>
                            </div> 
                            <div class="row">
                            <div class="col-sm-6 special-offer-content">
                                <div class="bg-white p-4 p-md-5 mb-4">
                            
                                <h4 class="mb-0"><b>Opening Times</b></h4><br>
                                <?php 
                                foreach ($setting->openingTime as $key => $value) {
                                   //echo '<pre>';print_r($value);die;
                                ?>
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6 class="mb-1 text-muted">{{ $value->day_name }}</h6>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <?php if($value->is_close == 1){ ?>
                                        <h6 class="mb-1 text-muted">Day Off</h6>
                                        <?php }else{ ?>
                                        <h6 class="mb-1 text-muted">{{ date('h:i A', strtotime($value->start_time)) }} – {{ date('h:i A', strtotime($value->end_time)) }}</h6>
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr class="hr-md" style="margin-top: 10px;margin-bottom: 10px;"> 
                                <?php } ?>
                                <br>
                        <h4 class="mb-0"><b>Call Us Now</b></h4>
                         <h6 class="mb-1 text-muted">{{ $setting->table_reservation_phone_number }}</h6>
                                

                                </div>
                            </div>
                            <div class="col-sm-6">

                               
                                <form action="" id="booking-form" class="booking-form">
                                    {{ csrf_field() }}
                                    <div class="utility-box-content"><div id="dispmsg"><b></b></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>People:</b></label>
                                                    <div class="select-container">
                                                    <select class="form-control" name="people_count" required>
                                                        <?php foreach ($people_count as $value) {  ?>
                                                        <option value="{{$value}}">{{$value}} people</option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>Date *:</b></label>
                                                    <input type="date" name="reservation_date" class="form-control" id="date" required>
                                                </div>
                                            </div>                                            
                                        </div>   

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>Time:</b></label>
                                                    <div class="select-container">
                                                    <select name="reservation_time" class="form-control" required>
                                                        <?php foreach ($timearray as $value) {
                                                             ?>
                                                        <option value="{{$value}}">{{$value}}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><b>Name *:</b></label>
                                                    <input type="text" name="name" class="form-control" required id="name">
                                                </div>
                                            </div>
                                        </div>
                                                <div class="form-group">
                                                    <label><b>Email *:</b></label>
                                                    <input type="email" name="email" class="form-control" id="email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>Phone Number *:</b></label>
                                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                                </div>
                                        <br>
                                        <button class="utility-box-btn btn btn-secondary btn-block btn-lg saveTablereservation" type="button">Make reservation!</button>
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
<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

  $('.saveTablereservation').click(function(){
    var name= $('#name').val();
    var email= $('#email').val();
    var phone= $('#phone').val();
    var date= $('#date').val();
    if (name !='' && email !='' && phone !='' && date !='') {
        var baseUrl = '{{ URL::to('/') }}';
        var formData = $('#booking-form').serialize();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url : baseUrl+'/pages/save_table_reservation',
            type : 'POST',
            data : $('#booking-form').serialize(),
            dataType : 'json',
            success : function(result){
              
            }
          }).done(function(result){
            
            if(result['success'] == 1){
                alert(result['msg']);

            }else{
                $('#dispmsg').html(result['msg']).show();
                setTimeout(function(){ jQuery("#dispmsg").hide(); }, 3000);

                //alert(result['msg']);
                //window.location.reload();
            }
          });
    }else{
        alert('Please Fill all * fields');
    }
  
  });

});
</script>