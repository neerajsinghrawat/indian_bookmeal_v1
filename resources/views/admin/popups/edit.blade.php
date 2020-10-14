@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
<?php //echo '<pre>';print_r($popups);die;?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Popup
      </h1>
     <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/popups') }}" ><b class="a_tag_color">Popups Manager</b></a></li>
        <li><b >Edit Popup</b></li>
      </ol>
    </section>

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
            {!! Form::open(array('url' => url('admin/popups/edit/'.$popups['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}
              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Image Url</label>
                  <input type="text" class="form-control" name="image_url" placeholder="Enter Image Url" required="required" value="{{ $popups['image_url'] }}">
                </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Popup Type</label>
                  <select name="type" class="form-control popupdropdown" required="required">
                    <option value="home" {{ ($popups['type'] == 'home')?'selected':'' }} >Home Page</option>
                    <option value="site" {{ ($popups['type'] == 'site')?'selected': '' }} >All Site</option>
                    <option value="category" {{ ($popups['type'] == 'category')?'selected':'' }} >Category</option>
                  </select>
                </div>


                <div class="form-group checkboxpopup" style="display: none;">
                <label for="exampleInputPassword1">Category</label><br>

                  <div class="col-md-12">

                    <?php 

                    foreach ($category_list as $key => $value) {
                     ?>
                      <div class="col-md-4">
                        <input type="checkbox" name="category_id[]" value="<?php echo $value['id']; ?>" {{ (!empty($popups['category_id']) && (in_array($value['id'], $popups['category_id'])) )?'checked':'unchecked' }}> <label for="exampleInputPassword1"> <?php echo $value['name']; ?></label><br>
                      </div> 

                    <?php } ?>
                   
                  </div> <br><!-- <div class="col-md-12">

                    <?php //foreach ($categories as $key => $value) {
                     ?>
                      <div class="col-md-4">
                        <label for="exampleInputPassword1"><?php //echo $key;?></label><br>
                        <?php //foreach ($value as $key => $values) {
                          ?>
                        <input type="checkbox" name="category[]" value="<?php //echo $values['id'];?>"> <label for="exampleInputPassword1"> <?php //echo $values['name'];?></label><br>
                        <?php //} ?>
                      </div>
                    <?php //} ?>
                   
                  </div>  -->
                  
                </div>    

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status" {{ ($popups['status'] == 1)?'checked':'unchecked' }}>
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

  var value = $('.popupdropdown').val();

  if (value == 'category') {
    $('.checkboxpopup').css('display','block');
  }

  $('.popupdropdown').on('change',function(){
      
      var category_id = $(this).val();

      if (category_id == 'category') {
         $('.checkboxpopup').css('display','block');
      }else{
        $('.checkboxpopup').css('display','none');
      }
                       
  }); 

});
</script>