$(document).ready(function(){
	$("#enviatag").click(function() {
	// we want to store the values from the form input box, then send via ajax below
	var tag     = $('#tag').attr('value');
		$.ajax({
			type: "POST",
			url: "blog_ajax.php",
			data: "tag="+ tag,
			//data: "fname="+ fname +"&amp; lname="+ lname,
			success: function(){
				//$('form#form1').hide(function(){$('div.success').fadeIn();});
				alert('rolou');
			}
		});
	return false;
	});
});
