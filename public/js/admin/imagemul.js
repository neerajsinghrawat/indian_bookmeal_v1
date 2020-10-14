$(document).ready(function(){

var base_url = $('body').attr('base-url');
/*
var developproposals = {
	url: base_url+"designers/uploadproposalimage/"+project_id,
	method: "POST",
	allowedTypes:"jpg,png,gif",
	fileName: "myfile",
	multiple: false,
	

	onSuccess:function(files,data,xhr)
	{
		//alert(data);//alert(data);
		$('ul').append('<li><img src="'+base_url+'uploads/projectimage/200x100/'+data+'" alt="" style="height: 99px;width: 205px;"></li>');
		//$('#projectimages').attr('src',base_url+'uploads/projectimage/'+data);
		//$('#TeamImage').attr('value',data);
		
		$('.upload-statusbar').remove();
		
	},
    afterUploadAll:function()
    {
       
    },
	onError: function(files,status,errMsg)
	{		
		$("#status").html("<font color='red'>Upload is Failed</font>");
	}
}

$(".proposalporject").uploadFile(developproposals);*/



var teamlogo_setting = {
	url: base_url+"projects/uploadprojectimage/"+project_id,
	method: "POST",
	allowedTypes:"jpg,png,gif",
	fileName: "myfile",
	multiple: false,
	

	onSuccess:function(files,data,xhr)
	{
		//alert(data);//alert(data);
		$('ul').append('<li><img src="'+base_url+'uploads/projectimage/200x100/'+data+'" alt="" style="height: 99px;width: 205px;"></li>');
		//$('#projectimages').attr('src',base_url+'uploads/projectimage/'+data);
		//$('#TeamImage').attr('value',data);
		
		$('.upload-statusbar').remove();
		
	},
    afterUploadAll:function()
    {
       
    },
	onError: function(files,status,errMsg)
	{		
		$("#status").html("<font color='red'>Upload is Failed</font>");
	}
}

$(".uploadprojects").uploadFile(teamlogo_setting);


});