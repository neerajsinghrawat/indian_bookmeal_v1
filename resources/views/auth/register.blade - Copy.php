@extends('layouts.front')

@section('content')




<div class="pageTitle">
    <div class="container">
    <h1>Register</h1>
    </div>
    </div>
    
     <div class="container">
     <div class="bodyInner">
            

        <!-- insert the page content here -->
        
        <!-- <p>Below is an example of how a contact form might look with this template:</p> -->
        <form  method="POST" action="{{ route('register') }}">
             {{ csrf_field() }}
          <div class="form_settings">
            <!--  -->


            <p><span>First Name</span><input class="form-control" type="text" name="first_name" required>
               @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </p>

            <p><span>Last Name</span><input class="form-control" type="text" name="last_name" required>
               @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </p>

            <p><span>E-Mail Address </span><input class="form-control" type="email" name="email" required>
                     @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
            </p>

            <p><span>Mobile number</span><input class="form-control" type="number" name="phone" required>
               @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </p>
           

            <p><span>Password</span><input class="form-control" id="password" type="password" name="password" required>
                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
            </p>

            <p><span>Confirm Password</span><input class="form-control" id="password-confirm" type="password" name="password_confirmation" required>    
             @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif    
            </p>

            <p><span>Address </span><input class="form-control" id="name" type="text" name="address" value="" required>
               @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                @endif
            </p>

            <p><span>Post Code</span><input class="form-control" id="name" type="text" name="postcode" required>
               @if ($errors->has('postcode'))
                    <span class="help-block">
                        <strong>{{ $errors->first('postcode') }}</strong>
                    </span>
                @endif
            </p>

            <p style="padding-top: 15px">
                <input class="btn btn-info" type="submit" value="Register" />
            </p>
           
          </div>
        </form>



    </div>
    </div>
    
    

    <div class="highlightSection">
    <div class="container">
    <div class="row">
        <div class="col-lg-4">
        <div class="media">
            <a href="menu/"><img src="http://dev.bombaytakeawayclub.com/assets/img/nepali-momo.png" alt="nepali-momo"> </a>
            <h3 class="media-heading text-primary-theme">NEPALESE LAMB MOMO</h3>
            <p>Steamed dumplings filled with slightly spiced minced meat served with special sauce.</p>
        </div>
        </div>
        <div class="col-lg-4">
        <div class="media"><a href="menu/"><img src="http://dev.bombaytakeawayclub.com/assets/img/gorkha-special-chicken.png" alt="GURKHA SPECIAL CHICKEN"> </a>                        
        <h3 class="media-heading text-danger-theme">GURKHA SPECIAL CHICKEN</h3>
        <p>Boneless chicken marinated in mustard, smoked chilli, herbs and spices slowly cooked in tandoor. </p>
        
        </div>
        </div>
        <div class="col-lg-4">
        <div class="media">
        <a href="menu/"><img src="http://dev.bombaytakeawayclub.com/assets/img/lam-tikka.png" alt="Lam Tikka"> </a>
        <h3 class="media-heading">LAMB TIKKA SPECIAL</h3>
        <p>Tender pieces of lamb mixed with our own spices and gently cooked in clay oven. </p>
        </div>
        </div>
    </div>
    </div>
    </div>
    
    

    <div class="introSection">
        <div class="container">
        <div class="row">
        <div class="col-lg-5">
        <h3>Welcome to restaurent</h3>
        <p>
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 
        text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
        It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. <br><br>
        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
        and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        </div>
        
        <div class="col-lg-4">
        <h3>Welcome to restaurent</h3>
        <p>
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 
        text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
        It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. <br><br>
        
        </p>
        
        </div>
        
        <div class="col-lg-3">
        <h3>Welcome to restaurent</h3>
        <p>
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 
        text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
        
        </p>
        
        </div>
        
        </div>
        </div>
    </div>


@endsection
