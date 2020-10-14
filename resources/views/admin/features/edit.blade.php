@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Feature
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
            {!! Form::open(array('url' => url('admin/features/edit/'.$features['id']),'files'=>true ,'method'=>'put')) !!}
            
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Feature Name</label>
                  <input type="text" class="form-control" name="name" id="feature_Name" placeholder="Enter Feature name" required="required" value="{{ $features['name'] }}">
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Feature Slug </label>
                  <input type="text" class="form-control" name="slug" id="feature_Slug" placeholder="Enter Feature slug" required="required" value="{{ $features['slug'] }}">
                   @if ($errors->has('slug'))
                    <span class="help-block">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                    @endif
                </div>

                                  

                <div class="form-group">
                  <label for="exampleInputEmail1">Category</label>

                    <select class="form-control selectpicker getFeatureGroupUsingCategory" data-live-search="true"  name="category_id"  element-id = "featureGroupIdElement">
                        @foreach($category_list as $category)
                            <option class="selectcategory" value="{{ $category->id }}" {{ ($features['category_id'] == $category->id)?'selected':'' }}>{{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                  
                </div>

                 <div class="form-group" id="featureGroupIdElement">
                  <label for="exampleInputEmail1">Feature Group</label>
                    <select class="form-control " name="feature_group_id">
                        <option class="selectcategory" value=""> -Select Feature Group-</option>
                        @foreach($feature_group as $featuregroup)
                            <option class="selectcategory" value="{{ $featuregroup->id }}" {{ ($features['feature_group_id'] == $featuregroup->id)?'selected':'' }}>{{ ucwords($featuregroup->name) }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('feature_group_id'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('feature_group_id') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Feature Type</label>
                    <?php $feature_types=array('multiselect'=>'Multiselect','singleselect'=>'Single-select','text'=>'Text') ?>
                    <select class="form-control" name="type">
                        @foreach($feature_types as $key => $feature_type)
                            <option class="selectcategory" value="{{ $key }}" {{ ($features['type'] == $key)?'selected':'' }} >{{ ucwords($feature_type) }}</option>
                        @endforeach
                    </select>
                  
                </div>
                
                
                
                <!-- <div class="form-group">
                  <label for="exampleInputPassword1">Featured</label>
                   <input type="checkbox" name="featured">
                </div> -->

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status" {{ ($features['status'] == 1)?'checked':'unchecked' }}>
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
    $("#feature_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#feature_Slug").val(Text);        
    });

    $('.getFeatureGroupUsingCategory').bind('change',function(){
      
      var category_id = $(this).val();
      
      var baseUrl = '{{ URL::to('/admin') }}';
      
      var element_id = $(this).attr('element-id');

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //alert(baseUrl);
      $.ajax({
      
      url: baseUrl+'/features/getAjaxFeatureGroupList',
      
      type: 'post',
      
      data: {category_id: category_id,_token: CSRF_TOKEN},
      
      dataType: 'html',
      
      success: function(result) {
      
      $('#'+element_id).html(result);
      
      }
      
      });
                       
  }); 

});
</script>