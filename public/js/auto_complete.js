$(document).ready(function(){

	var base_url = $('body').attr('base-url');

	$('.jobAutoComplete').autocomplete({
			source: base_url+"workorders/getJobList",
			minLength: 1,
			select: function(event, ui) {
				$("#job").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
						
								
		});


	$('.proj_manAutoComplete').autocomplete({
			source: base_url+"workorders/getUserList?user_type=PM",
			minLength: 1,
			select: function(event, ui) {
				
				$("#proj_man").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
						
								
		});

	$('.sale_perAutoComplete').autocomplete({
			source: base_url+"workorders/getUserList?user_type=SP",
			minLength: 1,
			select: function(event, ui) {
				
				$("#sale_per").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
						
								
		});

	$('.acc_repAutoComplete').autocomplete({
			source: base_url+"workorders/getUserList?user_type=AR",
			minLength: 1,
			select: function(event, ui) {
				
				$("#acc_rep").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
						
								
		});


	$('.crewAutoComplete').autocomplete({
			source: base_url+"workorders/getUserList?user_type=Crew",
			minLength: 1,
			select: function(event, ui) {
				
				$("#crew").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
						
								
		});

	$('.companyAutoComplete').autocomplete({
			source: base_url+"workorders/getCompanyList?company_type=Vendor",
			minLength: 1,
			select: function(event, ui) {
				
				$("#vendor").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
								
		});

	$('.subdivisionAutoComplete').autocomplete({
			source: base_url+"workorders/getCompanyList?company_type=BuilderSubdivision",
			minLength: 1,
			select: function(event, ui) {
				
				$("#subdivision").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
								
		});
		
	$('.estimator_AutoComplete').autocomplete({
			source: base_url+"workorders/getUserList?user_type=estimator",
			minLength: 1,
			select: function(event, ui) {
				
				$("#estimator").val(ui.item ? ui.item.id : "");
				var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
						
								
		});	

	$('.item_AutoComplete').autocomplete({
			source: base_url+"workorders/getWarehouseItemList",
			minLength: 1,
			select: function(event, ui) {
				
				$("#item_id").val(ui.item ? ui.item.id : "");
				//var locationID=ui.item ? ui.item.id : "";
				
			},
	
			html: true, // optional (jquery.ui.autocomplete.html.js required)
						
								
		});


	/*$("#submitFilterForm").click(function(){
		$("#FilterForm").submit();
		alert('rrr');
		var nameidVal = "";
		var idVal = "";
		$('.chckEmpty').each(function(){
			if($(this).val().trim() == ""){
				nameidVal = $(this).attr('id');
				idVal = nameidVal.replace("_name", "");
				alert(idVal);
				$("#"+idVal).val("");
			}
		});

		$("#FilterForm").submit();

	});*/

	$('.chckEmpty').keyup(function(){
		if($(this).val().trim() == ""){
			var nameidVal = $(this).attr('id');
			var idVal = nameidVal.replace("_name", "");
			//alert(idVal);
			$("#"+idVal).val("");
		}
	});
})