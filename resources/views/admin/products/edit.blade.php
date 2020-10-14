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


                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Main Category</label>
                    <select class="form-control" name="category_id" id="main_category" required="required">
                      <option class="selectcategory" value="">-Select Category-</option>
                        @foreach($category_list as $category)
                            <option class="selectcategory" value="{{ $category->id }}" {{ ($products['category_id'] == $category->id)?'selected':'' }}>{{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                  
                </div> -->
                <input type="hidden" name="category_id" value="7">
                <div class="form-group">
                  <label for="exampleInputEmail1">Category</label>
                    <select class="form-control" name="sub_category_id">

                      @if(!empty($category_list))
                           @foreach($category_list as $sub_category)
                            <option value="{{ $sub_category->id }}" {{ ($products['sub_category_id'] == $sub_category->id)?'selected':'' }}>{{ ucwords($sub_category->name) }}</option>
                        @endforeach

                        @endif

                    </select>
                  
                </div><!-- 
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
                  
                </div> -->

                
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Is varaible Product</label>
                   <input type="checkbox" class="is_varaible_product" name="is_varaible_product" {{ ($products['is_varaible_product'] == 1)?'checked':'unchecked' }}>
                </div>
                <div class="attachment_fields" style="display: none;">
                  <div class="form-group box-footer">
                    <label for="exampleInputEmail1">Product Feature</label><br>
                      <?php $new = explode(',', $products['product_feature']);
                        

                        foreach ($productFeatures as $key => $productFeature) {
                         ?> 
                    <div class="row"> 
                        
                         <div class="col-md-3" style="margin-bottom: 15px;">                     
                         <div class="col-md-4">                     
                           <input type="checkbox" name="ProductFeature[{{ $key }}]" class="attachmentinput_fields" value="{{$productFeature->id}}" {{ (in_array($productFeature->id,$new))?'checked':'unchecked' }}>
                         <b> {{$productFeature->value}}</b></div>
                         </div>

                        
                    </div>
                    <div class="form-group box-footer box-comments child_feature_{{$productFeature->id}}" style="display: none;">
                      <div class="form-group">
                        <a href="javascript:void(0)" class="add_more btn btn-info" id_main="{{ $productFeature['id'] }}"><i class="fa fa-plus" > Add More</i></a>
                      </div>
                        <div class="row">
                            <div class="col-md-2">  
                              <label>Is Same price ?</label>
                            </div>
                            <div class="col-md-4 row form-group"> 
                              
                                  <label for="exampleInputEmail1">Attribute</label>
                            </div>
                            <div class="col-md-2"> 
                              <label for="exampleInputEmail1">Increment/Decrement</label>
                            </div>
                            <div class="col-md-2"> 
                              <label for="exampleInputEmail1">price</label>
                            </div>
                            <div class="col-md-2">
                              <label for="exampleInputEmail1">Action</label>
                            </div>  
                        </div>
                        <div id="clone_{{$productFeature->id}}"> 
                          <?php if(isset($products->productAttribute) && count($products->productAttribute) >0 ) {
                          foreach ($products->productAttribute as $key => $product_items) {
                            if ($product_items['feature_id'] == $productFeature->id) {
                              ?>                      
                          <div class="row" > 
                            <div class="col-md-2">                 
                               <input type="checkbox" name="Productattribute[{{$productFeature->id}}][{{ $key }}][is_same_price]" value="1" {{ ($product_items['is_same_price'] == 1)?'checked':'unchecked' }}  class="is_same_price"  count="{{ $key }}" id_main="{{ $productFeature['id'] }}">

                               <input type="hidden" name="Productattribute[{{$productFeature->id}}][{{ $key }}][id]" value="{{$product_items['id']}}">
                            
                            </div>
                                                  
                            <div class="col-md-4 row form-group"> 
                               
                                <select class="form-control feature_value_{{ $productFeature['id'] }}" name="Productattribute[{{$productFeature->id}}][{{ $key }}][attribute]" id="main_category" required="required" disabled="disabled">
                                  
                                    @foreach($productFeatureAttributes[$productFeature['id']] as $category)
                                        <option class="selectcategory" value="{{ $category['id'] }}" {{ (isset($product_items['attribute']) && $category['id'] == $product_items['attribute'])?'selected':'' }}>{{ ucwords($category['name']) }}</option>
                                    @endforeach
                                </select>
                              
                            </div>  

                            <div class="col-md-2"> 
                              <select class="form-control remove_{{ $key }}_{{ $productFeature['id'] }}" name="Productattribute[{{$productFeature->id}}][{{ $key }}][price_type]">
                                <option value="Increment" {{ ($product_items->price_type == 'Increment')?'selected':'' }}>Increment</option>
                                <option value="Decrement" {{ ($product_items->price_type == 'Decrement')?'selected':'' }}>Decrement</option>
                              </select>
                            </div> 
                            <div class="col-md-2"> 
                              <input type="text" class="form-control remove_{{ $key }}_{{ $productFeature['id'] }}" name="Productattribute[{{$productFeature->id}}][{{ $key }}][price]" placeholder="Enter Price" value="{{ $product_items->price }}">
                            </div> 
                            <div class="col-md-2">
                              <i class="fa fa-trash delete_item" item_id="{{ $product_items->id }}" style="cursor:pointer;color: #d33b3b;"/></i>
                            </div>

                          </div> 
                            <?php } } } ?>

                        </div>
                      
                    </div>    
                    <?php } ?>              
                  </div> 
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
                  <label for="exampleInputPassword1">Bestsellers</label>
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

<input type="hidden" id="totalitems" value="<?php echo ((isset($products->productAttribute)) && (count($products->productAttribute) > 0)) ? count($products->productAttribute) : 1; ?>" />
@endsection

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    if($('.is_varaible_product').prop('checked')){
       $(".attachment_fields").show();
       $(".attachmentinput_fields").prop('disabled', false);
    }else{

        $('.attachment_fields').hide();
        $('.attachmentinput_fields').prop('disabled', 'disabled');
    }


    if($('.attachmentinput_fields:checked').length){
        
        $(".attachmentinput_fields:checked").each(function() {
          //alert('nnb');
          var valNew = $(this).val();
          $(".child_feature_"+valNew).show();
          $(".feature_value_"+valNew).prop('disabled', false);
        });      
    }



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

  $(document).on('click','.is_varaible_product',function(){
    
    if($(this).prop('checked')){
       $(".attachment_fields").show();
       $(".attachmentinput_fields").prop('disabled', false);
    }else{

        $('.attachment_fields').hide();
        $('.attachmentinput_fields').prop('disabled', 'disabled');
    }

  });  

  $(document).on('click','.attachmentinput_fields',function(){
    var valNew =$(this).val();
    
      if($(this).prop('checked')){
        //alert(valNew);
         $(".child_feature_"+valNew).show();
         $(".feature_value_"+valNew).prop('disabled', false);
      }else{
         $(".child_feature_"+valNew).hide();
         $(".feature_value_"+valNew).prop('disabled', 'disabled');        
      }
  });  
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
  $(document).on('click','.delete_item',function(){
  /*$('.delete_item').click(function(){*/
    if (confirm('Are You Sure?')){
    var baseUrl = '{{ URL::to('/admin') }}';
    var item_id = $(this).attr('item_id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     //alert(item_id);
      $.ajax({
        url : baseUrl+'/products/delete_ajax_item',
        type : 'POST',
        data : {item_id : item_id,_token: CSRF_TOKEN},
        dataType : 'json',
        success : function(result){
          if(result.success == 1){
           // alert(result.success);
            $(this).parent().parent().remove();

          }
        }
      })    }
  });


  var productFeatureAttributes = <?php echo json_encode($productFeatureAttributes) ?>;
  $(document).on('click','.add_more',function(){
    

      
     var baseUrl = '{{ URL::to('/') }}';
     var id_main = $(this).attr('id_main');
     var totalitems = $("#totalitems").val();
     //alert(totalitems);
     totalitems = parseInt(totalitems) + 1;
     $("#totalitems").val(totalitems);
      var html = '<div class="row" ><div class="col-md-2"> <input type="checkbox" name="Productattribute['+id_main+']['+totalitems+'][is_same_price]" value="1" class="is_same_price" count="'+totalitems+'" id_main="'+id_main+'"></div>';
        html += '<div class="col-md-4 row form-group">';
          html += '<select class="form-control feature_value_'+id_main+'" name="Productattribute['+id_main+']['+totalitems+'][attribute]" id="main_category" required="required" disabled="disabled">';
          $.each(productFeatureAttributes[id_main], function (i, elem) { 
            html += '<option class="selectcategory" value="'+elem.id+'">'+elem.name+'</option>'; 
          });
          html += '</select>';
        html += '</div><div class="col-md-2"><select class="form-control remove_'+totalitems+'_'+id_main+'" name="Productattribute['+id_main+']['+totalitems+'][price_type]"><option value="Increment">Increment</option><option value="Decrement">Decrement</option></select></div> <div class="col-md-2"><input type="text" class="form-control remove_'+totalitems+'_'+id_main+'" name="Productattribute['+id_main+']['+totalitems+'][price]" placeholder="Enter Price" ></div>';

        html += '<div class="col-md-2"><i class="fa fa-trash deleteitem_1" style="cursor:pointer;color: #d33b3b;"></i></div></div>';
        $('#clone_'+id_main).append(html);

        $(".attachmentinput_fields:checked").each(function() {
          
          var valNew = $(this).val();
          $(".child_feature_"+valNew).show();
          $(".feature_value_"+valNew).prop('disabled', false);
        });

  });   

});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $( ".is_same_price" ).each(function() {
    //alert('jjh');
      if($(this).prop('checked')){

        var count = $(this).attr('count');
        var id_main = $(this).attr('id_main');
        $('.remove_'+count+'_'+id_main).css('display','none');
        $('.remove_'+count+'_'+id_main).prop('disabled', 'disabled');
      
      }else{

        var count = $(this).attr('count');
        var id_main = $(this).attr('id_main');
        $('.remove_'+count+'_'+id_main).css('display','block');
        $('.remove_'+count+'_'+id_main).prop('disabled', false);

      }
    });
  $(document).on('click','.is_same_price',function(){  

    if($(this).prop('checked')){

      var count = $(this).attr('count');
        var id_main = $(this).attr('id_main');
        $('.remove_'+count+'_'+id_main).css('display','none');
        $('.remove_'+count+'_'+id_main).prop('disabled', 'disabled');
    
    }else{

      var count = $(this).attr('count');
      var id_main = $(this).attr('id_main');
      $('.remove_'+count+'_'+id_main).css('display','block');
      $('.remove_'+count+'_'+id_main).prop('disabled', false);

    }


   });    
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

