/*global window, google, mapHandler*/

/* Custom Polygon */
window.PolygonPanel = PolygonPanel;
function PolygonPanel(r, c, enabled) {
    this.originPaths = [];
    this.enabled = enabled ? true : false;
    this.enabledByUser = undefined;
    this.orientation = 'landscape';
    this.onEdge = false;
    this.onCorner = false;
    this.isOutside = false;
    this.oldPosition = '';
    this.row = r;
    this.col = c;
    /**
     * Disables the panel instance.
     *
     */
    this.disablePanel = function () {
        var panel = this;
        panel.setOptions({
            enabled: false,
            fillColor: 'gray',
            strokeColor: 'gray',
            fillOpacity: 0.1
        });
        getPanel().getTotalPanels();

        return panel;
    };

    /**
     * Enables the panel instance.
     *
     */
    this.enablePanel = function () {
        var panel = this;
        var fillColor;
        fillColor = '#5999D9';

        // if (panel.onCorner) {
        //     fillColor = 'orangered';
        // } else {
        //     if (panel.onEdge) {
        //         fillColor = 'orange';
        //     } else {
        //         fillColor = '#5999D9';
        //     }
        // }

        panel.setOptions({
            enabled: true,
            fillColor: fillColor,
            strokeColor: '#1d1d1d',
            fillOpacity: aac.transparency ? .5 : 0.9
        });
        getPanel().getTotalPanels();

        return panel;
    };
    /**
     * Determines if panel instance is on and edge, or outside.
     *
     * @param {object} overlay - parent overlay shape.
     * @param {object} inner - inner overlay
     *
     */
    this.getPosition = function (overlay, inner) {
        var corners, inParent, inInner, isOutside = false,
            edgeCounter = 0, outsideCounter = 0, onEdge = false, onCorner = false;

        // if no overlay or no inner, then return onEdge as false (default)
        if (!overlay || !inner) {
            return onEdge;
        }

        // get panel corners
        corners = this.getPath().getArray();

        corners.forEach(function (corner) {
            if (overlay.type === 'rectangle') {
                // check if panel is in parent overlay
                inParent = overlay.bounds.contains(corner);
                //console.log('inParent', inParent);
                // check if panel is in inner
                inInner = inner.bounds.contains(corner);
                //console.log('inParent/ inInner', [inParent, inInner]);
            } else if (overlay.type === 'polygon') {
                inParent = google.maps.geometry.poly.containsLocation(corner, overlay);
                inInner = google.maps.geometry.poly.containsLocation(corner, inner);
            }
            // check if outside
            if (!inParent && !inInner) {
                outsideCounter++;
            }
            // check if on edge
            if (inParent && !inInner) {
                edgeCounter++;
            }
        });

        if (edgeCounter > 0 || outsideCounter > 0) {
            onEdge = true;
        }

        if (edgeCounter > 2) {
            onCorner = true;
        }

        if (outsideCounter > 0) {
            isOutside = true;
        }
        if (outsideCounter < 1 && onEdge) {
            isOutside = false;
        }

        // var roofEdgeState = getPanel().getRoofEdgeState();
        //
        // if (!roofEdgeState) {
        //     onCorner = false;
        //     onEdge = false;
        // }

        return {onEdge: onEdge, onCorner: onCorner, isOutside: isOutside};
    };

    /**
     * Sets the position of panel instance.
     *
     * @param {object} position - object containing onEdge boolean and isOutside boolean.
     *
     */
    this.setPosition = function (position) {
        var panel = this;
        var fillColor= '#5999D9';
        var onEdge;
        var onCorner;

        if (position.onCorner) {
            // fillColor = 'orangered';
            onEdge = true;
            onCorner = true;
        } else {
            // on edge
            if (position.onEdge) {
                // fillColor = 'orange';
                onEdge = true;
                onCorner = false;
            } else {
                // fillColor = '#5999D9';
                onEdge = false;
                onCorner = false;
            }
        }

        this.setOptions({fillColor: fillColor, onEdge: onEdge, onCorner: onCorner});

        // outside
        if (position.isOutside) {
            (this.enabledByUser === 'enabled') ? this.enablePanel() : this.disablePanel();
        } else {
            (this.enabledByUser !== 'disabled') ? this.enablePanel() : this.disablePanel();
        }

        /*
         // outside
         if (position.isOutside && panel.enabledByUser != 'enabled') {
         this.disablePanel();
         }
         if (position.isOutside && panel.enabledByUser === 'enabled') {
         this.enablePanel();
         }
         if (!position.isOutside && panel.enabledByUser != 'disabled') {
         this.enablePanel();
         }
         if (!position.isOutside && panel.enabledByUser == 'disabled') {
         this.disablePanel();
         }
         */

        // set panel isOutside
        this.isOutside = position.isOutside;
    };

    this.saveOldPosition = function (position) {
        this.oldPosition = position;
    };

    this.getOldPosition = function () {
        return this.oldPosition;
    };
    this.rotate = function (angle, origin) {
        var $this = this;
        var coords = this.getPath().getArray();
        var projection = aac.gMap.getProjection();
        origin = projection.fromLatLngToPoint(origin);

        coords.forEach(function (point, index) {

            var pp = projection.fromLatLngToPoint(point);
            coords[index] = projection.fromPointToLatLng($this.rotatePoint(angle, origin, pp));

//             var pixelCoord = $this.rotatePoint(angle, origin, pp);
// console.log(pixelCoord);
//             coords[index] = projection.fromPointToLatLng(pixelCoord);
        });

        window.b = coords;
        this.setPaths(coords);
    };
    this.rotatePoint = function (angle, origin, pp) {
        var rad = angle * (Math.PI / 180);

        var x = pp.x - origin.x;
        var y = pp.y - origin.y;

        return new google.maps.Point(
            x * Math.cos(rad) - y * Math.sin(rad) + origin.x,
            x * Math.sin(rad) + y * Math.cos(rad) + origin.y
        );
    };

}

// PolygonPanel inherits from google.maps.Polygon
PolygonPanel.prototype = new google.maps.Polygon();

// Custom RafterLine object
window.RafterLine = RafterLine;
function RafterLine() {
    this.index = undefined;
    this.zIndex = 1;
    this.originPaths = [];
}
RafterLine.prototype = new google.maps.Polygon();
