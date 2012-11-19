        function verify_captcha_text() {
                if ($("#input").val() == "") {
			$("#result_image").hide(); 
                        return;
                }

                $.ajax({
                        url: "verify_captcha.php",
                        data: { input: $("#input").val() },
                        type: "post"
                }).success(function(data) {
                        if (data['gotit'] == 'FALSE' || data['len'] == 'FALSE') {
				$("#result_image").hide(); 
                                return;
			}

                        $("#image").show();
                        if (data['captcha'] == 'TRUE')
                                $("#result_image").attr("src", "images/check.jpg");
                        else if (data['captcha'] == 'FALSE')
                                $("#result_image").attr("src", "images/x.jpg");

			$("#result_image").show(); 
                });
        }

	function reloadImg(id, len) {
		var obj = document.getElementById(id);
		var src = obj.src;
		var pos = src.indexOf('?');
		if (pos >= 0) {
			src = src.substr(0, pos);
		}
		
		var date = new Date();
		if (len == -1) { 
			obj.src = src + '?v=' + date.getTime();
		} else {
			obj.src = src + '?len=' + len + '&v=' + date.getTime(); 
		}

		$("#result_image").hide(); 
		$("#input").val(""); 
	
		return false;
	}

	function new_length(direction) { 
		$.ajax({
			url: "captcha_len.php", 
			data: { dir: direction }, 
			type: "post"
		}).success(function(data) { 
			if (data['max'] == 1 && direction == 1) 
				return; 

			if (data['min'] == 1 && direction == 0) 
				return; 
			
			reloadImg("captcha_image", data['len']); 
		}); 
	}

	
	// global variables for the images to preload
	var i_check; 
	var i_x; 
	var i_plus; 
	var i_minus; 
        $(document).ready(function() {
		i_check = new Image(); 
		i_x     = new Image(); 
		i_plus  = new Image(); 
		i_minus = new Image(); 

		i_check.src = "images/check.jpg"; 
		i_x.src     = "images/x.jpg"; 
		i_plus.src  = "images/plus.png"; 
		i_minus.src = "images/minus.png"; 

		$("#result_image").hide(); 
                $("#input").keyup(verify_captcha_text);
                $("#input").blur(verify_captcha_text);

		$("#captcha").click(function() { reloadImg("captcha_image", -1); }); 
		$("#minus_img").click(function() { new_length(0); });
		$("#plus_img").click(function() { new_length(1); }); 
        });
