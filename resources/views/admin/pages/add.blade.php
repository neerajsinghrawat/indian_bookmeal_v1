@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Page
      </h1>
     <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/pages') }}" ><b class="a_tag_color">Page</b></a></li>
        <li><b >Add Page</b></li>
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
            <form action="{{ route('admin.pages.add.post') }}"  method="POST" enctype="multipart/form-data" files="true">
             {{ csrf_field() }}
              <div class="box-body">
                 <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" id="page_name" placeholder="Enter Name" required="required">
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Slug </label>
                  <input type="text" class="form-control" name="slug" id="page_slug" placeholder="Enter Slug" required="required">
                   @if ($errors->has('slug'))
                    <span class="help-block">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                    @endif
                </div>

                <?php $pagetype= array('header'=>'Header','footer'=>'Footer','other'=>'Other'); ?>
                <div class="form-group">
                  <label for="exampleInputEmail1">Page Type</label>
                   <select name="header[]" class="form-control" multiple="true" required="required">
                    
                     @foreach($pagetype as $key => $pagetype)
                      <option value="{{ $key }}">{{ $pagetype }}</option>
                     @endforeach
                   </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Parent Page</label>
                   <select name="parent_page" class="form-control">
                    <option value="0">-Select Parent Page-</option>
                     @foreach($prentpages as $key => $prentpage)
                      <option value="{{ $prentpage->id }}">{{ ucwords($prentpage->name) }}</option>
                     @endforeach
                   </select>
                </div>

				        <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea class="form-control" name="description" id="editor1" placeholder="Enter Description"></textarea>
                </div> 
				
				        <div class="form-group">
                  <label for="exampleInputEmail1">Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" >
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Keyword</label>
                  <input type="text" class="form-control" name="meta_keyword" >
                </div>  
				        <div class="form-group">
                  <label for="exampleInputEmail1">Meta Description</label>
                  <textarea class="form-control" name="meta_description" id="editor2" placeholder="Enter Description"></textarea>
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Sort Number </label>
                  <input type="text" class="form-control" name="sort_number" placeholder="Enter Sort Number" >
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
  //alert('sdfdsf');
    $("#page_name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#page_slug").val(Text);        
    });
});
</script>

