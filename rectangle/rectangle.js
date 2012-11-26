function calculate(width, height) { 
	$.ajax({
		url: "rectangle.php", 
		data: { width: width, height: height }, 
		type: "post"
	}).success(function(data) { 
		$("#result").html("The area of this rectangle is " + data['area'] + " units and the length of a diagonal line through the center is " + data['diag'] + " units."); 
	}); 
}	

$(document).ready(function() { 
	$("#submit").click(function() { 
		if ($("#width").val() == "" || $("#height").val() == "") 
			return; 

		calculate($("#width").val(), $("#height").val()); 
	}); 
}); 