@extends('layouts.admin')

@section('content')

<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Shipping & Taxes
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><b >Edit Shipping & Taxes</b></li>
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
              <h3 class="box-title">Shipping Detail:-</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('url' => url('admin/shippingTaxes/edit/'.$shippingtaxes['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}

              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Shipping title</label>
                  <input type="text" class="form-control" name="shipping_title" value="{{ $shippingtaxes['shipping_title'] }}" placeholder="Enter Shipping title">
                </div>
                

                <div class="form-group">

                  <label for="exampleInputEmail1">Type</label><br>
                  <div style="margin-left: 10px;"> 
                    <b style="margin-left: 10px;">Paid </b> <input type="radio" name="shipping_type" class="radio_button_select" value="Paid" {{ (!empty($shippingtaxes['shipping_type']) && $shippingtaxes['shipping_type'] == 'Paid')?'checked=checked':'' }} required="required" >

                  <b style="margin-left: 10px;">Free </b> <input type="radio" name="shipping_type" class="radio_button_select" value="Free" {{ (!empty($shippingtaxes['shipping_type']) && $shippingtaxes['shipping_type'] == 'Free')?'checked=checked':'' }} required="required" >

                </div>                
        
                <div class="form-group amount_box" style="display: none;">
                  <label for="exampleInputEmail1">Shipping Amount</label>
                  <input type="number" class="form-control" name="shipping_amount" value="{{ $shippingtaxes['shipping_amount'] }}" placeholder="Enter Shipping Amount">
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Shipping Description</label>
                  <textarea class="form-control" name="shipping_desc" id="editor1" placeholder="Enter About Us">{{ $shippingtaxes['shipping_desc'] }}</textarea>
                </div> <br>

                <h4 class="box-title">Tax Detail:-</h4>

                <div class="form-group">
                  <label for="exampleInputEmail1">Tax Text</label>
                  <input type="text" class="form-control" name="tax_text" value="{{ $shippingtaxes['tax_text'] }}" placeholder="Enter Tax Text">
                </div> 
 

                <div class="form-group">
                  <label for="exampleInputEmail1">Tax Percentage</label>
                 <input type="number" class="form-control" name="tax_percent" value="{{ $shippingtaxes['tax_percent'] }}" placeholder="Enter Tax Percentage">
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
    
    var button_val_old = $("input[name='shipping_type']:checked").val();

    if (button_val_old == 'Paid') {

      $('.amount_box').css('display','block');  

    }
    if(button_val_old == 'Free'){

        $('.amount_box').css('display','none');
    }

    $('.radio_button_select').change(function(){
        var buttonval = $(this).val();
        alert(buttonval);
    if (buttonval == 'Paid') {

      $('.amount_box').css('display','block');
    }
    if(buttonval == 'Free'){

      $('.amount_box').css('display','none');
         
    }

   });
});
</script>
