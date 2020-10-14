@extends('layouts.admin')
<?php $timearray = getTimeArr(); ?>
@section('content')

<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><b >Edit Settings</b></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('url' => url('admin/settings/edit/'.$settings['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}

              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Site Name</label>
                  <input type="text" class="form-control" name="site_title" value="{{ $settings['site_title'] }}" placeholder="Enter Site Name">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Site Logo</label>
                  <input type="file" class="form-control" name="logo" >
                </div>
                <img class="img-thumbnail" src="{{ asset('image/setting/'.$settings['logo']) }}" alt="" style="width: 100px;height: 70px;">
                
                <div class="clearfix"></div>
                <?php 
                	$currencies = getAllCurrencies();
                	
                	if(!empty($currencies)){
                ?>
                    <div class="form-group">
                	    <label for="exampleInputEmail1">Currency</label>
                		<select name="site_currency_type" class="form-control">
                	<?php  foreach($currencies as $currency){ ?>
                		
                			<option value="<?php echo $currency['currency_code']; ?>" <?php echo ($settings['site_currency_type'] == $currency['currency_code']) ? 'selected=selected' : '' ; ?>><?php echo $currency['currency']; ?></option>
                		
                	<?php } ?>
                	</select>
                </div>
                
                <?php  } ?>
                <div class="form-group box-footer box-comments">
                    <label for="exampleInputEmail1">Opening Details</label><br> 
                    <div class="row">  
                      <div class="form-group col-md-3"><label for="exampleInputPassword1">Closed</label></div> 
                      <div class="form-group col-md-3"><label for="exampleInputEmail1">Day</label></div> 
                      <div class="form-group col-md-3"><label for="exampleInputEmail1">Start time</label></div> 
                      <div class="form-group col-md-3"><label for="exampleInputEmail1">End time</label></div> 
                    </div>          
                <?php  /*$timearray=array('12:00  AM','12:30  AM','01:00  AM','01:30  AM','02:00 AM','02:30 AM','03:00 AM','03:30 AM','04:00 AM','04:30 AM','05:00 AM','05:30 AM','06:00 AM','06:30 AM','07:00 AM','07:30 AM','08:00 AM','08:30 AM','09:00 AM','09:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','01:00 PM','01:30 PM','02:00 PM','02:30 PM','03:00 PM','03:30 PM','04:00 PM','04:30 PM','05:00 PM','05:30 PM','06:00 PM','06:30 PM','07:00 PM','07:30 PM','08:00 PM','08:30 PM','09:00 PM','09:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM');*/
               /* $timearray=array('12:00  AM','12:30  AM','01:00  AM','01:30  AM','02:00 AM','02:30 AM','03:00 AM','03:30 AM','04:00 AM','04:30 AM','05:00 AM','05:30 AM','06:00 AM','06:30 AM','07:00 AM','07:30 AM','08:00 AM','08:30 AM','09:00 AM','09:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','01:00 PM','01:30 PM','02:00 PM','02:30 PM','03:00 PM','03:30 PM','04:00 PM','04:30 PM','05:00 PM','05:30 PM','06:00 PM','06:30 PM','07:00 PM','07:30 PM','08:00 PM','08:30 PM','09:00 PM','09:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM'); */
                  $days = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
                


                foreach ($days as $key => $day) {

                  if (!empty($openingTimesArr) && !empty($openingTimesArr[$day])) {
                    $start= date('h:i A', strtotime($openingTimesArr[$day]['start_time']));
                    $end= date('h:i A', strtotime($openingTimesArr[$day]['end_time']));                 
                   ?>

                    <div class="row">                   
                        <div class="form-group col-md-3">
                          
                          <input type="checkbox" class="dayoff" name="openingTime[{{ $key }}][is_close]" value="1" <?php echo ($openingTimesArr[$day]['is_close'] == 1)?"checked='checked'":'' ; ?> day= "{{ $day }}">
                        </div>                    
                        <div class="form-group col-md-3">
                          <input type="text" class="form-control" name="openingTime[{{ $key }}][day_name]" value="{{ $day }}" readonly="readonly">
                        </div>     
                        <div class="{{ $day }}">        
                          <div class="form-group col-md-3">
                            <select name="openingTime[{{ $key }}][start_time]" class="form-control">
                              @foreach($timearray as $value)
                              <option value="{{ $value }}" {{ ($start == $value)?'selected=selected':'' }}>{{ $value }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="form-group col-md-3">
                            <select name="openingTime[{{ $key }}][end_time]" class="form-control">
                              @foreach($timearray as $value)
                              <option value="{{ $value }}" {{ ($end == $value)?'selected=selected':'' }}>{{ $value }}</option>
                              @endforeach
                            </select>
                          </div> 
                        </div>                    
                    </div>

                  
                <?php } } ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="email" class="form-control" name="email" value="{{ $settings['email'] }}" placeholder="Enter Email">
                </div>                
        
                <div class="form-group">
                  <label for="exampleInputEmail1">Other Email</label>
                  <input type="email" class="form-control" name="email2" value="{{ $settings['email2'] }}" placeholder="Enter Other Email">
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <input type="text" class="form-control" name="address" value="{{ $settings['address'] }}" placeholder="Enter Address">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile No.</label>
                  <input type="number" class="form-control" name="mobile" value="{{ $settings['mobile'] }}" placeholder="Enter Mobile No.">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Phone No.</label>
                  <input type="number" class="form-control" name="phone" value="{{ $settings['phone'] }}" placeholder="Enter Phone No.">
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">About Us</label>
                 <textarea class="form-control" name="about" id="editor1" placeholder="Enter About Us">{{ $settings['about'] }}</textarea>
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Google Analytic</label>
                 <textarea class="form-control" name="google_analytic" id="editor1" placeholder="Enter Google Analytic">{{ $settings['google_analytic'] }}</textarea>
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Facebook link</label>
                  <input type="text" class="form-control" name="facebook" value="{{ $settings['facebook'] }}" placeholder="Enter Facebook link">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Twitter link</label>
                  <input type="text" class="form-control" name="twitter" value="{{ $settings['twitter'] }}" placeholder="Enter Twitter link">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">G plus link</label>
                  <input type="text" class="form-control" name="g_plus" value="{{ $settings['g_plus'] }}" placeholder="Enter G plus link">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Youtube link</label>
                  <input type="text" class="form-control" name="youtube_link" value="{{ $settings['youtube_link'] }}" placeholder="Enter Linkdlin link">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Total Table</label>
                  <input type="text" class="form-control" name="total_table" value="{{ $settings['total_table'] }}" placeholder="Enter Total Table">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Total Men</label>
                  <input type="text" class="form-control" name="total_men" value="{{ $settings['total_men'] }}" placeholder="Enter Total Men">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Per Table</label>
                  <input type="text" class="form-control" name="men_in_table" value="{{ $settings['men_in_table'] }}" placeholder="Enter Per Table">
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Table Reservation Ph no.</label>
                  <input type="text" class="form-control" name="table_reservation_phone_number" value="{{ $settings['table_reservation_phone_number'] }}" placeholder="Enter Table Reservation Ph no.">
                </div> 

                <div class="form-group">
                  
                  <input type="checkbox" name="is_takeaway" <?php echo ($settings['is_takeaway'] == 1)?"checked='checked'":'' ; ?>>&nbsp;&nbsp;<label for="exampleInputEmail1"> Take Away </label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="is_delivery" <?php echo ($settings['is_delivery'] == 1)?"checked='checked'":'' ; ?>> &nbsp;&nbsp;<label for="exampleInputEmail1"> Home Delivery</label>
                  
                </div> 
                <div class="form-group">
                  
                  <input type="checkbox" name="is_book_table_applied" <?php echo ($settings['is_book_table_applied'] == 1)?"checked='checked'":'' ; ?>>&nbsp;&nbsp;<label for="exampleInputEmail1">Book A Table Form ? </label>
                </div> 
        
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" id="submitbutton" class="btn btn-primary">Submit</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

         
        </div>
        
      </div>
      <!-- /.row -->
    </section>


  
@endsection


<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $( ".dayoff" ).each(function() {
      if($(this).prop('checked')){

        var day = $(this).attr('day');
        $('.'+day).css('display','none');
      
      }else{

        var day = $(this).attr('day');
        $('.'+day).css('display','block');

      }
    });
    
    $("#category_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#category_Slug").val(Text);        
    });

   
   $('.dayoff').click(function(){    

    if($(this).prop('checked')){

      var day = $(this).attr('day');
      $('.'+day).css('display','none');
    
    }else{

      var day = $(this).attr('day');
      $('.'+day).css('display','block');

    }


   });

  /*if (buttonval == 'percentage') {
    $('.labelclass').html('Percentage');
  }*/


});
</script>