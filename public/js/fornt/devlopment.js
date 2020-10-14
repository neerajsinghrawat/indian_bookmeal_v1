/*********************search postcode autocomplete****************************/

  $(document).ready(function(){
        $(".postalAutoComplete").autocomplete({
          source: baseUrl+"/products/autocomplete_postcode",
          minLength: 1,
          select: function(event, ui) {
            //alert('kjk');
             //console.log(ui.item.label);
             $('.postalAutoComplete').val(ui.item.label);
          },
      
          html: true, // optional (jquery.ui.autocomplete.html.js required)
      
          
        });        
  });
