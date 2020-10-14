@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/categories') }}" ><b class="a_tag_color">Category Manager</b></a></li>
        <li><b >Edit Category</b></li>
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
            {!! Form::open(array('url' => url('admin/categories/edit/'.$categories['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}

              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Course Name</label>
                  <input type="text" class="form-control" name="name" id="category_Name" value="{{ $categories['name'] }}">
                </div>                
        
                <div class="form-group">
                  <label for="exampleInputEmail1">Category Slug </label>
                  <input type="text" class="form-control" name="slug" id="category_Slug" value="{{ $categories['slug'] }}">
                </div>   
<!-- 
                <div class="form-group">
                  <label for="exampleInputEmail1">Parent Category</label>
                   <select name="parent_id" class="form-control">
                     <option value="0">-Select Parent Category-</option>
                     @foreach($category_list as $category)
                     
                      <option value="{{ $category->id }}"  {{ ($categories['parent_id'] == $category->id)?'selected':'' }}>{{ ucwords($category->name)}}</option>
                     @endforeach
                   </select>
                </div> -->

                <?php  $timearray=array('12:00  AM','12:30  AM','01:00  AM','01:30  AM','02:00 AM','02:30 AM','03:00 AM','03:30 AM','04:00 AM','04:30 AM','05:00 AM','05:30 AM','06:00 AM','06:30 AM','07:00 AM','07:30 AM','08:00 AM','08:30 AM','09:00 AM','09:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','01:00 PM','01:30 PM','02:00 PM','02:30 PM','03:00 PM','03:30 PM','04:00 PM','04:30 PM','05:00 PM','05:30 PM','06:00 PM','06:30 PM','07:00 PM','07:30 PM','08:00 PM','08:30 PM','09:00 PM','09:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM'); 
                
                $start= date('h:i A', strtotime($categories['start_time']));
                $end= date('h:i A', strtotime($categories['end_time'])); 
                
               // echo '<pre>'; print_R($categories); die;
               ?>

                <div class="form-group">
                  <label for="exampleInputEmail1">Start time</label>
                   <select name="start_time" class="form-control" required="required">
                     @foreach($timearray as $value)
                      <option value="{{ $value }}" {{ ($start == $value)?'selected=selected':'' }}>{{ $value }}</option>
                     @endforeach
                   </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">End time</label>
                   <select name="end_time" class="form-control" required="required">
                     @foreach($timearray as $value)
                      <option value="{{ $value }}" {{ ($end == $value)?'selected=selected':'' }}>{{ $value }}</option>
                     @endforeach
                   </select>
                </div> 
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Image</label>
                  <input type="file" class="form-control" name="image" value="{{ $categories['image'] }}"><br>
                  <img class="img-thumbnail" src="{{ asset('image/category/200x200/'.$categories['image']) }}" alt="" style="width: 100px;height: 100px;">
                   
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Banner Image</label>
                  <input type="file" class="form-control" name="bannerImage" value="{{ $categories['bannerImage'] }}"><br>
                  <img class="img-thumbnail" src="{{ asset('image/category/200x200/'.$categories['bannerImage']) }}" alt="" style="width: 100px;height: 100px;">
                   
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" placeholder="Enter Meta Title" value="{{ $categories['meta_title'] }}">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keyword" placeholder="Enter Meta Keywords" value="{{ $categories['meta_keyword'] }}">
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Description</label>
                  <textarea class="form-control" name="meta_description" placeholder="Enter Meta Description">{{ $categories['meta_description'] }}</textarea> 
                </div> 

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status"  {{ ($categories['status'] == 1)?'checked':'unchecked' }}>
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
    $("#category_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#category_Slug").val(Text);        
    });
});
</script>
