@extends('layouts.admin')
<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    setTimeout(function(){
       jQuery('#paypalForm').submit();
    },1000);
 });
</script>
@section('content')

 <!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypalForm"  target="_top">  -->  
          <form action="{{ route('admin.payments.paypal.post') }}" method="post" id="paypalForm">   
          {{ csrf_field() }}   
                  <!-- Identify your business so that you can collect the payments. -->
                <!--   <input name="business" value="info@codexworld.com" type="hidden">  -->
                  <input name="business" value="rawat.neeraj.510-facilitator@gmail.com" type="hidden">
         
                  <!-- Specify a Buy Now button. -->
                  <input name="cmd" value="_xclick" type="hidden">         
                  <!-- Specify details about the item that buyers will purchase. -->
                  <input type="hidden" name="item_name" value="test"> 
                  <input type="hidden" name="item_number" value="1">
                  <input type="hidden" name="amount" value="0.1">
                  <input name="currency_code" value="USD" type="hidden">
                  <input type="hidden" name="custom" value="1">
                  <input type="hidden" name="user_id" value="555555555555555">


                  <!-- Specify URLs -->
                  
                  <input type='hidden' name='cancel_return' value='{{ URL::to('admin/products/cancel') }}'>
                   <input type='hidden' name='notify_url' value='{{ URL::to('admin/products/notify') }}'>
                  <input type='hidden' name='return' value='{{ URL::to('admin/products/success') }}'>
                
 
</form> 
@endsection
