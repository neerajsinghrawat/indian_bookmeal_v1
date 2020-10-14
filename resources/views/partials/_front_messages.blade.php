@if(Session::has('success'))
 <div id="popup_overlay"></div> 
  <div id="messageModel" class="modal fade-in popup_success" style="display:block">
  
  <div class="modal-dialog" style="max-width:350px">
	
    <div class="modal-content">
      <div class="modal-header" style="width: 346px;
    height: 60px;">
        <h5 class="modal-title" id="exampleModalLabel">{{ Session::get('success_h1') }}</h5>
        <button type="button" class="close close_popup_msg" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Session::get('success') }}
      </div>     
    </div>
  </div>
</div>
    

@endif

@if(Session::has('warning'))
     <div id="popup_overlay"></div> 
 <div id="messageModel" class="modal fade-in popup_warning" style="display:block">
  <div class="modal-dialog" style="max-width:350px">
	
    <div class="modal-content">
      <div class="modal-header" style="width: 346px;
    height: 60px;">
        <h5 class="modal-title" id="exampleModalLabel">{{ Session::get('success_h1') }}</h5>
        <button type="button" class="close close_popup_msg" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Session::get('warning') }}
      </div>
     
    </div>

  </div>
</div>

@endif

@if(Session::has('error'))
	 <div id="popup_overlay"></div> 
	<div id="messageModel" class="modal fade-in popup_error" style="display:block">
  <div class="modal-dialog" style="max-width:350px">
	
    <div class="modal-content">
      <div class="modal-header" style="width: 346px;
    height: 60px;">
        <h5 class="modal-title" id="exampleModalLabel">{{ Session::get('error_h1') }}</h5>
        <button type="button" class="close close_popup_msg" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Session::get('error') }}
      </div>
     
    </div>

  </div>
</div>
    

@endif

<!-- <div class="alert alert-info" role="alert">...</div>
<div class="alert alert-warning" role="alert">...</div>
<div class="alert alert-danger" role="alert">...</div> -->