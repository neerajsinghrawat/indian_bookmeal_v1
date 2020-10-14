@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Product Images
      </h1>
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/products') }}" ><b class="a_tag_color">Product Manager</b></a></li>
        <li><b >Add Product Images</b></li>
      </ol>
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
              <h3 class="box-title">Add Product Images</h3>
            </div>

            <div class="row">
                <div class="col-sm-12">
              <?php if (isset($allimages[0]) && !empty($allimages)) {
                           $index = 0;
                           foreach ($allimages as $allimage): 
                           $index++;
              ?>
                    <div class="col-sm-5 col-md-2 image{{ $allimage['id'] }}" >
                        <i class="fa fa-close delete_image" image_id="{{ $allimage['id'] }}" style="cursor:pointer;color: #d33b3b; float: right;"/></i><img class="img-thumbnail" src="{{ asset('image/product/200x200/'.$allimage['image']) }}" alt="" style="width: 200px;height: 165px;">
                      </div>
               <?php endforeach; } ?> 
             </div>
           </div>


            <form action="{{ route('admin.products.save_more_image.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
                   

                
                
                <br><div class="form-group">
                  <label for="exampleInputEmail1">Image</label>
                  <input type="file" class="form-control" name="image[]" required="required" >

                   @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                </div>   
                <div class="form-group attachment_fields">
                
                </div>
                <div class="form-group">
                  <a href="#" class="add_image btn btn-info"><i class="fa fa-plus"> Add More Image</i></a>
                </div>
              
              <input type="hidden" name="product_id" value="{{ $id }}">

              <div class="box-footer">
                <button type="submit" id="submitbutton" class="btn btn-primary" style="float: right;">Save Image</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

         
        </div>
        
      </div>
      <!-- /.row -->
    </section>


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
    
     $(".attachment_fields").append('<div class="form-group"><div class="input-group my-colorpicker2 colorpicker-element"><input type="file" class="form-control" name="image[]" ><div class="input-group-addon"><i class="fa fa-close deleteCurrentRow_1" style="cursor:pointer;color: #d33b3b;float:right;"/></i></div></div></div>');

  });
  
  $(document).on('click','.deleteCurrentRow_1',function(){
    if (confirm('Are You Sure?')){
      $(this).parent().parent().remove();
    }
  }); 
   

  $('.delete_image').click(function(){
    var baseUrl = '{{ URL::to('/admin') }}';
    var image_id = $(this).attr('image_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     
      $.ajax({
        url : baseUrl+'/products/delete_images',
        type : 'POST',
        data : {image_id : image_id,_token: CSRF_TOKEN},
        dataType : 'json',
        success : function(result){
          
        }
      }).done(function(result){
        
        if(result['success'] == 1){

          $('.image'+image_id).remove();

        }
      });
  });


});
</script>

