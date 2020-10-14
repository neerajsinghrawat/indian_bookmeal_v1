@extends('layouts.admin')

@section('content')
<style type="text/css">
.stylspan{display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 1.42857143;
text-align: center;
white-space: nowrap;
vertical-align: middle;
-ms-touch-action: manipulation;
touch-action: manipulation;
cursor: default;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
background-image: none;
border: 1px solid transparent;
border-radius: 4px;}
</style> <!-- Content Wrapper. Contains page content -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Feature Values
      </h1>
      <ol class="breadcrumb">
       <?php //echo '<pre>';print_r($category_list);die;
    /*   //echo '<pre>';print_r($category_list);die;
      $this->Html->addCrumb('Dashboard',array('controller'=>'dashboards','action'=>'index','admin'=>true));
      $this->Html->addCrumb('Product Manager',array('controller'=>'courses','action'=>'index'));
      $this->Html->addCrumb('Add Product');
      echo $this->Html->getCrumbs(' / ');*/
    ?>
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
              <h3 class="box-title"> Add Feature Values</h3>
            </div>

           


            <form action="{{ route('admin.features.add_value.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">

                <div class="form-group">
                   <?php if (isset($featurevalue[0]) && !empty($featurevalue)) {
                           foreach ($featurevalue as $feature_value): 
                   ?>
                    <span class="stylspan label-warning value{{ $feature_value['id'] }}" style="">
                        {{ $feature_value['value'] }} <i class="fa fa-close delete_values" value_id="{{ $feature_value['id'] }}" style="cursor:pointer;color: #d33b3b;"/></i>
                    </span>                      
                  <?php endforeach; } ?>              
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Value</label>
                  <input type="text" class="form-control" name="value[]" required="required" placeholder="Enter Value">
                   @if ($errors->has('value'))
                    <span class="help-block">
                        <strong>{{ $errors->first('value') }}</strong>
                    </span>
                    @endif
                </div>   
                <div class="form-group attachment_fields">
                
                </div>
                <div class="form-group">
                  <a href="#" class="add_image btn btn-info"><i class="fa fa-plus"> Add More Value</i></a>
                </div>
              
              <input type="hidden" name="feature_id" value="{{ $id }}">

              <div class="box-footer">
                <button type="submit" id="submitbutton" class="btn btn-primary" style="float: right;">Save Value</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

         
        </div>
        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<input type="hidden" id="totalArtistImage" value="0" />
@endsection

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
  
  $(document).on('click','.add_image',function(){
    //alert('baseUrl');
     var baseUrl = '{{ URL::to('/') }}';
     //alert(baseUrl);
     var totalArtistImage = $("#totalArtistImage").val();
     totalArtistImage = parseInt(totalArtistImage) + 1;
     $("#totalArtistImage").val(totalArtistImage);
    
     $(".attachment_fields").append('<div class="form-group"><div class="input-group my-colorpicker2 colorpicker-element"><input type="text" class="form-control" name="value[]" required="required" placeholder="Enter Value"><div class="input-group-addon"><i class="fa fa-close deleteCurrentRow_1" style="cursor:pointer;color: #d33b3b;float:right;"/></i></div></div></div>');

  });
  
  $(document).on('click','.deleteCurrentRow_1',function(){
    if (confirm('Are You Sure?')){
      $(this).parent().parent().remove();
    }
  }); 
   

  $('.delete_values').click(function(){

    var baseUrl = '{{ URL::to('/admin') }}';
    alert(baseUrl);
    var value_id = $(this).attr('value_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     
      $.ajax({
        url : baseUrl+'/features/delete_value',
        type : 'POST',
        data : {value_id : value_id,_token: CSRF_TOKEN},
        dataType : 'json',
        success : function(result){
          
        }
      }).done(function(result){
        
        if(result['success'] == 1){

          $('.value'+value_id).remove();

        }
      });
  });


});
</script>

