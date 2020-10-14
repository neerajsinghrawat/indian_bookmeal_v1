@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Feature Group
      </h1>
      <ol class="breadcrumb">
       <?php //echo '<pre>';print_r($category_list);die;
    /*   //echo '<pre>';print_r($category_list);die;
      $this->Html->addCrumb('Dashboard',array('controller'=>'dashboards','action'=>'index','admin'=>true));
      $this->Html->addCrumb('Product Manager',array('controller'=>'courses','action'=>'index'));
      $this->Html->addCrumb('Add Product');
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
           
            {!! Form::open(array('url' => url('admin/featureGroups/edit/'.$feature_groups['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Group Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter Group Name" required="required" value="{{ $feature_groups['name'] }}">
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>                     

                <div class="form-group">
                  <label for="exampleInputEmail1">Category</label>

                    <select class="form-control" name="category_id">
                        @foreach($category_list as $category)
                            <option class="selectcategory" value="{{ $category->id }}" {{ ($feature_groups['category_id'] == $category->id)?'selected':'' }} >{{ ucwords($category->name) }}</option> 
                        @endforeach
                    </select>
                  
                </div>

             

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status" {{ ($feature_groups['status'] == 1)?'checked':'unchecked' }}>
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
