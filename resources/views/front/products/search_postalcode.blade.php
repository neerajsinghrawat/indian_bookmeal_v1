@extends('layouts.front')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
            <!-- Breadcrumb Start -->
            <div class="bread-crumb">
                <div class="container">
                    <div class="matter">
                        <h2>{{ (!empty($slug))?ucwords($slug):'' }} Menu</h2>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ url('/') }}">HOME</a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)">{{ (!empty($slug))?ucwords($slug):'' }} Menu</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="pageTitle">
    <div class="container">
    <h1>Search Your postal code </h1>
    </div>
    </div>
    
     <div class="container">
     <div class="bodyInner">
            
        
        <!-- <p>Below is an example of how a contact form might look with this template:</p> -->
        <form method="POST" action="{{ route('products.search_postalcode.post') }}">
             {{ csrf_field() }}
          <div class="">
            <!--  -->
            <p><input class="form-control auto"  id="postalAutoComplete" type="text" name="code" placeholder="Enter Your Postal Code" required/>
                  @if ($errors->has('code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('code') }}</strong>
                    </span>
                @endif
            </p>
           
            <p style="padding-top: 15px;float: right;">
                <span>
                   
                </span><input class="btn btn-info" type="submit" value="Search" />
            </p>
           
          </div>
        </form>
    </div>
</div>




<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

var baseUrl = '{{ URL::to('/') }}';

    $(function() {
      
        $("#postalAutoComplete").autocomplete({
          source: baseUrl+"/products/autocomplete_postcode",
          minLength: 1,
          select: function(event, ui) {
            
             console.log(ui);
          },
      
          html: true, // optional (jquery.ui.autocomplete.html.js required)
      
          
        });
        
      });
</script>
@endsection
