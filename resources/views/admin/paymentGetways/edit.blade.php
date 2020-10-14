@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit  Payment Getway
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><b >Edit  Payment Getway</b></li>
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
            {!! Form::open(array('url' => url('admin/paymentGetways/edit'),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}
              <div class="box-body">
                 <div class="form-group">
                  <label for="exampleInputEmail1">Mode</label>
                      <div class="row"> 
                        
                          <div class="col-md-6" style="margin-bottom: 15px;">

                            <input type="checkbox" name="cod" value="1" {{($blogs['cod'] == '1')?'checked=checked':''}}>
                            <b> Cash on delivery</b>
                          </div>                   
                          <div class="col-md-6">   

                            <input type="checkbox" name="stripe" class="newPayment" typegh="stripe" value="1" {{($blogs['stripe'] == '1')?'checked=checked':''}}>
                            <b>Stripe</b>
                          </div>
                         

                        
                    </div>
                </div> 
                <div class="stripe" style="display: none;">

                   <div class="form-group">
                    <label for="exampleInputEmail1">Payment Mode</label><br>
                    <input type="radio" name="type" id="type" class="feature_value_" required="required" value="Sandbox" {{($blogs['type'] == 'Sandbox')?'checked=checked':''}}><label for="male">Sandbox</label><br>

                    <input type="radio" name="type" id="type" class="feature_value_" required="required" value="Producation" {{($blogs['type'] == 'Producation')?'checked=checked':''}}><label for="male">Producation</label>
                    @if ($errors->has('type'))
                      <span class="help-block">
                          <strong>{{ $errors->first('type') }}</strong>
                      </span>
                    @endif
                  </div> 
                   <div class="form-group">
                    <label for="exampleInputEmail1">Secret key</label>
                    <input type="text" class="form-control feature_value_" name="secret_id" id="secret_id" placeholder="Enter secret key" required="required" value="{{ $blogs['secret_id'] }}">
                    @if ($errors->has('name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                  </div> 
                   <div class="form-group">
                    <label for="exampleInputEmail1">Demo key</label>
                    <input type="text" class="form-control feature_value_" name="demo_id" id="demo_id" placeholder="Enter demo key" required="required" value="{{ $blogs['demo_id'] }}">
                    @if ($errors->has('name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                  </div>                                
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

    if($('.newPayment').prop('checked')){
          $(".stripe").show();         
          $(".feature_value_").prop('disabled', false);
    }else{

        $(".stripe").hide(); 
         $(".feature_value_").prop('disabled', 'disabled');
    }

  $(document).on('click','.newPayment',function(){
    var valNew =$(this).attr('typegh');
    
      if($(this).prop('checked')){

          
        if (valNew == 'stripe') {
          $(".stripe").show();         
          $(".feature_value_").prop('disabled', false);
        }

        //alert(valNew);
         
      }else{
         $(".stripe").hide(); 
         $(".feature_value_").prop('disabled', 'disabled');        
      }
  });
});
</script>