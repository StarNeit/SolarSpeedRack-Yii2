var autocomplete;
var autocomplete2;

var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',//city
    administrative_area_level_1: 'short_name', //state
    country: 'short_name',
    postal_code: 'short_name'
  };

function fillInAddress(){
	var place = autocomplete.getPlace();
	console.log(place.address_components);
	$("#s4_address1").val('');
	$("#s4_address2").val('');
	$("#s4_city").val('');
	$("#s4_zipcode").val('');
	
	var address = "";
	for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        if (addressType == "street_number"){
        	address = val;
        }else if (addressType == "route"){
        	address += " " + val;
			$("#s4_address1").val(address);
        }else if (addressType == "locality"){
			$("#s4_city").val(val);
        }else if (addressType == "administrative_area_level_1"){
        	$("#s4_state").val(val);
        }else if (addressType == "country"){
        	$("#s4_country").val(val);
        }else if (addressType == "postal_code"){
        	$("#s4_zipcode").val(val);
        }
      }
    }

    var center = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng()
    }
    aac.gMap.setCenter(center);
    aac.pano.setPosition(center);
}

function initialize(){
    //Auto-Complete
	var input = document.getElementById('s1_home_address');
	autocomplete = new google.maps.places.Autocomplete(input);
	autocomplete.addListener('place_changed', fillInAddress);

	var input_register_address = document.getElementById('s4_address1');
	autocomplete2 = new google.maps.places.Autocomplete(input_register_address);
	autocomplete2.addListener('place_changed', fillInAddress);
}
google.maps.event.addDomListener(window, 'load', initialize);