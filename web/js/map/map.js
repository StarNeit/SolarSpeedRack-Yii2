

function initMap() {
    if(!document.getElementById('map')) return;
    var coordinates = {
        lat: 33.696031,
        lng: -117.900018
    };
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 38,
        center: coordinates,
        mapTypeId: 'satellite'
    });
    var marker = new google.maps.Marker({
        position: coordinates,
        map: map
    });
}
// initialize map on window load
google.maps.event.addDomListener(window, 'load', initMap);


$(".dropdown-toggle").dropdown();
if (screen && screen.width > 768) {
    document.write('<script type="text/javascript" src="/js/jquery.fullPage.min.js"><\/script>');
    document.write('<script src="/js/jquery.stellar.min.js"><\/script>');
}

var placeSearch, autocomplete;
function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("address"),
        {types: ["geocode"]});

    autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
    var place = autocomplete.getPlace();

    if(place.geometry.location) {
        var center = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        }
        aac.gMap.setCenter(center);
        aac.pano.setPosition(center);
        $("html, body").animate({ scrollTop: $(".map_holder").offset().top }, "slow");
    }
}
// CIRCLE RANGE SLIDER //
$(document).ready(function () {
    $("#shape").roundSlider({
        min: 0,
        max: 10
    }).on('change', function(slideEvt) {
        getNrelData(slideEvt.value);
    });
});
// RANGE SLIDER //
$("#range-slider").slider({
    // minimum value
    min: 0,
    // max value
    max: 500,
});
function getNrelData(kw) {
    $.get('http://developer.nrel.gov/api/pvwatts/v5.json?api_key=wGWtlgzWefM2g92UYH4Bvj71gX1Vy2pIFATVal6b&module_type=0&losses=14&system_capacity=' + kw +
        '&array_type=1&tilt=20&azimuth=180&lat=' + aac.gMap.center.lat() + '&lon=' + aac.gMap.center.lng(), function (data) {
        var output = data.outputs;
        $('#monthly-kw').text((output.ac_annual / 1000).toFixed(1));
        $('#sun-hour').text(output.solrad_annual.toFixed(1));
    });
}

$("#range-slider").on("slide", function(slideEvt) {
    $("#slider-input").val(slideEvt.value);
    $('#monthly-bill').text(slideEvt.value);
});
$("#slider-input").change(function () {
    var v = $(this).val();
    $("#range-slider").val(v);
});

function sliderShapeChanged(e) {
    var options = {
        circleShape: e.value
    };
    if (e.value == "pie") options["startAngle"] = 0;
    else if (e.value == "custom-quarter" || e.value == "custom-half") options["startAngle"] = 45;
    $("#todo__round").roundSlider(options);
}

// ROOF SELECTION //
$(document).on('click', '.place__roof-images', function (e) {
    e.preventDefault();

    $('.place__roof-images').removeClass('active');
    $(this).addClass('active');
});

// ROOF SELECTION //
$(document).on('click', '.place__roof-images', function (e) {
    e.preventDefault();

    $('.place__roof-images').removeClass('active');
    $(this).addClass('active');
});

// PANEL SELECTION //
$(document).on('click', '.control-panel__images', function (e) {
    e.preventDefault();

    $('.control-panel__images').removeClass('active');
    $(this).addClass('active');
});
