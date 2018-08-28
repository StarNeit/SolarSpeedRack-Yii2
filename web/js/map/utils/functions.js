/**
 * Created by Awsaf on 12/17/2016.
 */

function metersToInches (meters) {
    return meters * 39.37;
};
function inchesToMeters (inches) {
    var cm, meters;
    // convert inches to cm
    cm = inches * 2.54;
    // convert cm to meters
    meters = cm / 100;

    return meters;
};
function getPanel(id) {
    if(id === undefined) {
        id = aac.activeId;
    }
    return aac.allPanels[id];
}
function getOverlay() {
    return aac.allOverlays[aac.activeId];
}

function p(v) {
    return parseInt(v);
}
function pf(v) {
    return parseFloat(v);
}
function get2(v) {
    return Math.floor(v * 100) / 100;
}
function get2c(v) {
    return Math.ceil(v * 100) / 100;
}
function round5(x) {
    return Math.ceil(x/5)*5;
}
function bisect(main, ref) {
    var idx;
    if (main.length === 0) {
        return 0;
    }
    for (idx=0; idx < main.length; idx++) {
        if (ref < main[idx]) {
            return idx;
        }
    }
    return idx;
};