@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit  Blog
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/blogs') }}" ><b class="a_tag_color"> Blog Manager</b></a></li>
        <li><b >Edit  Blog</b></li>
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
            {!! Form::open(array('url' => url('admin/blogs/edit/'.$blogs['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}
              <div class="box-body">
                 <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" id="blog_name" placeholder="Enter Name" required="required" value="{{ $blogs['name'] }}">
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Slug </label>
                  <input type="text" class="form-control" name="slug" id="blog_slug" placeholder="Enter Slug" required="required" value="{{ $blogs['slug'] }}">
                   @if ($errors->has('slug'))
                    <span class="help-block">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                    @endif
                </div>  

                <div class="form-group">
                  <label for="exampleInputEmail1">Image</label>                  

                  <input type="file" class="form-control" name="image"  value="{{ $blogs['image'] }}">
                  <img class="img-thumbnail" src="{{ asset('image/blog/200x200/'.$blogs['image']) }}" alt="" style="width: 100px;height: 100px;">
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea class="form-control" name="description" id="editor1" placeholder="Enter Description">{{ $blogs['description'] }}</textarea>
                </div> 
        
                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" value="{{ $blogs['meta_title'] }}">
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Keyword</label>
                  <input type="text" class="form-control" name="meta_keyword" value="{{ $blogs['meta_keyword'] }}">
                </div>  
                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Description</label>
                  <textarea class="form-control" name="meta_description" id="editor2" placeholder="Enter Description">{{ $blogs['meta_description'] }}</textarea>
                </div> 

               

                <div class="form-group">
                  <label for="exampleInputPassword1">Featured</label>
                   <input type="checkbox" name="featured" {{ ($blogs['featured'] == 1)?'checked':'unchecked' }}>
                </div>                

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status" {{ ($blogs['status'] == 1)?'checked':'unchecked' }}>
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
  //alert('sdfdsf');
    $("#blog_name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#blog_slug").val(Text);        
    });
});
</script>