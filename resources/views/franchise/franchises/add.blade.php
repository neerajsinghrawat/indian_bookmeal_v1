@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Franchise
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
            <form action="{{ route('admin.franchises.add.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Franchise Name</label>
                  <input type="text" class="form-control" name="name" id="Franchise_Name" placeholder="Enter Franchise Name" required="required">
                </div>    

                <div class="form-group">
                  <label for="exampleInputEmail1">Franchise Slug</label>
                  <input type="text" class="form-control" name="slug" id="Franchise_Slug" placeholder="Enter Franchise Slug" required="required">
                </div>   

                 <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input class="form-control" name="email" type="email" placeholder="Enter Email" required="required">
                </div>  

                 <div class="form-group">
                  <label for="exampleInputEmail1">Mobile No.</label>
                  <input class="form-control" name="phone" type="number" placeholder="Enter Mobile No." required="required">
                </div>  

                 <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <textarea  class="form-control" name="address"  placeholder="Enter Address" required="required"></textarea>
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

