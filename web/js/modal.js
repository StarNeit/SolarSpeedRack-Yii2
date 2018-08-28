// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("s5_tab1_submit");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function() {
	$('.s5_approved_logo').show();
	$('#s5_tab1_submit').hide();
	$('#s5_tab1_proceed').show();
	$('#approved_box').show();
	$('#rejected_box').hide();
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

$('.s5_modal_button').on("click", function(){
	modal.style.display = "none";	
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

//---- Reject Dialog ----//
$('#s5_tab3_submit').on("click", function(){
	$('#approved_box').hide();
	$('#rejected_box').show();
	modal.style.display = "block";
});