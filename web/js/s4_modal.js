function checkEmail(email) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(email.value)) {
	    alert('Please provide a valid email address');
	    email.focus();
	    return false;
	}
	return true;
}

function sendSMS(phone){
	console.log(phone);
	$.ajax({
       url: $('#solarapi_endpoint').val()+'/site/sendsms',
       type: 'post',
       data: {
                 number: phone , 
                 _csrf : $('#csrf_token').val()
             },
       success: function (data) {
	       	var return_code = JSON.parse(data.return_code);
	       	console.log(return_code);
	       	if (return_code == -1)
	       	{
	   			alert("SMS verification failed");
	       	}else{
	       		$('#s4_modal').show();
	       	}
       	}, error: function(data){
       		alert("SMS verification failed");
       	}
    });
}

$('#s4_btn_submit').on("click", function() {
	 	// s4_phone_number
	 if ($("#s4_firstname").val().trim().length == 0){
	 	alert("Please input firstname");
	 	$("#s4_firstname").focus();
	 	return;
	 }
	 if ($("#s4_lastname").val().trim().length == 0){
	 	alert("Please input lastname");                          
	 	$("#s4_lastname").focus();
	 	return;
	 }
	 if ($("#s4_address1").val().trim().length == 0){
	 	alert("Please input street address");
	 	$("#s4_address1").focus();
	 	return;
	 }
	 if ($("#s4_password").val().trim().length == 0){
	 	alert("Please input password");
	 	$("#s4_password").focus();
	 	return;     
	 }
	 if ($("#s4_password").val().trim().length < 8){
	 	alert("Please input more than 8 characters password");
	 	return;
	 }
	 if ($("#s4_password").val().trim() != $("#s4_repassword").val().trim()){
	 	alert("Passwords are not matching");
	 	return;
	 }
	 if ($("#s4_city").val().trim().length == 0){
	 	alert("Please input city");
	 	$("#s4_city").focus();
	 	return;
	 }
	 if ($("#s4_state").val() == "0"){
	 	alert("Please input state");
	 	$("#s4_state").focus();
	 	return;
	 }
	 if ($("#s4_contact_number").val().trim().length == 0){
	 	alert("Please input contact number");
	 	$("#s4_contact_number").focus();
	 	return;
	 }
	 if ($("#s4_zipcode").val().trim().length == 0){
	 	alert("Please input zipcode");
	 	$("#s4_zipcode").focus();
	 	return;
	 }
	 if ($("#s4_residence").val().trim().length == 0){
	 	alert("Please input residence");
	 	$("#s4_residence").focus();
	 	return;
	 }
	 if (!checkEmail(document.getElementById('s4_email_address'))){
	 	return;
	 }
	 var recaptcha = $('#g-recaptcha-response').val();
	 if(recaptcha == "")
	 {
		$('#captchar-error').css('display', 'block');
	 	alert("Please verify");
	 	return;
	 }
	 if ($("#s4_veri_method").val() == 0){
	 	//SMS verification
	 	if ($("#s4_phone_number_veri").val().trim().length == 0){
	 		alert("Please input verify phone number");
	 		$("#s4_phone_number_veri").focus();
	 		return;
	 	}
	 	//Sending SMS
	 	sendSMS($("#s4_phone_number_veri").data( $.mask.dataName )());
	 }else if ($("#s4_veri_method").val() == 1){
	 	//Email Verification
	 	if ($("#s4_email_veri").val().trim().length == 0){
	 		alert("Please input verify email");
	 		$("#s4_email_veri").focus();
	 		return;
	 	}
		if (!checkEmail(document.getElementById('s4_email_veri'))){
			return;
		}

		//Sending Email
		$.ajax({
	       url: $('#solarapi_endpoint').val()+'/site/sendemail',
	       type: 'post',
	       data: {
	                 email: $('#s4_email_veri').val() , 
	                 _csrf : $('#csrf_token').val()
	             },
	       success: function (data) {
		       	var result_code = JSON.parse(data.result);
		       	console.log(result_code);
		       	if (result_code == 2000){//success
		       		$('#s4_modal').show();
		       	}else{
		       		alert("Email verification failed");
		       	}
	       }
	    });
	 }
});

$('.s4_modal_save_continue').on("click", function(){
	if ($(".s4_veri_input").val() != ""){
		alert("Your information is saved");
		//compare, save
		//--- ---
		//--- ---
		$('#s4_modal').hide();	
	}else{
		alert("Please input verification code");
	}
	
});

$('.s4_modal_resend').on("click", function(){
	alert("Verification is sent again");
	$('#s4_modal').hide();
});