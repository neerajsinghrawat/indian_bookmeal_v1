@if(Session::has('success'))
<div class="row Messages">
    <div class="col-xs-12 msg_class">
    	<div class="alert alert-success" role="alert"><b>{{ Session::get('success') }}</b></div>
 	</div>
 </div>
    

@endif

@if(Session::has('warning'))
    <div class="row Messages">
    <div class="col-xs-12 msg_class">
    	<div class="alert alert-warning" role="alert"><b>{{ Session::get('warning') }}</b></div>
 	</div>
 </div>

@endif

@if(Session::has('error'))
    <div class="row Messages">
    <div class="col-xs-12 msg_class">
    	<div class="alert alert-danger" role="alert"><b>{{ Session::get('error') }}</b></div>
 	</div>
 </div>

@endif
<style>.msg_class{margin-top: 4px;margin-left: 4px;margin-right: 29px;width: 99%;z-index: 999;text-align: center;}</style>
<!-- <div class="alert alert-info" role="alert">...</div>
<div class="alert alert-warning" role="alert">...</div>
<div class="alert alert-danger" role="alert">...</div> -->