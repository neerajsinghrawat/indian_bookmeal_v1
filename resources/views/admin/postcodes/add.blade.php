@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Postcode
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/postcodes') }}" ><b class="a_tag_color">Postcode Manager</b></a></li>
        <li><b >Add Postcode</b></li>
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
            <form action="{{ route('admin.postcodes.add.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Post code</label>
                  <input type="text" class="form-control" name="post_code" placeholder="Enter Post code" required="required">
                </div>    

                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Select Post-Code For</label><br>
                  <div style="margin-left: 10px;"> <b> Franchise</b> <input type="radio" name="main" class="radio_button" value="franchise" required="required" >
                  <b style="margin-left: 10px;">Main </b> <input type="radio" name="main" class="radio_button" value="main" checked="checked" required="required" >
                </div>
                
                  @if ($errors->has('main'))
                                    <span class="help-block">
                                        <strong style="color:red;">{{ $errors->first('main') }}</strong>
                                    </span>
                                @endif
                </div> -->
<!-- 
                <div class="form-group selectfranchise" style="display: none;">
                  <label for="exampleInputEmail1">Franchise</label>
                    <select class="form-control selectdropdownfr" name="franchise_id">
                      <option value="">-Select Franchise-</option>
                        @foreach($franchise_list as $franchise)
                            <option  value="{{ $franchise->id }}">{{ ucwords($franchise->name) }}</option>
                        @endforeach
                    </select>
                  
                </div> -->

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status">
                </div>
        
        
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" id="submitbutton" class="btn btn-primary">Submit</button>
              </div>
            </form>
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
    if (buttonval == 'franchise') {

    $('.selectfranchise').css('display','block');
   $('.selectdropdownfr').attr('disabled',false);
   $('.selectdropdownfr').attr('required',true);
    }else {
      $('.selectfranchise').css('display','none');
       $('.selectdropdownfr').attr('disabled',true);
       $('.selectdropdownfr').attr('required',false);
    }

   });

  /*if (buttonval == 'percentage') {
    $('.labelclass').html('Percentage');
  }*/


});
</script>

