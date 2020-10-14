@extends('layouts.admin')

@section('content')
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->

<meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/products') }}" ><b class="a_tag_color">Product Manager</b></a></li>
        <li><b >Edit Product</b></li>
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
                  <label for="exampleInputEmail1">Server Text heading</label>
                  <input type="text" class="form-control" name="server_text_heading" placeholder="Enter Server Text heading"  value="{{ $products['server_text_heading'] }}">
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
                    <select class="form-control" name="sub_category_id" id="sub_category" >

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
                  <img class="img-thumbnail" src="{{ asset('image/product/200x200/'.$products['image']) }}" alt="" style="width: 100px;height: 100px;">
                   @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Short Description</label>
                  <textarea class="form-control"  name="short_description" maxlength="80">{{ $products['short_description'] }}</textarea>                 
                   @if ($errors->has('short_description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('short_description') }}</strong>
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
                <div class="form-group box-footer box-comments">
                    <label for="exampleInputEmail1">Product Feature</label><br>

                    <div class="row"> 
                    <?php foreach ($productFeatures as $key => $productFeature) {
                      if (!empty($productFeatureItemsarr) && !empty($productFeatureItemsarr[$productFeature->id])) {
                     ?> 
                         <div class="col-md-6" style="margin-bottom: 15px;">                     
                           <div class="col-md-4">                     
                               <input type="checkbox" name="ProductFeature[{{ $key }}][active]" checked="checked">
                             <b> {{$productFeature->value}}</b>
                           </div>
                           <div class="col-md-4"> 
                              <input type="text" class="form-control" name="ProductFeature[{{ $key }}][price]" placeholder="Enter Price" value="{{ $productFeatureItemsarr[$productFeature->id]['price'] }}"><input type="hidden" name="ProductFeature[{{ $key }}][id]" value="{{$productFeature->id}}">
                            </div>
                         </div>

                      <?php }else{ ?>
                         <div class="col-md-6" style="margin-bottom: 15px;">                     
                           <div class="col-md-4">                     
                               <input type="checkbox" name="ProductFeature[{{ $key }}][active]">
                             <b> {{$productFeature->value}}</b>
                           </div>
                           <div class="col-md-4"> 
                              <input type="text" class="form-control" name="ProductFeature[{{ $key }}][price]" placeholder="Enter Price" ><input type="hidden" name="ProductFeature[{{ $key }}][id]" value="{{$productFeature->id}}">
                            </div>
                         </div>                      
                      <?php } } ?>
                  </div>
                  
                  </div> 
    <?php 
    if(isset($products->productTag) && count($products->productTag) >0 ) {
        
                    foreach ($products->productTag as $key => $producttags) {
                      
                      if($key == 0){ ?>
                      
                <div class="form-group">
                  <label for="exampleInputEmail1">Tag</label>
                  <input type="text" class="form-control" name="tag[{{ $key }}]" placeholder="Enter Tag" value="{{ $producttags->tag }}">
                </div>
                <?php }else{ ?>

                <div class="form-group tag{{ $producttags->id }}"><div class="input-group my-colorpicker2 colorpicker-element"><input type="text" class="form-control" name="tag[{{ $key }}]" placeholder="Enter Tag"  value="{{ $producttags->tag }}"><div class="input-group-addon"><i class="fa fa-close delete_tag" tag_id="{{ $producttags->id }}" style="cursor:pointer;color: #d33b3b;float:right;"/></i></div></div></div>
                <?php } ?>

                <?php } }else{ ?>
                <div class="form-group">
                  <label for="exampleInputEmail1">Tag</label>
                  <input type="text" class="form-control" name="tag[]" placeholder="Enter Tag">
                </div>
                <?php } ?>
                <div class="form-group attachment_fields">
                
                </div>
                <div class="form-group">
                  <a href="javascript:void(0)" class="add_tag btn btn-info"><i class="fa fa-plus"> Add More Tag</i></a>
                </div>


    <?php if(isset($products->productItem) && count($products->productItem) >0 ) {
        
                    foreach ($products->productItem as $key => $product_items) {
                      if($key == 0){ ?>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Title</label>
                    <input type="text" class="form-control" name="Item[{{ $key }}][title]" value="{{ $product_items->title }}" placeholder="Enter Item Title">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Price</label>
                     <input type="text" class="form-control" name="Item[{{ $key }}][price]" placeholder="Enter Price" value="{{ $product_items->price }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Price type</label>
                      <select class="form-control" name="Item[{{ $key }}][price_type]">
                        <option value="Increment" {{ ($product_items->price_type == 'Increment')?'selected':'' }}>+(Increment)</option>
                        <option value="Decrement" {{ ($product_items->price_type == 'Decrement')?'selected':'' }}>-(Decrement)</option>
                      </select>
                  </div> 
                <?php }else{?>
                <div class="item{{ $product_items->id }} box-footer box-comments" style="margin-bottom: 12px">
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Title</label><i class="fa fa-close delete_item" item_id="{{ $product_items->id }}" 
                      style="cursor:pointer;color: #d33b3b;float:right;"/></i>
                    <input type="text" class="form-control" value="{{ $product_items->title }}" name="Item[{{ $key }}][title]" placeholder="Enter Item Title">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Price</label>
                     <input type="text" class="form-control" name="Item[{{ $key }}][price]" placeholder="Enter Price" value="{{ $product_items->price }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Item Price type</label>
                      <select class="form-control" name="Item[{{ $key }}][price_type]">
                        <option value="Increment" {{ ($product_items->price_type == 'Increment')?'selected':'' }}>+(Increment)</option>
                        <option value="Decrement" {{ ($product_items->price_type == 'Decrement')?'selected':'' }}>-(Decrement)</option>
                      </select>
                  </div>                   
                </div>
<?php } } } else { ?>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Item Title</label>
                  <input type="text" class="form-control" name="Item[1][title]" placeholder="Enter Item Title">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Item Price</label>
                   <input type="text" class="form-control" name="Item[1][price]" placeholder="Enter Price">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Item Price type</label>
                    <select class="form-control" name="Item[1][price_type]">
                      <option value="Increment">+(Increment)</option>
                      <option value="Decrement">-(Decrement)</option>
                    </select>
                </div> 

<?php } ?>
                <div class="form-group item_fields">
                
                </div>
                <div class="form-group">
                  <a href="javascript:void(0)" class="add_item btn btn-info"><i class="fa fa-plus"> Add Items</i></a>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Allergen Key</label>
                  <textarea class="form-control" name="allergen_key" placeholder="Enter Allergen Key">{{ $products['allergen_key'] }}</textarea> 
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" placeholder="Enter Meta Title"  value="{{ $products['meta_title'] }}">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keyword" placeholder="Enter Meta Keywords" value="{{ $products['meta_keyword'] }}">
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Meta Description</label>
                  <textarea class="form-control" name="meta_description" placeholder="Enter Meta Description" >{{ $products['meta_description'] }}</textarea> 
                </div> 

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status" {{ ($products['status'] == 1)?'checked':'unchecked' }}>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Popular</label>
                   <input type="checkbox" name="is_popular" {{ ($products['is_popular'] == 1)?'checked':'unchecked' }}>
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

<input type="hidden" id="totalitems" value="<?php echo ((isset($products->productItem)) && (count($products->productItem) > 0)) ? count($products->productItem) : 1; ?>" />
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

    $(document).on('click','.add_tag',function(){
    //alert('baseUrl');
     var baseUrl = '{{ URL::to('/') }}';
    
     $(".attachment_fields").append('<div class="form-group"><div class="input-group my-colorpicker2 colorpicker-element"><input type="text" class="form-control" name="tag[]" placeholder="Enter Tag"><div class="input-group-addon"><i class="fa fa-close deleteCurrentRow_1" style="cursor:pointer;color: #d33b3b;float:right;"/></i></div></div></div>');

    });
  
  $(document).on('click','.deleteCurrentRow_1',function(){
    if (confirm('Are You Sure?')){
      $(this).parent().parent().remove();
    }
  }); 
   

  $('.delete_tag').click(function(){
    if (confirm('Are You Sure?')){
    var baseUrl = '{{ URL::to('/admin') }}';
    var tag_id = $(this).attr('tag_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     //alert(tag_id);
      $.ajax({
        url : baseUrl+'/products/delete_ajax_tag',
        type : 'POST',
        data : {tag_id : tag_id,_token: CSRF_TOKEN},
        dataType : 'json',
        success : function(result){
          
        }
      }).done(function(result){
        
        if(result['success'] == 1){

          $('.tag'+tag_id).remove();

        }
      });
    }
  });

});
</script>
<script type="text/javascript">
$(document).ready(function() {
  
  $(document).on('click','.add_item',function(){
    //alert('baseUrl');
     var baseUrl = '{{ URL::to('/') }}';
     //alert(baseUrl);
     var totalitems = $("#totalitems").val();
     totalitems = parseInt(totalitems) + 1;
     $("#totalitems").val(totalitems);

        $(".item_fields").append('<div class="box-footer box-comments" style="margin-bottom: 12px"><div class="form-group"><label for="exampleInputEmail1">Item Title</label><i class="fa fa-close deleteitem_1" style="cursor:pointer;color: #d33b3b;float:right;"/></i><input type="text" class="form-control" name="Item['+totalitems+'][title]" placeholder="Enter Item Title" required="required"></div><div class="form-group"><label for="exampleInputEmail1">Item Price</label><input type="text" class="form-control" name="Item['+totalitems+'][price]" placeholder="Enter Price" required="required"></div><div class="form-group"><label for="exampleInputEmail1">Item Price type</label><select class="form-control" name="Item['+totalitems+'][price_type]" required="required"><option value="Increment">+(Increment)</option><option value="Decrement">-(Decrement)</option></select></div></div>');

  });
  
  $(document).on('click','.deleteitem_1',function(){
    if (confirm('Are You Sure?')){
      $(this).parent().parent().remove();
    }
  }); 

  $('.delete_item').click(function(){
    var baseUrl = '{{ URL::to('/admin') }}';
    var item_id = $(this).attr('item_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     //alert(tag_id);
      $.ajax({
        url : baseUrl+'/products/delete_ajax_item',
        type : 'POST',
        data : {item_id : item_id,_token: CSRF_TOKEN},
        dataType : 'json',
        success : function(result){
          
        }
      }).done(function(result){
        
        if(result['success'] == 1){

          $('.item'+item_id).remove();

        }
      });
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

