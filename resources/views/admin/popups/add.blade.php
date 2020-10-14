@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
<?php //echo'<pre>';print_r($category_list);die;?>    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Popup
      </h1>
     <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/popups') }}" ><b class="a_tag_color">Popups Manager</b></a></li>
        <li><b >Add Popup</b></li>
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
            <form action="{{ route('admin.popups.add.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Image Url</label>
                  <input type="text" class="form-control" name="image_url" placeholder="Enter Image Url" required="required">
                </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Popup Type</label>
                  <select name="type" class="form-control popupdropdown" required="required">
                    <option value="home">Home Page</option>
                    <option value="site">All Site</option>
                    <option value="category">Category</option>
                  </select>
                </div>


                <div class="form-group checkboxpopup" style="display: none;">
                <label for="exampleInputPassword1">Category</label><br>

                  <div class="col-md-12">

                    <?php foreach ($category_list as $key => $value) {
                     ?>
                      <div class="col-md-4">
                        <input type="checkbox" name="category_id[]" value="<?php echo $value['id']; ?>"> <label for="exampleInputPassword1"> <?php echo $value['name']; ?></label><br>
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