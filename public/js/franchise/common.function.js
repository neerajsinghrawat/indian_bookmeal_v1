
$(document).ready(function(){
  alert('sdfdsf');
    $("#feature_Name").keyup(function(){
          var Text = $(this).val();
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          $("#feature_Slug").val(Text);        
    });



    $('.getFeatureGroupUsingCategory').bind('change',function(){
      
      var category_id = $(this).val();
      
      var baseUrl = '{{ URL::to('/admin') }}';
      
      var element_id = $(this).attr('element-id');

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //alert(baseUrl);
      $.ajax({
      
      url: baseUrl+'/features/getAjaxFeatureGroupList',
      
      type: 'post',
      
      data: {category_id: category_id,_token: CSRF_TOKEN},
      
      dataType: 'html',
      
      success: function(result) {
      
      $('#'+element_id).html(result);
      
      }
      
      });
                       
  }); 


  //called when key is pressed in textbox
  $(".number_for").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });



});
