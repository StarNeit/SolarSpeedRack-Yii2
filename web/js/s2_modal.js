$('.s2_btn_actual_usage').on("click", function(){
	$('.s2_modal').show();
});

$('.s2_btn_save_data').on("click", function(){
	$("#s2_monthly_bill").val($("#s2_kwh_cost").prop("title"));
      if ($("#s2_txt_system_size").val()=="0")
          $("#s2_txt_system_size").val('4');
	updateSolarAPI(2);
	$('.s2_modal').hide();
});

$('.s2_btn_clear_data').on("click", function(){
	for(var index = 1; index <= 12; index++)
	{
		$("#s2_avg"+index).text("0.00");
		$("#s2_cons"+index).val("");
		$("#s2_cost"+index).val("");
	}
});

$('.s2_btn_sun_map').on("click", function(){
	// $('.s2_modal').hide();
});

var span = document.getElementsByClassName("s2_close")[0];
span.onclick = function(){
	$('.s2_modal').hide();
}


//--- System Losses Modal Dlg ---//
$(function(){
	$("#s2_modal_syslose input").val("0");
});
$(".s2_btn_m2_help").on("click", function(){
	$("#s2_modal_syslose").hide();
});

$(".s2_btn_m2_reset").on("click", function(){
	$("#s2_modal_syslose input").val("0");
	$("#s2_result_loss").text("0%");
	$("#s2_result_loss").prop("title", "0");
});

$(".s2_btn_m2_cancel").on("click", function(){
	$("#s2_modal_syslose").hide();
});

$("#s2_modal_syslose input").on("keyup", function(){
	$("#s2_result_loss").text( Math.round((1 - (1 - $("#s2_sysloss_solling").val()/100) * (1 - $("#s2_sysloss_shading").val()/100) * (1 - $("#s2_sysloss_snow").val()/100) * (1 - $("#s2_sysloss_mismatch").val()/100) * (1 - $("#s2_sysloss_wiring").val()/100) * (1 - $("#s2_sysloss_connections").val()/100) * (1 - $("#s2_sysloss_degradation").val()/100) * (1 - $("#s2_sysloss_rating").val()/100) * (1 - $("#s2_sysloss_age").val()/100) * (1 - $("#s2_sysloss_availability").val()/100))* 100)  + "%");
	$("#s2_result_loss").prop("title", Math.round((1 - (1 - $("#s2_sysloss_solling").val()/100) * (1 - $("#s2_sysloss_shading").val()/100) * (1 - $("#s2_sysloss_snow").val()/100) * (1 - $("#s2_sysloss_mismatch").val()/100) * (1 - $("#s2_sysloss_wiring").val()/100) * (1 - $("#s2_sysloss_connections").val()/100) * (1 - $("#s2_sysloss_degradation").val()/100) * (1 - $("#s2_sysloss_rating").val()/100) * (1 - $("#s2_sysloss_age").val()/100) * (1 - $("#s2_sysloss_availability").val()/100))* 100));
});

$(".s2_btn_m2_savedt").on("click", function(){
	$("#s2_txt_system_lose").val($("#s2_result_loss").prop("title"));
	$("#s2_modal_syslose").hide();
});