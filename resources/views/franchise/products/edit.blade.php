@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

<meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
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
             {!! Form::open(array('url' => url('admin/products/edit/'.$products['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}

              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Product Name</label>
                 
                  <input type="text" class="form-control" name="name" id="product_Name" placeholder="Enter Product name" required="required" value="{{ $products['name'] }}">
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Product Slug </label>
                  <input type="text" class="form-control" name="slug" id="product_Slug" placeholder="Enter Product slug" required="required" value="{{ $products['slug'] }}">
                   @if ($errors->has('slug'))
                    <span class="help-block">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Price </label>
                  <input type="text" class="form-control" name="price" id="price" placeholder="Enter Product Price" required="required" value="{{ $products['price'] }}">
                   @if ($errors->has('price'))
                    <span class="help-block">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                    @endif
                </div>   

                 <div class="form-group">
                  <label for="exampleInputEmail1"> Quantity</label>
                  <input type="text" class="form-control number_for" name="quantity" id="quantity" placeholder="Enter Total Product Quantity" required="required" value="{{ $products['quantity'] }}">
                   @if ($errors->has('quantity'))
                    <span class="help-block">
                        <strong>{{ $errors->first('quantity') }}</strong>
                    </span>
                    @endif
                </div>                      
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Main Category</label>
                    <select class="form-control" name="category_id" id="main_category" required="required">
                      <option class="selectcategory" value="">-Select Category-</option>
                        @foreach($category_list as $category)
                            <option class="selectcategory" value="{{ $category->id }}" {{ ($products['category_id'] == $category->id)?'selected':'' }}>{{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                  
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Sub Category</label>
                    <select class="form-control" name="sub_category_id" id="sub_category" required="required">

                      @if(!empty($sub_category_list))
                           @foreach($sub_category_list as $sub_category)
                            <option class="selectcategory" value="{{ $sub_category->id }}" {{ ($products['sub_category_id'] == $sub_category->id)?'selected':'' }}>{{ ucwords($sub_category->name) }}</option>
                        @endforeach

                        @else
                          
                       <option class="selectcategory" value="">-Select Main Category-</option>
                      @endif
                    </select>
                  
                </div>

                
                <div class="form-group">
                  <label for="exampleInputEmail1">Image</label>
                  <input type="file" class="form-control" name="image" value="{{ $products['image'] }}"><br>
                  <img class="img-thumbnail" src="{{ asset('image/product/'.$products['image']) }}" alt="" style="width: 100px;height: 70px;">
                   @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                </div>   


                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea class="form-control" id="editor1" name="description">{{ $products['description'] }}</textarea>                 
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
                   <input type="checkbox" name="status" {{ ($products['status'] == 1)?'checked':'unchecked' }}>
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
    $("#product_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#product_Slug").val(Text);        
    });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  
    $('#main_category').on('change',function(){
      
      var category_id = $(this).val();
      
      var baseUrl = '{{ URL::to('/admin') }}';
      
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       // alert(CSRF_TOKEN);
      $.ajax({
      
      url: baseUrl+'/products/getAjaxsubcategoryList',
      
      type: 'post',
      
      data: {category_id: category_id,_token: CSRF_TOKEN},
      
      dataType: 'html',
      
      success: function(result) {
      
      $('#sub_category').html(result);
      
      }
      
      });
                       
  }); 
});
</script>
<!-- <script type="text/javascript">
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
</script>  -->

