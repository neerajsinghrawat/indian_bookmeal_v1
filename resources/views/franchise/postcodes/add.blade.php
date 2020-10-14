@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Postcode
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
            <form action="{{ route('admin.postcodes.add.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Post code</label>
                  <input type="text" class="form-control" name="post_code" placeholder="Enter Post code" required="required">
                </div>    

               
                <div class="form-group">
                  <label for="exampleInputEmail1">Franchise</label>
                    <select class="form-control" name="franchise_id"  required="required">
                      <option value="">-Select Franchise-</option>
                        @foreach($franchise_list as $franchise)
                            <option  value="{{ $franchise->id }}">{{ ucwords($franchise->name) }}</option>
                        @endforeach
                    </select>
                  
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
    <!-- /.content -->
  </div>

  
@endsection

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
  //alert('sdfdsf');
    $("#Franchise_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#Franchise_Slug").val(Text);        
    });
});
</script>

