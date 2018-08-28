function updateUtilityElec(){
	$('.s1_submit').prop("disabled", true);
	$.ajax({
       url: $('#solarapi_endpoint').val()+'/site/solarapi2',
       type: 'post',
       data: {
                 address: $('#s1_home_address').val() , 
                 _csrf : $('#csrf_token').val()
             },
       success: function (data) {
       		$('.s1_submit').prop("disabled", false);
	       	var return_list = JSON.parse(data.ratesratesReturn);
	       	console.log(return_list);
	       	if (return_list["errors"].length == 0)
          	{
	          	$("#s2_utility_co").html(return_list["outputs"]["utility_name"]);
	          	$("#s2_elec_rate").html(parseFloat(return_list["outputs"]["residential"]).toFixed(2));
	          	$.fn.fullpage.moveSectionDown();
	        }else{
	        	alert("No Utility and Residential Info. Please input another address.");
	        }
       }
    });
}

function updateSolarAPI(flg){
	if ($('#s2_txt_system_size').val() == "0"){
		alert("Please input estimated system size");
		return;
	}
	if ($('#s2_txt_system_size').val() < 0.05)
	{
		// alert("System capacity must be between 0.05 and 500000. Please input monthly bill using slider or mannual input.");
		$('#s2_txt_system_size').val(0.05);
		return;	
	}
	if ($('#s1_home_address').val().length == 0){
		alert("Please input address");
		return;	
	}
	if ($('#s2_txt_azimuth').val().length == 0){
		alert("Please input azimuth");
		return;	
	}
	if ($('#s2_txt_tilt_angle').val().length == 0){
		alert("Please input tilt angle");
		return;	
	}
	if ($('#s2_txt_system_lose').val().length == 0){
		alert("Please input system loses");
		return;	
	}
	$('#s2_btn_right_go').prop("disabled", true);
	$('#s2_right_go').prop("disabled", true);
	$.ajax({
       url: $('#solarapi_endpoint').val()+'/site/solarapi',
       type: 'post',
       data: {
                 address: $('#s1_home_address').val() , 
                 system_capacity: $('#s2_txt_system_size').val(),
                 azimuth: $('#s2_txt_azimuth').val(),
                 tilt: $('#s2_txt_tilt_angle').val(),
                 _csrf : $('#csrf_token').val(),
                 module_type: $('#s2_select_module_type').val(),
                 system_lose: $('#s2_txt_system_lose').val()
             },
       success: function (data) {
          	var return_list = JSON.parse(data.search);
          	// console.log(return_list);
      		$('#s2_btn_right_go').prop("disabled", false);
			$('#s2_right_go').prop("disabled", false);
          	
          	if (return_list["errors"].length == 0)
          	{
          		// var ac_annual = return_list["outputs"]["ac_annual"];
              	// var capacity_factor = return_list["outputs"]["capacity_factor"];
              	// var solrad_annual = return_list["outputs"]["solrad_annual"];
              	console.log('solrad_annual: '+return_list["outputs"]["solrad_annual"]);
              	var dc_annual = 0;
              	var ac_annual = 0;
              	var capacity_factor = 0;
              	var solrad_annual = 0;
              	
              	var ac_monthly = return_list["outputs"]["ac_monthly"];
              	var dc_monthly = return_list["outputs"]["dc_monthly"];
              	var poa_monthly = return_list["outputs"]["poa_monthly"];
              	var solrad_monthly = return_list["outputs"]["solrad_monthly"];

              	for (var i = 0; i < 12; i ++){
              		$('#ac_dc'+i).html("<h4>"+Math.round(ac_monthly[i]) + " / " + Math.round(dc_monthly[i])+"</h4>");
              		$('#poa'+i).html("<h4>$"+Math.round(parseFloat(ac_monthly[i] * $("#s2_elec_rate").text()).toFixed(2))+"</h4>");
              		$('#solrad'+i).html("<h4>"+parseFloat(solrad_monthly[i]).toFixed(2)+"</h4>");
              		dc_annual += dc_monthly[i];
              		ac_annual += ac_monthly[i];
              		capacity_factor += ac_monthly[i] * $("#s2_elec_rate").text();
              		solrad_annual += solrad_monthly[i];
              	}
              	$('#ac_dc_annual').html("<h4>" + Math.round(ac_annual) +" / " + Math.round(dc_annual) +" </h4><h4>" + Math.round(ac_annual / 12) +" / " + Math.round(dc_annual / 12) +" </h4>");
              	$('#capacity_factor').html("<h4>$" + Math.round(parseFloat(capacity_factor).toFixed(2)) +" </h4><h4>$" + Math.round(parseFloat(capacity_factor/12).toFixed(2)) +" </h4>");
              	$('#solrad_annual').html("<h4>" + parseFloat(solrad_annual).toFixed(2) +" </h4><h4>" + parseFloat(solrad_annual/12).toFixed(2) +" </h4>");


              	if (flg == 2)//change slider event
	          	{
	          		  var bill_amount = $("#s2_monthly_bill").val();
	          		  // console.log("v1:" + bill_amount);
					  var modified_bill_amount = bill_amount - 15; 
					  // console.log("v2:" + modified_bill_amount);
					  var electricity_cost = $('#s2_elec_rate').text();
					  // console.log("v3:" + electricity_cost);
					  var monthly_kwh = modified_bill_amount / electricity_cost;
					  // console.log("v4:" + monthly_kwh);
					  var annual_kwh = monthly_kwh * 12;
					  // console.log("v5:" + annual_kwh);
					  var avg_solar_radiation = solrad_annual/12;
					  // console.log("v6:" + avg_solar_radiation);
					  var kwh_needed = annual_kwh / 365 / avg_solar_radiation;
					  // console.log("v7:" + kwh_needed);
					  console.log("Estimated System Size:" + parseFloat(annual_kwh).toFixed(2));
					  console.log("kWh needed:" + parseFloat(kwh_needed).toFixed(2));

					  /******* Circle Progress *******/
					  var sys_size;
					  if (parseFloat(kwh_needed).toFixed(2) < 0.05)
					  	sys_size = 0.05;
					  else
					  	sys_size = parseFloat(kwh_needed).toFixed(2);
					  $('#s2_txt_system_size').val(sys_size);
  					  setTimeout(function() { $('.circle').circleProgress('value', sys_size/60); }, 100);
	          	}
          	}else{
              	for (var i = 0; i < 12; i ++){
              		$('#ac_dc'+i).html("<h4></h4>");
              		$('#poa'+i).html("<h4></h4>");
              		$('#solrad'+i).html("<h4></h4>");
              	}
              	$('#ac_dc_annual').html("<h4></h4>");
              	$('#capacity_factor').html("<h4></h4>");
              	$('#solrad_annual').html("<h4></h4>");    

              	if (flg == 2){
              		console.log(return_list);
              		alert("Average Solar Radiation is not initiated. Please check input again.");
              	}
          	}

          	if (flg == 1)//to page2a event
          	{
	          	$('.s2_page_a').hide();
				$('.s2_page_b').show();

				$('#s2_left_go').css("background", "#b5e31b");
				$('#s2_right_go').css("background", "#fefefe");

				$('#s2_left_go').show();
				$('#s2_right_go').hide();
          	}
       }
    });
}


$(document).ready(function(){
	var section_height = $('.section').height();
	var win_height = $(window).height();
	// if (section_height < win_height)
	{
		$(".bottom_image").addClass("bottom_image2");
	}

	// Section 3
	$('.s3_box1>div div').on("click", function(){
		$('.s3_box1>div div').removeClass("s3_roof_active");
		$(this).addClass("s3_roof_active");
	});
	$(".s4_mainbox input").on("keyup", function(){
		$("#s4_address2").prop("placeholder","");
	});	


	// Section 5
	$('.s5_tab_menu').on("click", function(){
		$('.s5_tab_menu').removeClass('s5_tab_menu_clicked');
		$(this).addClass('s5_tab_menu_clicked');
	});

	$('#tab_menu1').on("click", function(){
		$('.s5_box2').hide();
		$('#tab1').show();
	});
	$('#tab_menu2').on("click", function(){
		$('.s5_box2').hide();
		$('#tab2').show();
	});
	$('#tab_menu3').on("click", function(){
		$('.s5_box2').hide();
		$('#tab3').show();
	});

	$('#s5_btn_details2').on("click", function(){
		if ($('#s5_detailed_info2').is(':visible'))
			$('#s5_detailed_info2').hide();
		else
			$('#s5_detailed_info2').show();
	});
	$('#s5_btn_details1').on("click", function(){
		if ($('#s5_detailed_info1').is(':visible'))
			$('#s5_detailed_info1').hide();
		else
			$('#s5_detailed_info1').show();
	});


	// Section1
	$('.s1_submit').on("click", function(){
		if ($('.s1_home_address').val().length > 0){
			updateUtilityElec();
		}
		else
			alert("Please input Home Address");
	});


	// Section2	
	$('#s2_left_go').on("click", function(){
		$('.s2_page_a').show();
		$('.s2_page_b').hide();

		$('#s2_left_go').css("background", "#fefefe");
		$('#s2_right_go').css("background", "#b5e31b");
		$('#s2_left_go').hide();
		$('#s2_right_go').show();
	});
	$('#s2_right_go').on("click", function(){
		if ($('.s1_home_address').val().length > 0){
			updateSolarAPI(1);
		}else{
			alert("Please input Home Address");
		}	
	});

	
	$("#s2_btn_sys_lose").on("click", function(){
		$("#s2_modal_syslose").show();
	});

	$('.s2_fa_azimuth').on("click", function(){
		if ($('#s2_txt_azimuth').attr("title") != "1"){
			$('.s2_fa_azimuth').removeClass("fa fa-pencil-square-o");
			$('.s2_fa_azimuth').addClass("fa fa-floppy-o");
			$('#s2_txt_azimuth').attr("title", "1");
			$('#s2_txt_azimuth').prop("disabled", false);
		}else{
			$('.s2_fa_azimuth').removeClass("fa fa-floppy-o");
			$('.s2_fa_azimuth').addClass("fa fa-pencil-square-o");
			$('#s2_txt_azimuth').attr("title", "0");
			$('#s2_txt_azimuth').prop("disabled", true);
		}		
	});
	$('.s2_fa_tilt_angle').on("click", function(){
		if ($('#s2_txt_tilt_angle').attr("title") != "1"){
			$('.s2_fa_tilt_angle').removeClass("fa fa-pencil-square-o");
			$('.s2_fa_tilt_angle').addClass("fa fa-floppy-o");
			$('#s2_txt_tilt_angle').attr("title", "1");
			$('#s2_txt_tilt_angle').prop("disabled", false);
		}else{
			$('.s2_fa_tilt_angle').removeClass("fa fa-floppy-o");
			$('.s2_fa_tilt_angle').addClass("fa fa-pencil-square-o");
			$('#s2_txt_tilt_angle').attr("title", "0");
			$('#s2_txt_tilt_angle').prop("disabled", true);
		}	
	});
	$('.s2_fa_system_lose').on("click", function(){
		if ($('#s2_txt_system_lose').attr("title") != "1"){
			$('.s2_fa_system_lose').removeClass("fa fa-pencil-square-o");
			$('.s2_fa_system_lose').addClass("fa fa-floppy-o");
			$('#s2_txt_system_lose').attr("title", "1");
			$('#s2_txt_system_lose').prop("disabled", false);
		}else{
			$('.s2_fa_system_lose').removeClass("fa fa-floppy-o");
			$('.s2_fa_system_lose').addClass("fa fa-pencil-square-o");
			$('#s2_txt_system_lose').attr("title", "0");
			$('#s2_txt_system_lose').prop("disabled", true);
		}	
	});

	// first continue
	$('#s2_btn_right_go').on("click", function(){
		if ($('.s1_home_address').val().length > 0){
			updateSolarAPI(1);
		}else{
			alert("Please input Home Address");
		}		
	});

	// second continue
	$('#s2_btn_left_go').on("click", function(){
		//To next page
		$.fn.fullpage.moveSectionDown();
	});

	// Modal Manual Input
	$('.s2_modal_row input').blur(function(){
		var avg = $("#s2_cost"+$(this).prop("title")).val() / $("#s2_cons"+$(this).prop("title")).val();
		// console.log($("#s2_cons"+$(this).prop("title")).val());
		// console.log($("#s2_cost"+$(this).prop("title")).val());
		if ($("#s2_cons"+$(this).prop("title")).val()!="" && $("#s2_cost"+$(this).prop("title")).val()!="")
			$("#s2_avg"+$(this).prop("title")).text(parseFloat(avg).toFixed(2));
		var avg_rate = 0;
		var kwh_cons = 0;
		var total_cost = 0;
		for(var index = 1; index <= 12; index++)
		{
			if ($("#s2_avg"+index).text() != ""){
				avg_rate += ($("#s2_avg"+index).text() * 10) / 10;
			}
			if ($("#s2_cons"+index).val() != ""){
				kwh_cons += ($("#s2_cons"+index).val() * 10) / 10;
			}
			if ($("#s2_cost"+index).val() != ""){
				total_cost += ($("#s2_cost"+index).val() * 10) / 10;
			}				
		}
		// console.log("kwh_cons:"+kwh_cons);
		avg_rate /= 12.0;
		$("#s2_avg_kwh").text("$/kWh Avg.Rate "+parseFloat(avg_rate).toFixed(2));
		$("#s2_avg_kwh").prop("title",parseFloat(avg_rate).toFixed(2));
		$("#s2_kwh_cons").text("kWh Cons. "+parseFloat(kwh_cons).toFixed(2));
		$("#s2_kwh_cons").prop("title",parseFloat(kwh_cons).toFixed(2));
		$("#s2_kwh_cost").text("$Cost $"+parseFloat(total_cost).toFixed(2));
		$("#s2_kwh_cost").prop("title",parseFloat(total_cost).toFixed(2));
	});

	// Verification Mehtods
	$("#s4_veri_method").on("change", function(){
		if ($(this).val() == 0){
			$("#s4_email_veri").hide();
			$("#s4_phone_number_veri").show();
		}else if ($(this).val() == 1){
			$("#s4_email_veri").show();
			$("#s4_phone_number_veri").hide();
		}
	});

	// Auto Pop Email
	$("#s4_email_address").on("keyup", function(){
		$("#s4_email_veri").val($("#s4_email_address").val());
	});

	// Phone Number Format
	$("#s4_contact_number").mask("(999) 999-9999");
	$("#s4_phone_number_veri").mask("(999) 999-9999");

	// Auto Pop PhoneNumber
	$("#s4_phone_number_veri").on("keyup", function(){
		$("#s4_contact_number").val($("#s4_phone_number_veri").val());
	});

	$('#slider_input').tooltip('show');
});

$("#s4_btn_save_continue").on("click", function(){

});