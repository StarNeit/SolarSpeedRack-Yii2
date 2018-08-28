var el, newPoint, newPlace, offset;
 
// Select all range inputs, watch for change
$("input[type='range']").change(function() {
    var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));
    
    $(this).css('background-image',
                '-webkit-gradient(linear, left top, right top, '
                + 'color-stop(' + val + ', #00aeef), '
                + 'color-stop(' + val + ', #C5C5C5)'
                + ')'
                );


   // Cache this for efficiency
   el = $(this);

   console.log('value: '+el.val());

   // Measure width of range input
   width = el.width();

   // Figure out placement percentage between left and right of input
   newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));
   offset = -5;

   // Prevent bubble from going beyond left or right (unsupported browsers)
   if (newPoint < 0) { newPlace = 0; }
   else if (newPoint > 1) { newPlace = width; }
   else { newPlace = width * newPoint + offset; offset -= newPoint; }

  el.next("output").css({
       left: newPlace,
       marginLeft: offset + "%"
     }).html("<input type='text' id='slider_input' value='" + el.val() + "' style='width:35px; text-align:center; background:transparent; border:0px solid #000;' placeholder='0'>");

  $("#slider_input").keydown(function(e){ 
      var code = e.which; // recommended to use e.which, it's normalized across browsers
      if(code==13)e.preventDefault();
      if(code==13){
          console.log($(this).val());
          $("input[type='range']").val($(this).val());
          $("input[type='range']").trigger("change");
      }
  }); 
  $("#slider_input").change(function(){
        $("input[type='range']").val($(this).val());
          $("input[type='range']").trigger("change");
  }); 
  $('#slider_input').tooltip({'trigger':'focus', 'title': 'Input number'});

   $('#txf_bill_amount').val(el.val());
   $('#avg_bill').text(el.val());

  /******* Calculation KWH *******/
  if ($('.s1_home_address').val().length > 0){
      $("#s2_monthly_bill").val(el.val());
      if ($("#s2_txt_system_size").val()=="0")
          $("#s2_txt_system_size").val('4');
      updateSolarAPI(2);
  }else{
    if (el.val() > 0)
      alert("Please input Home Address");
  } 
}).trigger('change');


$('input[type="range"]').change(function () {
    
});