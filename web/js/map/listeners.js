/**
 * Created by Awsaf on 11/26/2016.
 */

$("#add_panel").click( function (e) {
    e.preventDefault();
    aac.drawingManager.setMap(aac.gMap);
    aac.drawingManager.setOptions({
        drawingMode: 'polygon'
    });
});
$("#remove_all").click( function () {
    getOverlay().removeAllOverlays();
});

$("#protate").roundSlider({
    min: 0,
    max: 360,
    radius: 58
}).on('drag', function(slideEvt) {
    if(!aac.allOverlays.length) {
        return false;
    }
    var angle = slideEvt.value;
    var currentAngle = getPanel().getRotationAngle();

    // if no angle value don't do anything
    if (angle) {
        // if input matches curent angle or angle is greater than 360, don't do anything
        if (angle == currentAngle || angle > 360) {
            return false;
        };
    } else {
        return false;
    }

    // get center
    var center = getOverlay().overlay.getBounds().getCenter();
    getPanel().rotateAllPanels(eval(angle), center);
    getPanel().setRotationAngle(eval(angle));
});
$("#p-rotate").bind('input keyup change', function () {
    if(!aac.allOverlays.length) {
        return false;
    }
    var angle = $(this).val();
    var currentAngle = getPanel().getRotationAngle();

    // if no angle value don't do anything
    if (angle) {
        // if input matches curent angle or angle is greater than 360, don't do anything
        if (angle == currentAngle || angle > 360) {
            return false;
        };
    } else {
        return false;
    }

    // get center
    var center = getOverlay().overlay.getBounds().getCenter();
    getPanel().rotateAllPanels(eval(angle), center);
    getPanel().setRotationAngle(eval(angle));
});
$("#rotate_all").click( function  (e) {
    e.preventDefault();
    getPanel().rotateAllPanels();
});
$("#save").click( function () {
    config.save();
});
function listenEverything() {
    // set selected shape on getOverlay completion
    google.maps.event.addListener(aac.drawingManager, 'overlaycomplete', function(e) {
        var msg, olay;

        olay = e.overlay;
        olay.type = e.type;
        // if an getOverlay exists, ask user if they want to remove it
        // if (getOverlay().array.length) {
        //
        //     msg = 'We currently only support single Layout. Would you like to create a new array? Warning: This will remove your existing work.';
        //
        //     if (confirm(msg)) {
        //         // user clicked "ok"
        //         // remove existing getOverlay
        //         getOverlay().removeAllOverlays();
        //
        //         // draw new getOverlay
        //         getOverlay().drawOverlay(olay);
        //
        //         getOverlay().isSavedArr = false;
        //         getPanel().drawPanelsHandler();
        //     } else {
        //         // if user clicked "cancel"
        //         olay.setMap(null);
        //     }
        // } else {
            if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                aac.activeId++;

                aac.allPanels[aac.activeId] = new panelModel();
                aac.allOverlays[aac.activeId] = new overlayModel(aac.activeId);

                // Switch back to non-drawing mode after drawing a shape.
                aac.drawingManager.setDrawingMode(null);
                // draw getOverlay
                getOverlay().drawOverlay(olay);
                getOverlay().setActive();
                getOverlay().isSavedArr = false;
                getPanel().drawPanelsHandler();

                aac.gMap.setOptions({
                    draggable: true,
                    scrollwheel: true
                });
            }
        // }
        aac.drawingManager.setMap(null);
    });

    // $('.custom_module').on('change', function() {
    //     var valuesDidNotChanged;
    //
    //     height = $('#id_width').val();
    //     width = $('#id_length').val();
    //
    //     var newMetricWidth = mapHandler.maps.inchesToMeters(Number(width));
    //     var newMetricHeight = mapHandler.maps.inchesToMeters(Number(height));
    //
    //     if (metricWidth == newMetricWidth && metricHeight == newMetricHeight) {
    //         valuesDidNotChanged = true;
    //     }
    //
    //     metricWidth = newMetricWidth;
    //     metricHeight = newMetricHeight;
    //     if (dimensionsSet && !valuesDidNotChanged) {
    //         mapHandler.maps.panels.changePanelDims(metricWidth, metricHeight);
    //     } else {
    //         // Set data without refreshing panels
    //         mapHandler.maps.panels.setPanelDims({
    //             height: metricHeight,
    //             width: metricWidth
    //         });
    //
    //         dimensionsSet = true;
    //     }
    // });
}