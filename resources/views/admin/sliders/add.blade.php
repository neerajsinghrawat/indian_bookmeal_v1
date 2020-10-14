@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Slider
      </h1>
     <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/sliders') }}" ><b class="a_tag_color">Slider Manager</b></a></li>
        <li><b >Add Slider</b></li>
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
            <form action="{{ route('admin.sliders.add.post') }}"  method="POST" enctype="multipart/form-data" files="true">
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Slider Title</label>
                  <input type="text" class="form-control" name="title" placeholder="Enter Title" required="required">
                </div>  

                <div class="form-group">
                  <label for="exampleInputEmail1">Slider H1 Text</label>
                  <textarea class="form-control" name="sub_title" id="" placeholder="Enter Slider H1 Text"></textarea>
                </div> 

				<div class="form-group">
                  <label for="exampleInputEmail1">Slider Description</label>
                  <textarea class="form-control" name="description" id="editor1" placeholder="Enter Slider Description"></textarea>
                </div> 
				
				<div class="form-group">
                  <label for="exampleInputEmail1">Button Text</label>
                  <input type="text" class="form-control" name="button_text" value="">
                </div>  
				<div class="form-group">
                  <label for="exampleInputEmail1">Button Url</label>
                  <input type="text" class="form-control" name="button_url" value="">
                </div> 


                 <div class="form-group">
                  <label for="exampleInputEmail1">Image</label>
                  <input type="file" class="form-control" name="image" >
                   @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
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


