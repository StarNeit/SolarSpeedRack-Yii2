// (function(window, google, aac) {

    aac.MAP_OPTIONS = {
        center: {
            lat: 37.791350,
            lng: -122.435883
        },
        tilt: 0,
        // minZoom: 5,
        // maxZoom: 26,
        zoom: 30,
        mapTypeId: 'satellite',
        // controlStyle: 'azteca',
        draggable: true,
        scrollwheel: false,
        // disableDefaultUI: false,
        zoomControlOptions: {
          position: 6, //google.maps.ControlPosition.LEFT_BOTTOM,
          style: 0, //google.maps.ZoomControlStyle.DEFAULT
        },
        // panControlOptions: {
        //   position: google.maps.ControlPosition.LEFT_BOTTOM
        // }
    };
    aac.DRAWING_OPTIONS = {
        drawingControl: false,
        rectangleOptions: {
            fillColor: '#969696',
            fillOpacity: .7,
            strokeWeight: 3,
            clickable: true,
            editable: true,
            zIndex: 1
        },
        polygonOptions: {
            fillColor: '#969696',
            fillOpacity: .7,
            strokeWeight: 3,
            clickable: true,
            editable: true,
            zIndex: 1
        }
    };

/**
 * The CenterControl adds a control to the map that recenters the map on
 * Chicago.
 * This constructor takes the control DIV as an argument.
 * @constructor
 */
function MapControls(controlDiv) {
    var BreakException = {};
    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.className = "place__main-icon-holder";
    $('<img src="/img/sidebar-icon-1.png" class="ctrl-img"><div class="place__main-hover-text">Move View</div>').appendTo(controlUI);
    controlDiv.appendChild(controlUI);

    // Setup the click event listeners: simply set the map to Chicago.
    controlUI.addEventListener('click', function() {

        aac.gMap.setOptions({
            draggable: true,
            scrollwheel: true
        });
    });

    var controlUI2 = document.createElement('div');
    controlUI2.className = "place__main-icon-holder";
    $('<img src="/img/sidebar-icon-2.png" class="ctrl-img"><div class="place__main-hover-text">Draw Roof Outline</div>').appendTo(controlUI2);
    controlDiv.appendChild(controlUI2);

    controlUI2.addEventListener('click', function() {
        if(aac.drawingManager.drawingMode == 'polygon') {
            aac.drawingManager.setDrawingMode(null);

            aac.gMap.setOptions({
                draggable: true,
                scrollwheel: true
            });
            return;
        }
        if($("#map_canvas .gm-style > div:first-child").hasClass('zoom-it')) {
            $("#map_canvas .gm-style > div:first-child").removeClass('zoom-it');
        }
        aac.drawingManager.setMap(aac.gMap);
        aac.drawingManager.setOptions({
            drawingMode: 'polygon'
        });

        aac.gMap.setOptions({
            draggable: false,
            scrollwheel: false
        });
    });

    var controlUI3 = document.createElement('div');
    controlUI3.className = "place__main-icon-holder";
    $('<img src="/img/sidebar-icon-3.png" class="ctrl-img"><div class="place__main-hover-text">Array Selection</div>').appendTo(controlUI3);
    controlDiv.appendChild(controlUI3);
    
    controlUI3.addEventListener('click', function() {
        aac.selectingArr = true;
    });

    var controlUI4 = document.createElement('div');
    controlUI4.className = "place__main-icon-holder";
    $('<img src="/img/sidebar-icon-4.png" class="ctrl-img"><div class="place__main-hover-text">Erase</div>').appendTo(controlUI4);
    controlDiv.appendChild(controlUI4);

    controlUI4.addEventListener('click', function() {
        if(!aac.allOverlays.length) {
            alert("No array is available!");
            return;
        }
        getOverlay().removeAllOverlays();
        try {
            aac.allOverlays.forEach(function (a) {
                if(a !== null) {
                    a.setActive();
                    getPanel().drawPanelsHandler();
                    throw BreakException;
                }
            });
        } catch (e) {
        }
    });

    var controlUI5 = document.createElement('div');
    controlUI5.className = "place__main-icon-holder";
    $('<img src="/img/sidebar-icon-5.png" class="ctrl-img"><div class="place__main-hover-text">Rotate All Panels</div>').appendTo(controlUI5);
    controlDiv.appendChild(controlUI5);

    controlUI5.addEventListener('click', function() {
        getPanel().rotate90();
    });
    var controlUI6 = document.createElement('div');
    controlUI6.className = "place__main-icon-holder";
    $('<img src="/img/sidebar-icon-6.png" class="ctrl-img"><div class="place__main-hover-text">Transparency Mode</div>').appendTo(controlUI6);
    controlDiv.appendChild(controlUI6);

    controlUI6.addEventListener('click', function() {
        if(getOverlay()) {
            aac.transparency = !aac.transparency;
            getOverlay().setTransparencyMode();
        } else {
            toastr.error("Please create an overlay first!");
        }
    });
    
    var controlUI7 = document.createElement('div');
    controlUI7.className = "place__main-icon-holder";
    $('<i class="fa fa-search" style="color:#00adeb;font-size: 30px;"></i><div class="place__main-hover-text">Extra Zoom</div>').appendTo(controlUI7);
    controlDiv.appendChild(controlUI7);

    controlUI7.addEventListener('click', function() {
        $("#map_canvas .gm-style > div:first-child").toggleClass("zoom-it");
    });

}
// }(window, google, window.aac || (window.aac = {})))