@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Testimonial
      </h1>
     <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/testimonials') }}" ><b class="a_tag_color">Testimonial Manager</b></a></li>
        <li><b >Edit Testimonial</b></li>
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
            {!! Form::open(array('url' => url('admin/testimonials/edit/'.$testimonials['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}

              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" value="{{ $testimonials['name'] }}">
                </div>  


                <div class="form-group">
                  <label for="exampleInputEmail1">Designation</label>
                  <input type="text" class="form-control" name="designation" value="{{ $testimonials['designation'] }}">
                </div>  
   

				<div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea class="form-control" name="description" id="editor1" placeholder="Enter Description">{{ $testimonials['description'] }}</textarea>
                </div> 


        
                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status"  {{ ($testimonials['status'] == 1)?'checked':'unchecked' }}>
                </div>        
                <div class="form-group">
                  <label for="exampleInputPassword1">Show in home page</label>
                   <input type="checkbox" name="show_inhome_page"  {{ ($testimonials['show_inhome_page'] == 1)?'checked':'unchecked' }}>
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