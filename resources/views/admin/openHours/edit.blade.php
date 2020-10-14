@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit  Open Hour
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/openHours') }}" ><b class="a_tag_color"> Open Hour Manager</b></a></li>
        <li><b >Edit  Open Hour</b></li>
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
            {!! Form::open(array('url' => url('admin/openHours/edit/'.$openHours['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Title</label>
                  <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{{ $openHours->title }}" required="required">
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Sort Number</label>
                  <input type="text" class="form-control" name="sort_number" placeholder="Enter Sort Number" value="{{ $openHours->sort_number }}" >
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Select Type For</label><br>
                  <div style="margin-left: 10px;"> <b> Time</b> <input type="radio" name="type" class="radio_button" value="time" required="required" {{ ($openHours->type == 'time')?'checked=checked':'' }}>

                  <b style="margin-left: 10px;">Closed </b> <input type="radio" name="type" class="radio_button" value="closed" required="required" {{ ($openHours->type == 'closed')?'checked=checked':'' }}>

                  <b style="margin-left: 10px;">Custom text </b> <input type="radio" name="type" class="radio_button" value="custom_text"  required="required" {{ ($openHours->type == 'custom_text')?'checked=checked':'' }}>
                </div>
                
                  @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong style="color:red;">{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                </div>

<?php $timearray=array('12:00  AM','12:30  AM','01:00  AM','01:30  AM','02:00 AM','02:30 AM','03:00 AM','03:30 AM','04:00 AM','04:30 AM','05:00 AM','05:30 AM','06:00 AM','06:30 AM','07:00 AM','07:30 AM','08:00 AM','08:30 AM','09:00 AM','09:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','01:00 PM','01:30 PM','02:00 PM','02:30 PM','03:00 PM','03:30 PM','04:00 PM','04:30 PM','05:00 PM','05:30 PM','06:00 PM','06:30 PM','07:00 PM','07:30 PM','08:00 PM','08:30 PM','09:00 PM','09:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM');  
                $start= date('h:i A', strtotime($openHours['start_time']));
                $end= date('h:i A', strtotime($openHours['end_time']));  ?>

                <div class="form-group timing">
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select name="start_time" class="form-control" required="required">
                     @foreach($timearray as $value)
                      <option value="{{ $value }}" {{ ($start == $value)?'selected=selected':'' }}>{{ $value }}</option>
                     @endforeach
                   </select>
                  </div></div>
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="exampleInputEmail1">End Time</label>
                    <select name="end_time" class="form-control" required="required">
                     @foreach($timearray as $value)
                      <option value="{{ $value }}" {{ ($start == $value)?'selected=selected':'' }}>{{ $value }}</option>
                     @endforeach
                   </select>
                  </div>
                </div>
                </div>

                <div class="form-group custom_text" style="display: none;">
                  <label for="exampleInputEmail1">Custom text</label>
                  <input type="text" class="form-control ct" name="text" placeholder="Enter Custom text" value="{{ $openHours->text }}">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status" {{ ($openHours['status'] == 1)?'checked':'unchecked' }}>
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
   
   $('.radio_button').change(function(){
        var buttonval = $(this).val();
       //alert(buttonval);
    if (buttonval == 'time') {
    $('.timing').css('display','block');
     $('.custom_text').css('display','none');
       $('.ct').attr('disabled',true);
       $('.st').attr('disabled',false);
    } else if (buttonval == 'closed') {
     $('.timing').css('display','none');
     $('.custom_text').css('display','none');
       $('.ct').attr('disabled',true);
       $('.st').attr('disabled',true);
    } else{

      $('.timing').css('display','none');
     $('.custom_text').css('display','block');
       $('.st').attr('disabled',true);
       $('.ct').attr('disabled',false);
    }

   });

  var buttonvalold = $('input[type="radio"]:checked').val(); 
      if (buttonvalold == 'time') {

    $('.timing').css('display','block');
       $('.ct').attr('disabled',true);
    } else if (buttonvalold == 'closed') {
     $('.timing').css('display','none');
     $('.custom_text').css('display','none');
       $('.ct').attr('disabled',true);
       $('.st').attr('disabled',true);
    } else{

      $('.timing').css('display','none');
     $('.custom_text').css('display','block');
       $('.st').attr('disabled',true);
    }



});
</script>

