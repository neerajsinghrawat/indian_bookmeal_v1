@extends('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <script src="{{ asset('js/admin/ckeditor/ckeditor.js') }}"></script>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Email Template
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin') }}"><i class="fa fa-dashboard"></i><b class="a_tag_color">Home</b></a></li>
        <li><a href="{{ URL::to('admin/emailTemplates') }}" ><b class="a_tag_color">Email Template Manager</b></a></li>
        <li><b >Add Email Template</b></li>
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
            <form action="{{ route('admin.emailTemplates.add.post') }}" enctype="multipart/form-data" method="POST" >
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Template Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter Template Name" required="required">
                </div>



                <div class="form-group">
                  <label for="exampleInputEmail1">Subject</label>
                  <input type="text" class="form-control" name="subject"  placeholder="Enter Subject" required="required">
                </div>   

                <div class="form-group">
                  <label for="exampleInputEmail1">Type</label>
                   <select name="type" class="form-control" required="required">
                     <option value="">-Select Type-</option>
                     <option value="admin">Admin</option>
                     <option value="user">User</option>
                    
                   </select>
                </div>
                


                <div class="form-group">
                  <label for="exampleInputEmail1">Message</label>
                  <textarea class="form-control" name="message" id="editor1" placeholder="Enter Message"></textarea> 
                </div> 

                <div class="form-group">
                  <label for="exampleInputPassword1">Status</label>
                   <input type="checkbox" name="status">
                </div>

                <div class="form-group">
          <div class="col-md-6">
                  <label for="exampleInputPassword1">Customer Keywords: </label><br/>
                  #CUSTOMER_USERNAME<br />
                  #CUSTOMER_FNAME<br />
                  #CUSTOMER_LNAME<br />
                  #CUSTOMER_EMAIL<br />
                  #CUSTOMER_PHONE<br />
                  #CUSTOMER_PASSWORD<br />
                  #CUSTOMER_ADDRESS<br />
                  #CUSTOMER_POSTCODE<br />
          </div>          

          <div class="col-md-6">
                  <label for="exampleInputPassword1">Customer Keywords: </label><br/>
                 #CUSTOMER_ORDER_SUMMARY<br/> 
                 #CUSTOMER_TABLE_RESERVATIONS<br/>
          </div>
          <!-- <div class="col-md-6">
                  <label for="exampleInputPassword1">Student Keywords: </label><br/>
                  #STUDENT_NAME<br />
                  #STUDENT_AASKID<br />
                  #STUDENT_REFERANCE_CODE<br /> 
                  #STUDENT_COURSES<br />
                  #STUDENT_CONTACT_NUMBER<br />
                 
                 
          </div> -->
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


