@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Product
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
            <form action="{{ route('admin.products.add.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Product Name</label>
                  <input type="text" class="form-control" name="name" id="product_Name" placeholder="Enter Product name" required="required">
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Product Slug </label>
                  <input type="text" class="form-control" name="slug" id="product_Slug" placeholder="Enter Product slug" required="required">
                   @if ($errors->has('slug'))
                    <span class="help-block">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Price </label>
                  <input type="text" class="form-control" name="price" id="price" placeholder="Enter Product Price" required="required">
                   @if ($errors->has('price'))
                    <span class="help-block">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                    @endif
                </div>   

                 <div class="form-group">
                  <label for="exampleInputEmail1"> Quantity</label>
                  <input type="text" class="form-control number_for" name="quantity" id="quantity" placeholder="Enter Total Product Quantity" required="required">
                   @if ($errors->has('quantity'))
                    <span class="help-block">
                        <strong>{{ $errors->first('quantity') }}</strong>
                    </span>
                    @endif
                </div>   
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Model No.</label>
                  <input type="text" class="form-control" name="model_no"  placeholder="Enter Model Number" required="required">
                  @if ($errors->has('model_no'))
                    <span class="help-block">
                        <strong>{{ $errors->first('model_no') }}</strong>
                    </span>
                    @endif
                </div>  

                <div class="form-group">
                  <?php $status = array('in_stock'=>'In Stock','out_of_stock'=>'Out of Stock');?>
                  <label for="exampleInputEmail1">Stock Status</label>
                 {{ Form::select('stock_status', $status, null, ['class' => 'form-control']) }}
                  @if ($errors->has('stock_status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('stock_status') }}</strong>
                    </span>
                    @endif
                </div>   
                   

                <div class="form-group">
                  <label for="exampleInputEmail1">Category</label>

                    <select class="form-control" name="category_id">
                        @foreach($category_list as $category)
                            <option class="selectcategory" value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                  
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1"> Country of Manufacture</label>

                    <select class="form-control" name="country_id">
                        @foreach($country_list as $country)

                            <option value="{{ $country->id }}">{{ ucwords($country->country_name) }}</option>
                       
                        @endforeach
                    </select>
                  
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
                  <label for="exampleInputEmail1">Short Description</label>
                  <textarea class="form-control" id="editor1" name="short_description"></textarea>
               
                   @if ($errors->has('short_description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('short_description') }}</strong>
                    </span>
                    @endif
                </div> 

                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea class="form-control" id="editor2" name="description"></textarea>                 
                   @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>              
                
                <!-- <div class="form-group">
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
    $("#product_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#product_Slug").val(Text);        
    });
});
</script>

<script type="text/javascript">
  $(document).ready(function () {
  //called when key is pressed in textbox
  $(".number_for").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
</script> 

