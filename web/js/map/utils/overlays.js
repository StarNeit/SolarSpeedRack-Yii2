/**
 * Created by Awsaf on 12/17/2016.
 */
(function(window) {
    var overlayModel = (function() {
        function overlayModel(id) {
            this.id = id;
            this.shapeBounds = undefined;
            this.selectedShape = null;
            this.adjustedOverlay = undefined;
            this.overlay = [];
            this.shapesArr = [];
            this.orientationArr = [];
            this.isSavedArr = false;
            this.isDragEvent = false;
            this.inner = undefined;
            this.nudgeControls = [];
            this.savedOverlay = undefined;
        }

        var NE, SW;
        overlayModel.prototype = {
            forSave: function () {
                var savedPaths, paths, obj;
                savedPaths = [];
                paths = this.overlay.getPath().getArray();
                paths.forEach( function (path, index) {
                    obj = {
                        lat: path.lat(),
                        lng: path.lng()
                    }
                    savedPaths.push(obj);
                });
                return savedPaths;
            },
            /**
             * Draws an Overlay from the paths.
             *
             * @param {array} paths - polygon paths
             * @param {string} type - rectangle or polygon
             */
            drawOverlayFromPaths: function (paths, type) {
                var bounds, overlay, options;

                options = {
                    bounds: bounds,
                    map: window.map,
                    editable: false,
                    draggable: false,
                    strokeColor: 'white',
                    fillColor: 'black',
                    fillOpacity: 0.3
                };

                if (type === 'rectangle') {
                    bounds = new google.maps.LatLngBounds(paths[1], paths[0]);
                    options.type = 'rectangle';
                    options.bounds = bounds;
                    overlay = new google.maps.Rectangle(options);
                } else if (type === 'polygon') {
                    options.type = 'polygon';
                    options.paths = paths;
                    overlay = new google.maps.Polygon(options);
                }
                return overlay;
            },
            /**
             *
             * Draws an overlay object on the map
             *
             * @param {object} overlay
             */
            drawOverlay: function (overlay) {
                var heading;

                //this.setSelection(overlay);

                // overlay.setEditable(false);

                this.overlay = overlay;

                // add event listeners
                this.addOverlayListeners(overlay);

                this.refreshOverlay(overlay);

                if (overlay.type === 'rectangle') {
                    // draw edges
                    this.drawEdgesOverlayRectangle(overlay);

                    // rotation angle of rectangular overlay always ===overlay.0
                    getPanel().setRotationAngle(0);
                    // force update of input value
                    if (document.getElementById('panels-rotation')) {
                        document.getElementById('panels-rotation').value =
                            getPanel().getRotationAngle().toFixed();
                    }
                } else if (overlay.type === 'polygon') {
                    // draw edges
                    this.drawEdgesOverlayPolygon(overlay);
                }
            },
            /*
             * Flattens Polygon Overlay for saving.
             *
             */
            flattenPolygonOverlay: function () {
                var savedPaths, paths, obj, path;
                savedPaths = [];
                paths = this.obj.getPath().getArray();
                paths.forEach(function (path, index) {
                    obj = {
                        lat: path.lat(),
                        lng: path.lng()
                    };
                    savedPaths.push(obj);
                });
                return savedPaths;
            },
            /*
             * Flattens Rectangle Overlay for saving.
             *
             */
            flattenRectangleOverlay: function (overlay) {
                var savedPaths, paths, obj, path;
                savedPaths = [];
                NE = {
                    lat: overlay.getBounds().getNorthEast().lat(),
                    lng: overlay.getBounds().getNorthEast().lng()
                };
                SW = {
                    lat: overlay.getBounds().getSouthWest().lat(),
                    lng: overlay.getBounds().getSouthWest().lng()
                };
                // order is important here
                savedPaths.push(NE);
                savedPaths.push(SW);

                return savedPaths;
            },

            /**
             * Draws the inner Polygon shape which represents the edge
             * of the parent overlay area.
             *
             *
             * @param {object} overlay
             * @param {number} [padding=1] - global space between panels
             */
            drawEdgesOverlayPolygon: function (overlay, padding) {
                var inner, vertices, i, a, innerPaths, heading,
                    bisect, prevHeading, finalIndex, newVertex;

                padding = padding || -1;
                
                vertices = overlay.getPath();

                innerPaths = [];

                finalIndex = vertices.getLength();

                // set to null so that can be check if hols relevent value (i.e 0 is valid)
                prevHeading = null;

                for (i = 0; i <= finalIndex; i++) {
                    // set another counter, which can be changed
                    // don't change i, as this is our absolute counter -> don't want infinite loops
                    a = i;

                    // if index is greater than final index,
                    // set a counter to 0 -> basically takes us back to the begining
                    // for one more pass on index 0, but prevHeading exists
                    if (i === finalIndex) {
                        a = 0;
                    }

                    if (i === finalIndex - 1) {
                        // if this is the last element in the array
                        heading = google.maps.geometry.spherical.computeHeading(
                            vertices.getAt(a), vertices.getAt(0));
                    } else {
                        // for every element exceot the last, compare path to
                        // the next element in the array
                        heading = google.maps.geometry.spherical.computeHeading(
                            vertices.getAt(a), vertices.getAt(a + 1));
                    }

                    if (heading < 0) {
                        heading = 360 - Math.abs(heading);
                    }
                    // we need to have the previous heading stored
                    // this step is skipped for the first vertex,
                    // but the comes back around as the last loop
                    if (prevHeading !== null) {
                        prevHeading = (prevHeading >= 180) ? prevHeading - 180 : prevHeading + 180;

                        // get average of both headings (i.e. the middle)
                        bisect = ((prevHeading + heading) / 2);

                        // if bisect is > than the heading, we need the inverse
                        if (bisect > heading) {
                            bisect = bisect - 180;
                        }

                        // get new vertex point
                        newVertex = google.maps.geometry.spherical.computeOffset(vertices.getAt(a), padding, bisect);

                        // if newVertex is outside of the overlay, flip it by 180 degrees
                        if (!google.maps.geometry.poly.containsLocation(newVertex, overlay)) {
                            newVertex = google.maps.geometry.spherical.computeOffset(vertices.getAt(a), padding, bisect);
                            bisect = (bisect >= 180) ? bisect - 180 : bisect + 180;
                        }
                        // push to innerPaths array
                        innerPaths.push(newVertex);
                    }
                    // store this heading to be used in next iteration of loop
                    prevHeading = heading;
                }

                // render inner shape
                if (this.inner) {
                    // if inner already set, just update
                    this.inner.setOptions({
                        path: innerPaths,
                    });
                } else {
                    // render inner shape
                    inner = new google.maps.Polygon({
                        strokeColor: 'white',
                        strokeOpacity: 0.8,
                        strokeWeight: 1,
                        fillColor: 'black',
                        fillOpacity: 0.35,
                        map: aac.gMap,
                        editable: false,
                        path: innerPaths
                    });
                    // set property
                    this.inner = inner;
                }
            },
            /**
             * Draws the inner Rectangle overlay which represents the edge of the parent overlay area.
             *
             * @param {object} overlay - (overlay)
             * @param {number} [padding=1] - global space between panels
             */ 
            drawEdgesOverlayRectangle: function (overlay, padding) {
                var NE, SW, NW, childNE, childSW, inner,
                    distNS, distEW, diagonal;

                padding = padding || 1;

                // get diagonal distance from corner
                diagonal = Math.sqrt(2) * padding;

                // get NE of parent
                NE = overlay.bounds.getNorthEast();

                // get SW of parent
                SW = overlay.bounds.getSouthWest();

                // we need this to get distNS and distEW
                NW = new google.maps.LatLng(NE.lat(), SW.lng());

                // get child NE, SW
                childNE = google.maps.geometry.spherical.computeOffset(NE, diagonal, 225);
                childSW = google.maps.geometry.spherical.computeOffset(SW, diagonal, 45);

                // get horizontal and vertical distances of overlay
                distEW = google.maps.geometry.spherical.computeDistanceBetween(NE, NW);
                distNS = google.maps.geometry.spherical.computeDistanceBetween(NW, SW);

                // check that the horizontal and vertical distance of the overlay
                //  is greater than the padding on both sides
                if (distNS > padding * 2 && distEW > padding * 2) {
                    // render overlay
                    if (this.inner) {
                        // if inner already set, just update
                        this.inner.setOptions({
                            bounds: new google.maps.LatLngBounds(
                                childSW,
                                childNE
                            )
                        });
                    } else {
                        // initial overlay
                        inner = new google.maps.Rectangle({
                            strokeColor: 'white',
                            strokeOpacity: 0.8,
                            strokeWeight: 1,
                            fillColor: 'black',
                            fillOpacity: 0.35,
                            map: window.map,
                            bounds: new google.maps.LatLngBounds(
                                childSW,
                                childNE
                            )
                        });
                        // set property
                        this.inner = inner;
                    }
                } else {
                    if (window.alertify) {
                        window.alertify.alert(aac.maps.errors.boundsTooSmall);
                    }
                    aac.removeAllPanels();
                    // kill inner
                    if (this.inner) {
                        this.inner.setMap(null);
                    }
                    this.inner = undefined;
                }
            },
            /**
             *
             * Construct a rectangle around the overlay which extends 0.25* the diagonal across the overlay.
             *
             * @param {object} bounds - overlay bounds
             */
            adjustOverlayBounds: function (overlay) {
                var NE;
                var SW;
                var newNE;
                var newSW;
                var diagonal;
                var extensionFactor;
                var heading;
                var center;
                var bounds;
                var path;
                var angle;

                if ('rectangle' === overlay.type) {
                    bounds = overlay.getBounds();
                } else {
                    //rotate overlay to get correct field size, get bounds, then rotate back
                    heading =
                        google.maps.geometry.spherical
                            .computeHeading(overlay.getPath().getAt(0),
                                overlay.getPath().getAt(1));

                    center = overlay.getBounds().getCenter();
                    bounds = overlay.getBounds();
                    angle = (heading > 0) ? (90.0 - heading) : (-90.0 - heading);

                    var minLat, minLng, maxLat, maxLng, rotatedPoint;
                    path = overlay.getPath();
                    path.forEach(function (pathPoint) {
                        //convert latlng to point becasue of skewing
                        // rotatedPoint = this.pointTolatLng(
                        //     this.rotatePoint(this.latLngToPoint(pathPoint),
                        //         this.latLngToPoint(center),
                        //         angle));
                        //
                        // if (minLat === undefined) {
                        //     minLat = maxLat = rotatedPoint.lat();
                        //     minLng = maxLng = rotatedPoint.lng();
                        //     return;
                        // }
                        //
                        // var lat = rotatedPoint.lat();
                        // var lng = rotatedPoint.lng();

                        var lat = pathPoint.lat();
                        var lng = pathPoint.lng();

                        if (minLat === undefined) {
                            minLat = maxLat = lat;
                            minLng = maxLng = lng;
                            return;
                        }

                        if (lat < minLat) minLat = lat;
                        if (lat > maxLat) maxLat = lat;
                        if (lng < minLng) minLng = lng;
                        if (lng > maxLng) maxLng = lng;
                    }.bind(this));

                    bounds =
                        new google.maps.LatLngBounds(new google.maps.LatLng(minLat, minLng),
                            new google.maps.LatLng(maxLat, maxLng));
                }

                // get diagonal
                NE = bounds.getNorthEast();
                SW = bounds.getSouthWest();
                diagonal = google.maps.geometry.spherical.computeDistanceBetween(NE, SW);


                // the amount (as a decimal) to extend the diagonal.
                // Set extensionFactor bigger for RM product
                extensionFactor = (0.1 * diagonal < 1) ? (0.1 * diagonal) : 1.0;

                // extend corners by diagonal * extensionFactor
                newNE = google.maps.geometry.spherical.computeOffset(NE, extensionFactor, 45);
                newSW = google.maps.geometry.spherical.computeOffset(SW, extensionFactor, 225);

                this.adjustedOverlay = new google.maps.Rectangle({
                    bounds: new google.maps.LatLngBounds(newSW, newNE)
                });
                return this.adjustedOverlay;
            },
            setBoundsFromArray: function () {
                /*
                 Method to setup array bounds given the array, and the panel dimesnions.
                 console.log('set bounds from array, probably because you exceeded 25 panels');
                 */
                var firstPanel, lastPanel, arrNW, arrNE, arrSE, arrSW, bounds, shape;

                this.removeAllOverlays();

                // get hold of first and plast panel in array
                firstPanel = getPanel().array[0];
                lastPanel = getPanel().array[this.array.length - 1];

                // calculate NW, SE corners of array
                arrNW = firstPanel.getPath().getAt(1);
                arrSE = lastPanel.getPath().getAt(3);

                // calculate NE, SW corners of array
                arrNE = new google.maps.LatLng(arrNW.lat(), arrSE.lng());
                arrSW = new google.maps.LatLng(arrSE.lat(), arrNW.lng());

                // make shape (rectangle)
                bounds = new google.maps.LatLngBounds(arrSW, arrNE);

                // make a bounds shape (optional here to render it to map or not)
                shape = new google.maps.Rectangle();
                shape.setOptions({
                    map: window.map,
                    bounds: bounds,
                    strokeColor: 'white',
                    clickable: true,
                    draggable: true,
                    zIndex: 0,
                    editable: true,
                    type: 'rectangle'
                });

                this.shapeBounds = bounds;
                this.overlay = shape;
                this.setSelection(shape);
                this.addOverlayListeners(shape);
                this.drawEdgesOverlayRectangle(shape);
                // TODO: need to mark panels on all edges
                return shape;
            },

            /**
             * Refreshes the adjusted bounds of the overlay.
             *
             * @param {object} shape - overlay shape
             */
            refreshOverlay: function (overlay) {
                var adjustedBounds, adjustedOverlay, overlayBounds;

                adjustedOverlay = this.adjustOverlayBounds(overlay);

                // update stored adjustedOverlay
                this.adjustedOverlay = adjustedOverlay;
                // update stored shape
                this.overlay = overlay;

                // make nudge controls
                //this.createNudgeControls(adjustedOverlay);
            },
            setActive: function () {
                aac.activeId = this.id;
                aac.allOverlays.forEach(function (e) {
                    if(e !== null) {
                        e.overlay.setOptions({strokeWeight: 1, strokeColor:'#d7d7d7'});
                        e.overlay.setEditable(false);   
                    }
                });
                this.overlay.setOptions({strokeWeight: 2, strokeColor:'#00adef'});
                // $("#p-rotate").val(getPanel().rotationAngle);
                if(getPanel()) {
                    $("#protate").roundSlider({value: getPanel().rotationAngle});
                }
            },
            /**
             * Adds event listeners to overlay shape.
             *
             * @param {object} shape - overlay shape
             *
             */
            addOverlayListeners: function (shape) {
                var $this = this;
                google.maps.event.addListener(shape, 'dragend', function () {
                    // refresh overlay
                    $this.refreshOverlay(shape);
                });

                google.maps.event.addListener(shape, 'mouseover', function () {
                    if(aac.selectingArr) {
                        shape.setOptions({strokeWeight: 5, strokeColor:'white'});
                    }
                });
                google.maps.event.addListener(shape, 'mouseout', function () {
                    if(aac.activeId == $this.id) {
                        shape.setOptions({strokeWeight: 2, strokeColor:'#00adef'});
                    } else {
                        shape.setOptions({strokeWeight: 1, strokeColor:'#d7d7d7'});
                    }
                });

                google.maps.event.addListener(shape, 'click', function () {
                    $this.setActive();
                });

                if (shape.type === 'rectangle') {

                    google.maps.event.addListener(shape, 'drag', function () {
                        // when this even is fired, set isDragEvent to true
                        // so that 'bounds_changed' event doesn't get fired continuously
                        getOverlay().isDragEvent = true;
                        // redraw inner edge shape
                        getOverlay().drawEdgesOverlayRectangle(shape);
                    });

                    google.maps.event.addListener(shape, 'bounds_changed', function () {
                        // \\console.log('new shape: bounds changed event');
                        // this only applies to rectangle objects
                        if (!getOverlay().isDragEvent) {
                            // redraw inner edge shape
                            getOverlay().drawEdgesOverlayRectangle(shape);

                            // refresh overlay
                            getOverlay().refreshOverlay(shape);

                            // if array already exists
                            if (getPanel().array.length) {
                                // redraw all panels
                                getPanel().drawPanelsHandler();
                            }
                        }
                    });

                    // MOUSEUP
                    google.maps.event.addListener(shape, 'mouseup', function () {
                        // this is the final event
                        // use 500 msec delay to ensure this.isDragEvent definitely set to false!
                        setTimeout(function () {
                            getOverlay().isDragEvent = false;
                        }, 500);
                    });
                } else if (shape.type === 'polygon') {
                    google.maps.event.addListener(shape.getPath(), 'insert_at', function (idx) {
                        if (idx < 2) {
                            // this change affects the first path of array
                            // getOverlay().refreshPanelRotation(shape);
                        }

                        this.inner = undefined;
                        getOverlay().drawEdgesOverlayPolygon(shape);
                    });

                    google.maps.event.addListener(shape.getPath(), 'remove_at', function () {
                        //console.log('remove_at');
                        getOverlay().drawEdgesOverlayPolygon(shape);
                    });

                    google.maps.event.addListener(shape.getPath(), 'set_at', function (idx) {
                        // this is the equivalent of bounds changed
                        //console.log('set_at (bounds changed)');
                        if (idx < 2) {
                            // this change affects the first path of array
                            // getOverlay().refreshPanelRotation(shape);
                        }
                        getOverlay().drawEdgesOverlayPolygon(shape);
                        // refresh overlay
                        getOverlay().refreshOverlay(shape);
                        getPanel().drawPanelsHandler();
                    });
                }
            },
            /**
             * Sets an overlay to the maximum possible given the panel
             * dimensions and default limit.
             *
             * @param {LatLng object} NW - NorthWest corner of array
             * @param {decimal} panelDims - panels dimensions
             * @param {number} limit - array limit (both x and y axis)
             *
             */
            setMaxBounds: function (NW, panelDims, limit) {
                var NE, SW, maxWidth, maxHeight, shape;

                // clear all existing overlays
                this.removeAllOverlays();

                // TODO: account for global orientation
                // calculate the max width based on limit * panel width or height.
                // Also need to add limit * padding
                maxWidth = (limit * panelDims.width) + (limit * panelDims.padding);
                maxHeight = (limit * panelDims.height) + (limit * panelDims.padding);

                // We need to fudge the distance a little to ensure it does not exceed limit
                // google's distance calcs are not completely accurate
                NE = google.maps.geometry.spherical.computeOffset(NW, maxWidth - 0.0001, 90);
                SW = google.maps.geometry.spherical.computeOffset(NW, maxHeight - 0.0001, 180);

                shape = new google.maps.Rectangle({
                    map: window.map,
                    bounds: new google.maps.LatLngBounds(
                        SW,
                        NE
                    ),
                    strokeColor: 'white',
                    clickable: true,
                    draggable: true,
                    zIndex: 0,
                    editable: true,
                    // overlay property needed to be consistent with other shapes
                    type: 'rectangle'
                });

                this.shapeBounds = shape.getBounds();

                this.overlay = shape;
                this.setSelection(shape);
                this.addOverlayListeners(shape);
                this.drawEdgesOverlayRectangle(shape);

                return shape;
            },
            clearSelection: function () {
                if (this.selectedShape) {
                    this.selectedShape.setEditable(false);
                    this.selectedShape = null;
                }
            },
            setSelection: function (shape) {
                this.clearSelection();
                this.selectedShape = shape;
                shape.setEditable(true);
            },
            rotatePoint: function (point, origin, angle) {
                var rad = angle * (Math.PI / 180);
                var x = point.x - origin.x;
                var y = point.y - origin.y;

                return new google.maps.Point(
                    x * Math.cos(rad) - y * Math.sin(rad) + origin.x,
                    x * Math.sin(rad) + y * Math.cos(rad) + origin.y
                );
            },
            latLngToPoint: function (latLng) {
                var map = aac.gMap;
                var topRight = map.getProjection().fromLatLngToPoint(
                    map.getBounds().getNorthEast());
                var bottomLeft = map.getProjection().fromLatLngToPoint(
                    map.getBounds().getSouthWest());

                var scale = Math.pow(2, map.getZoom());
                var worldPoint = map.getProjection().fromLatLngToPoint(latLng);
                return new google.maps.Point(
                    (worldPoint.x - bottomLeft.x) * scale,
                    (worldPoint.y - topRight.y) * scale);
            },
            pointTolatLng: function (point) {
                var map = aac.gMap;
                var topRight = map.getProjection().fromLatLngToPoint(
                    map.getBounds().getNorthEast());
                var bottomLeft = map.getProjection().fromLatLngToPoint(
                    map.getBounds().getSouthWest());

                var scale = Math.pow(2, map.getZoom());

                return map.getProjection().fromPointToLatLng(
                    new google.maps.Point((point.x / scale) + bottomLeft.x,
                        (point.y / scale) + topRight.y));
            },
            /**
             * Removes all Overlays.
             */
            removeAllOverlays: function () {
                var resetParams;


                // clear all overlays
                this.overlay.setMap(null);

                this.overlay = undefined;
                this.adjustedOverlay = undefined;

                // clear inner
                if (this.inner) {
                    this.inner.setMap(null);
                    this.inner = undefined;
                }

                // clear all panels
                if (getPanel().array.length) {
                    resetParams = true;
                    getPanel().removeAllPanels(resetParams);
                }

                aac.allOverlays[this.id] = null;
                aac.allPanels[this.id] = null;

                // clear rafters
                // getRafters().removeRafters();
                // clear nudge controls
                // aac.maps.overlays.removeNudgeControls();
            },
            /**
             * Refreshes the angle of the panels using the first drawn path
             * @param shape
             */
            refreshPanelRotation: function (shape) {
                var overlayPath = shape.getPath();
                var heading = google.maps.geometry.spherical.computeHeading(
                    overlayPath.getAt(0),
                    overlayPath.getAt(1)
                );

                getPanel().setRotationAngle(heading - 90);
                if (document.getElementById('p-rotate')) {
                    document.getElementById('p-rotate').value =
                        getPanel().getRotationAngle().toFixed();
                }
            },
            setTransparencyMode: function () {
                var sw, $this = this;
                var t = aac.transparency;
                if(t) {
                    this.overlay.setOptions({fillOpacity: .1, strokeWeight:1});
                } else {
                    if(aac.activeId == $this.id) {
                        sw = 2;
                    } else {
                        sw = 1;
                    }
                    this.overlay.setOptions({fillOpacity: .7, strokeWeight:sw});
                }
                getPanel($this.id).array.forEach(function (p) {
                    if(p.enabled) {
                        if(t) {
                            p.setOptions({fillOpacity: .5, strokeWeight:.2});
                        } else {
                            p.setOptions({fillOpacity: 1, strokeWeight:.5});
                        }
                    }
                });
            }
        };
        return overlayModel;
    }());
    window.overlayModel = overlayModel;
}(window));