@extends('layouts.franchiselogin')

@section('content')


<div class="login-box">
  <div class="login-logo">
    
     <b>Franchise Login</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form form method="POST" action="{{ route('franchise.login.submit') }}">
        {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required="required">
         @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password" type="password" name="password" required class="form-control" placeholder="Password">
        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" value="submit"  class="btn bg-purple btn-flat margin">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


@endsection
