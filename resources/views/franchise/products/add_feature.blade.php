@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Feature
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
            <!-- <div class="box-header with-border">
              <h3 class="box-title">Add Feature</h3>
            </div> -->
 <?php //$crawlData =  CommonHelper::getproductsFeaturevalue(4,54); ?>
 <form action="{{ route('admin.products.save_feature_value.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
               <?php
      
        
        if (!empty($productFeatures)) {
  
         foreach ($productFeatures as $product_Feature){
        

         ?>

       <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-dot-circle-o text-yellow" aria-hidden="true"></i>
            {{ ucwords($product_Feature->name) }}
          </h2>
        </div>
        <!-- /.col -->
      </div>

        <?php  if (!empty($product_Feature['feature'])) {
         
         foreach($product_Feature['feature'] as $feature){


                        if(!empty($feature['FeatureValue']) || $feature['type'] == 'text'){
                        
                        ?>
                      <div class="control-group">
                      <label class="control-label">{{  ucwords($feature['name']) }}</label>
                      <div class="controls">
                      <?php if($feature['type'] == 'text'){ ?>
                      <input type="text" class="form-control" name="products[{{  $feature['id'] }}]" value="<?php echo (isset($featureArr[$feature['id']]) && !empty($featureArr[$feature['id']])) ? $featureArr[$feature['id']] : ''; ?>">
                     
                       
                      <?php  }else{?>
                       
                        <?php 
                        $featurValueArr = array();
                        foreach($feature['FeatureValue'] as $featureValue){
                          $featurValueArr[$featureValue['id']] = $featureValue['value'];
                        }

                        $featurID = $feature['id'];
            
            $selectedFeatureValues = (isset($featureArr[$featurID]) && !empty($featureArr[$featurID])) ? $featureArr[$featurID] : '';
            //echo '<pre>';print_r($selectedFeatureValues);
                        if($feature['type']=='multiselect'){ ?>

                        <select name="products[{{  $featurID }}][]" class="form-control" multiple="multiple">
                          @foreach($featurValueArr as $key => $featureValues)
                          <option value="{{ $key }}" <?php echo (!empty($selectedFeatureValues) &&  in_array($key,$selectedFeatureValues) ) ? 'selected=selected' :''; ?>>{{ $featureValues }}</option>
                          @endforeach
                        </select>
                        <?php //echo '<pre>';print_r($selectedFeatureValues); ?>
                        <!--  $this->Form->input($featurID,array('div'=>false,'label'=>false,'class'=>'span7','options' => $featurValueArr,'empty'=>'-Select '.$feature['name'],'multiple'=>'multiple')); -->
                       <?php  }else{ ?>
                       <select name="products[{{  $featurID }}]" class="form-control">
                       
                          @foreach($featurValueArr as $key => $featureValues)
                          <option value="{{ $key }}" <?php echo (!empty($selectedFeatureValues) &&  ($key == $selectedFeatureValues) ) ? 'selected=selected' :''; ?>>{{ $featureValues }}</option>
                          @endforeach
                        </select>
                       <!--  echo $this->Form->input($featurID,array('div'=>false,'label'=>false,'class'=>'span7','options' => $featurValueArr,'empty'=>'-Select '.$feature['name'])); -->
                       <?php } } ?>
                      </div>
                      </div>
                      <input type="hidden" name="product_id" value=" {{ $id }}">
         <?php } } } }
       } ?> 
       <div class="box-footer">
                <button type="submit" id="submitbutton" class="btn btn-primary">Submit</button>
              </div>
              </div>
            </form>
          
          <!-- /.box -->

         
        </div>
        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<input type="hidden" id="totalArtistImage" value="0" />
@endsection

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
