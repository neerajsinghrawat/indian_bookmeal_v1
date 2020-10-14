@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Category
      </h1>
      <ol class="breadcrumb">
       <?php
       //echo '<pre>';print_r($category_list);die;
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
            <form action="{{ route('admin.categories.add.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Category Name</label>
                  <input type="text" class="form-control" name="name" id="category_Name" placeholder="Enter category name" required="required">
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Category Slug </label>
                  <input type="text" class="form-control" name="slug" id="category_Slug" placeholder="Enter category slug" required="required">
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Parent Category</label>
                   <select name="parent_id" class="form-control">
                     <option value="0">-Select Parent Category-</option>
                     @foreach($category_list as $category)
                      <option value="{{ $category->id }}">{{ ucwords($category->name)}}</option>
                     @endforeach
                   </select>
                </div>
                
              <!--   <div class="form-group">
                  <label for="exampleInputEmail1">Image</label>
                  <input type="file" class="form-control" name="image" required="required">
                </div>              
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Featured</label>
                   <input type="checkbox" name="featured">
                </div> -->

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

