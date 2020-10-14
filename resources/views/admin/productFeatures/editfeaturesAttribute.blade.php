@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit {{ $productFeaturedata->value }} Features Attributes
      </h1>
     <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/productFeatures') }}" ><b class="a_tag_color">Product Attributes</b></a></li>
        <li><a href="{{ URL::to('admin/productFeatures/features_attribute/'.$productFeaturedata->id) }}" ><b class="a_tag_color">{{ $productFeaturedata->value }} Features Attributes</b></a></li>
        <li><b >Edit {{ $productFeaturedata->value }} Features Attributes</b></li>
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
            {!! Form::open(array('url' => url('admin/productFeatures/editfeatures_attribute/'.$productFeaturedata->id.'/'.$productFeatureAttributes['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}

              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" value="{{ $productFeatureAttributes['name'] }}">
                  <input type="hidden" name="product_feature_id" value="{{ $productFeaturedata->id }}">
                </div>  




        
                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status"  {{ ($productFeatureAttributes['status'] == 1)?'checked':'unchecked' }}>
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