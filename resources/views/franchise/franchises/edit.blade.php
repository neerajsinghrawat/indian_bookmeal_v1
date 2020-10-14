@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Category
      </h1>
      <ol class="breadcrumb">
       <?php //echo '<pre>';print_r($categories);die;
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
            {!! Form::open(array('url' => url('admin/franchises/edit/'.$franchises['id']),'files'=>true ,'method'=>'put')) !!}
             {{ csrf_field() }}

              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Franchise Name</label>
                  <input type="text" class="form-control" name="name" id="Franchise_Name" value="{{ $franchises['name'] }}">
                </div>                
        
                <div class="form-group">
                  <label for="exampleInputEmail1">Franchise Slug </label>
                  <input type="text" class="form-control" name="slug" id="Franchise_Slug" value="{{ $franchises['slug'] }}">
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input class="form-control" name="email" type="email" placeholder="Enter Email" required="required" value="{{ $franchises['email'] }}">
                </div>  

                 <div class="form-group">
                  <label for="exampleInputEmail1">Mobile No.</label>
                  <input class="form-control" name="phone" type="number" placeholder="Enter Mobile No." required="required" value="{{ $franchises['phone'] }}">
                </div>  

                 <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <textarea  class="form-control" name="address"  placeholder="Enter Address" required="required">{{ $franchises['address'] }}</textarea>
                </div>  

               
                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status"  {{ ($franchises['status'] == 1)?'checked':'unchecked' }}>
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
    $("#Franchise_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#Franchise_Slug").val(Text);        
    });
});
</script>
