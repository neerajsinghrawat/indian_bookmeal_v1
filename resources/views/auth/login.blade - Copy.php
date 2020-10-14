@extends('layouts.front')

@section('content')

<div class="pageTitle">
    <div class="container">
    <h1>Login</h1>
    </div>
    </div>
    
     <div class="container">
     <div class="bodyInner">
            
        
        <!-- <p>Below is an example of how a contact form might look with this template:</p> -->
        <form method="POST" action="{{ route('login') }}">
             {{ csrf_field() }}
          <div class="">
            <!--  -->
            <p><span>Email</span><input class="form-control"  type="email" name="email" placeholder="Enter Your Email" required/>
                  @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </p>
            <p><span>Password</span><input class="form-control" id="password" type="password" name="password" placeholder="Enter Your Password" required/> </p>
                     @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            <p style="padding-top: 15px;float: right;">
                <span>
                    <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
                </span><input class="btn btn-info" type="submit" value="Login" />
            </p>
           
          </div>
        </form>
    </div>
</div>

@endsection
