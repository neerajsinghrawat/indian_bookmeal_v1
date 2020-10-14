@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Franchise
      </h1>
        <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/franchises') }}" ><b class="a_tag_color">Franchise Manager</b></a></li>
        <li><b >Add Franchise</b></li>
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
                   @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif  
                </div>    

                 <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input class="form-control" name="email" type="email" placeholder="Enter Email" required="required">
                   @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif  
                </div>  

                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>

                  <input class="form-control" id="password" type="password" name="password" placeholder="Enter Password" required>
                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Confirm Password</label>

                  <input class="form-control" id="password-confirm" type="password" placeholder="Enter Confirm Password" name="password_confirmation" required>  
                  @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif      
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Mobile No.</label>
                  <input class="form-control" name="phone" type="number" placeholder="Enter Mobile No." required="required">
                  @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif    
                </div>  

                 <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <textarea  class="form-control" name="address"  placeholder="Enter Address" required="required"></textarea>
                  @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong style="color: red;">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif  
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

