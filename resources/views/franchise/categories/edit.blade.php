@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Category
      </h1>
      <ol class="breadcrumb">
       <?php //echo '<pre>';print_r($categories);die;
      /*$this->Html->addCrumb('Dashboard',array('controller'=>'dashboards','action'=>'index','admin'=>true));
      $this->Html->addCrumb('Course Manager',array('controller'=>'courses','action'=>'index'));
      $this->Html->addCrumb('Add Course');
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

                <div class="form-group">
                  <label for="exampleInputEmail1">Parent Category</label>
                   <select name="parent_id" class="form-control">
                     <option value="0">-Select Parent Category-</option>
                     @foreach($category_list as $category)
                     
                      <option value="{{ $category->id }}"  {{ ($categories['parent_id'] == $category->id)?'selected':'' }}>{{ ucwords($category->name)}}</option>
                     @endforeach
                   </select>
                </div>

                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Image</label>
                  <input type="file" class="form-control" name="image" value="{{ $categories['image'] }}"><br>
                    <img class="img-thumbnail" src="{{ asset('image/category/'.$categories['image']) }}" alt="" style="width: 100px;height: 70px;">
                </div>     

                <div class="form-group">
                  <label for="exampleInputPassword1">Featured</label>
                   <input type="checkbox" name="featured" {{ ($categories['featured'] == 1)?'checked':'unchecked' }}>
                </div> -->

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
    <!-- /.content -->
  </div>

  
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
