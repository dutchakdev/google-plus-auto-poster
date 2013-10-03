(function($) {	// validate the comment form when it is submitted
	
	// validate signup form on keyup and submit
	$("#authform").validate({
		rules: {
			username: {
				required: true,
				email: true
				},
			password: {
				required: true
				}
		},
		messages: {
			username: {
				required: "Please Enter Your Email id"
				},
			password: {
				required: "Please Enter Your Password"
				}
	}, 
		submitHandler: function() {
			if(getDescription())
		{
			document.getElementById("authform").submit();
		}else {
			return false;	
		}
		}
	});
	
})(jQuery);

