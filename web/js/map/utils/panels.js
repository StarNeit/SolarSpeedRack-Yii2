/**
 * Created by Awsaf on 12/17/2016.
 */
(function(window) {
    var panelModel = (function() {
        function panelModel() {
            this.array = [],
            this.arrayDims = {
                height: undefined,
                width: undefined,
            };
            this.pitch = 0;
            this.limit = 250;
            this.orientation = 'portrait';
            this.pitchDirection = 'perpendicular';
            this.draggable = false;
            this.roofEdgeState = true;
        }

        panelModel.prototype = {
            forSave: function () {
                var arr = [], savedPaths, paths, obj, isEmpty = [];
                this.array.forEach(function (e) {
                    // if(isEmpty[e.row] === undefined) {
                    //     isEmpty[e.row] = false;
                    // }
                    savedPaths = [];
                    paths = e.getPath().getArray();
                    paths.forEach( function (path, index) {
                        obj = {
                            lat: path.lat(),
                            lng: path.lng()
                        }
                        savedPaths.push(obj);
                    });

                    e.type = 'polygon';
                    if(!arr[e.row]) {
                        arr[e.row] = [];
                    }
                    arr[e.row][e.col] = {
                        i: e.row,
                        j: e.col,
                        active: e.enabled,
                        path: savedPaths
                    };
                    // isEmpty[e.row] = isEmpty[e.row] || e.enabled;
                });
                // if
                return arr;
            },
            setRotationAngle: function (angle) {
                config.panelRotation[aac.activeId] = parseInt(angle) || 0;
            },
            getRotationAngle: function () {
                if(!config.panelRotation[aac.activeId]) this.setRotationAngle();

                return config.panelRotation[aac.activeId];
            },
            getPitch: function () {
                return this.pitch;
            },
            getMaxWatt: function() {
                return parseFloat($('.circle strong').text()).toFixed(2) * 1000;
            },
            setPitch: function (pitch) {
                this.pitch = parseInt(pitch) || 0;
            },
            setDraggable: function (bool) {
                this.draggable = bool;
            },
            getDraggable: function () {
                return this.draggable;
            },
            setShiftKeyState: function (shiftState) {
                this.shiftKeyPressed = shiftState;
            },
            getShiftKeyState: function () {
                return this.shiftKeyPressed;
            },
            getTotalPanels: function () {
                var count = 0;
                this.array.forEach(function (panel) {
                    if (panel.enabled === true) {
                        count++;
                    }
                });
                aac.updatePanels(count);

                return count;
            },
            setPitchDirection: function (value) {
                var adjustedOverlay, pitchDirection, directions;

                directions = ['perpendicular', 'parallel'];
                this.pitchDirection = value || directions[0];
                //console.log('set pitch direction', this.pitchDirection);
                // reset pitch value
                // this.setPitch(0);
                this.refreshPanels();
                // if (document.getElementById('roof-pitch')) {
                //     document.getElementById('roof-pitch').value = 0;
                // }
                return directions.indexOf(value);
            },
            getPitchDirection: function () {
                return this.pitchDirection;
            },
            /**
             * Rotates all panels in array by the given angle.
             *
             * @param {number} angle - rotation angle
             */
            rotateAllPanels: function (angle, center) {
                var relativeAngle, currentRotation, newPaths, position,
                    updateControls = false, availablePanel = 0;
                if(aac.getAvailablePanel() > 0) {
                    availablePanel = aac.getAvailablePanel();
                }
                if (this.array.length) {

                    // get current rotation
                    currentRotation = this.getRotationAngle();

                    // calculate relative rotation
                    if (currentRotation === angle) {
                        // if currentRotation and angle argument the same,
                        // default to currentRotation
                        relativeAngle = currentRotation;
                    } else {
                        relativeAngle = angle - currentRotation;
                    }

                    this.array.forEach( function (panel) {
                        if(panel.enabled) {
                            availablePanel++;
                        }
                    });

                    this.array.forEach( function (panel) {
                        panel.rotate(relativeAngle, center);
                        // get the new location
                        newPaths = panel.getPath().getArray();
                        // set origin paths
                        panel.setOptions({
                            paths: newPaths,
                            // reset origin path
                            originPaths: newPaths,
                        });
                        // check if on edge, outside overlay
                        position = panel.getPosition(getOverlay().overlay, getOverlay().inner);

                        panel.setPosition(position);
                        if(panel.enabled) {
                            availablePanel--;   
                        }
                        if(availablePanel < 0) {
                            panel.disablePanel();
                        }
                    });
                } else {
                    alert('No panels yet!');
                }
            },
            rotate90: function() {
                if (this.array.length) {
                    config.totalPanel = config.totalPanel - this.array.length > 0 ? config.totalPanel - this.array.length : 0;
                    // this.removeAllPanels();
                    this.orientation = (this.orientation === 'landscape') ?
                        'portrait' : 'landscape';
                    this.drawPanelsHandler();
                } else {
                    alert('No panels yet!');
                }
            },
            /**
             * Handles the conditions under which mapHandler.maps.DrawPanels can be called.
             */
            drawPanelsHandler: function () {
                var adjustedOverlay, angle, pitch;

                // only proceed if shapeBounds is not empty
                if (getOverlay().adjustedOverlay) {
                    // get bounds of adjusted overlay
                    adjustedOverlay = getOverlay().adjustedOverlay;

                    // remove all existing panels - no support for multiple arrays yet
                    this.removeAllPanels();
                    // draw panels array
                    angle = this.getRotationAngle();
                    pitch = this.getPitch();

                    // draw panels
                    this.drawPanels(adjustedOverlay, pitch, angle);
                } else {
                    alert("not working");
                }
            },
            /**
             * Draws an array of panels on the overlay if given bounds.
             *
             * @param {object}  bounds  - overlay bounds.
             * @param {int}     pitch   - global roof pitch.
             * @param {int}     angle   - global rotation angle.
             */
            drawPanels: function (overlay, pitch, angle) {
                var arrDims, panelDims, paddingRow, padding, bounds,
                    NW, NE, SW, SE, i, a, panel, pitchedPanelHeight, pitchedPanelWidth,
                    orientation, headingEW, headingNS, index, pitchDirection, position, center,
                    distx, disty, firstPanelNE, firstPanelSW, firstPanelNW, firstPanelSE, corners;

                bounds = overlay.getBounds();

                headingEW = 90;
                headingNS = 180;

                pitch = pitch || 0;
                orientation = this.orientation || 'landscape';

                pitchDirection = this.getPitchDirection() || 'perpendicular';

                // panel size
                panelDims = {
                    height: inchesToMeters(config.moduleLength),
                    width: inchesToMeters(config.moduleWidth)
                };

                padding = inchesToMeters(config.imdX);

                paddingRow = inchesToMeters(config.imdY);

                pitchedPanelHeight = panelDims.height;
                pitchedPanelWidth = panelDims.width;

                if (pitch > 0) {
                    pitchedPanelHeight = parseFloat(panelDims.height * Math.cos(pitch / 180 * Math.PI).toFixed(2));
                    pitchedPanelWidth  = parseFloat(panelDims.width * Math.cos(pitch / 180 * Math.PI).toFixed(2));
                    paddingRow = parseFloat(paddingRow * Math.cos(pitch / 180 * Math.PI).toFixed(2));
                }
                // set distances of panel corners on x and y axis by panel dimensions
                // depends on global pitch direction and global orientation
                if (pitchDirection === 'perpendicular') {
                    distx = (orientation === 'landscape') ? panelDims.height : panelDims.width;
                    disty = (orientation === 'landscape') ? pitchedPanelWidth : pitchedPanelHeight;
                } else {
                    distx = (orientation === 'landscape') ? pitchedPanelHeight : pitchedPanelWidth;
                    disty = (orientation === 'landscape') ? panelDims.width : panelDims.height;
                }

                // get NW corner of overlay
                NW = new google.maps.LatLng(bounds.getNorthEast().lat(), bounds.getSouthWest().lng());

                // get corners of first panel in array
                firstPanelNW = NW;
                firstPanelNE = google.maps.geometry.spherical.computeOffset(NW, distx, headingEW);
                firstPanelSW = google.maps.geometry.spherical.computeOffset(NW, disty, headingNS);
                firstPanelSE = google.maps.geometry.spherical.computeOffset(firstPanelSW, distx, headingEW);

                // set & get the array dimensions
                arrDims = this.updateArrayDims(bounds, disty + paddingRow, distx, padding, false);

                var availablePanel = aac.getAvailablePanel();
                console.log(availablePanel);
                // loop through rows
                for (i = 1; i < arrDims.height; i++) {
                    // calculate corners of first rectangle in row
                    NE = google.maps.geometry.spherical.computeOffset(firstPanelNE, i * (disty + paddingRow), headingNS);
                    NW = google.maps.geometry.spherical.computeOffset(firstPanelNW, i * (disty + paddingRow), headingNS);
                    SE = google.maps.geometry.spherical.computeOffset(firstPanelSE, i * (disty + paddingRow), headingNS);
                    SW = google.maps.geometry.spherical.computeOffset(firstPanelSW, i * (disty + paddingRow), headingNS);

                    for (a = 1; a < arrDims.width; a++) {
                        if(a > 1) {
                            // get index of this panel
                            index = (arrDims.width * i) + a;
                            // make array of corners for paths
                            corners = [NE, NW, SW, SE];

                            // draw each panel
                            panel = this.drawPanel(i - 1, a - 2, corners, orientation);

                            // set panel position
                            position = panel.getPosition(getOverlay().overlay, getOverlay().inner);

                            panel.setPosition(position);
                            panel.setMap(aac.gMap);
                            // add panel listeners
                            this.addPanelListeners(panel, index);
                            // stack rectangle in array
                            this.array.push(panel);
                            if(panel.enabled) {
                                availablePanel--;   
                            }
                            if(availablePanel < 0) {
                                panel.disablePanel();
                            }
                        }
                        // calculate corners next panel in row
                        NE = google.maps.geometry.spherical.computeOffset(NE, distx + padding, headingEW);
                        NW = google.maps.geometry.spherical.computeOffset(NW, distx + padding, headingEW);
                        SE = google.maps.geometry.spherical.computeOffset(SE, distx + padding, headingEW);
                        SW = google.maps.geometry.spherical.computeOffset(SW, distx + padding, headingEW);
                    }
                }
                if (angle) {
                    var center = getOverlay().overlay.getBounds().getCenter();
                    this.rotateAllPanels(eval(angle), center);
                }
                this.getTotalPanels();
            },

            /**
             * Draws a single rectangle Polygon panel, given coords of corners.
             *
             * @param {object}  cornersArray               - array of length == 4, corner coords.
             * @param {boolean} [enabled=true]
             * @param {string}  [orientation='landscape']
             */
            drawPanel: function (i, j, cornersArray, orientation) {
                var panel, options;
                // new polygon object
                panel = new PolygonPanel(i, j);
                options = {
                    paths: cornersArray,
                    originPaths: cornersArray,
                    strokeColor: 'black',
                    strokeOpacity: 1,
                    strokeWeight: 1,
                    fillColor: '#5999D9',
                    fillOpacity: 0.9,
                    map: window.map,
                    zIndex: 100,
                    draggable: false,
                    editable: false,
                    orientation: orientation || 'landscape',
                    onEdge: false,
                    onCorner: false
                };
                panel.setOptions(options);

                return panel;
            },
            /**
             * Removes all panels.
             *
             * @param {boolean} resetParams - determines whether
             * rotation angle and pitch should be reset to default values
             */
            removeAllPanels: function (resetParams) {
                // remove rectangles
                this.array.forEach( function (panel) {
                    panel.setMap(null);
                });
                // empty panel array stack
                this.array = [];
                this.getTotalPanels();
            },
            setArrayDims: function (obj) {
                if (obj.height) { this.arrayDims.height = obj.height; }
                if (obj.width)  { this.arrayDims.width  = obj.width; }
            },
            /**
             * Updates the array dimesnions based on a bounds object and the panels dimensions.
             *
             * @param {object}  bounds
             * @param {decimal} panelHeight
             * @param {decimal} panelWidth
             * @param {decimal} padding
             * @param {boolean} exact
             */
            updateArrayDims: function (bounds, panelHeight, panelWidth, padding, exact) {

                var NW, SW, NE, height, width, obj;

                // get array corner coords
                NE = bounds.getNorthEast();
                SW = bounds.getSouthWest();
                // derive NW
                NW = new google.maps.LatLng(NE.lat(), SW.lng());

                // Get max number of panels for the given bounds
                height = google.maps.geometry.spherical.computeDistanceBetween(NW, SW) / (panelHeight+padding);
                // number of panels possible EW
                width  = google.maps.geometry.spherical.computeDistanceBetween(NW, NE) / (panelWidth+padding);

                height = exact ? Math.ceil(height) : Math.floor(height);
                width  = exact ? Math.ceil(width)  : Math.floor(width);

                obj = {
                    height: height,
                    width: width
                };

                this.setArrayDims(obj);
                // return arrDims object
                return obj;
            },
            /**
             * Adds event listeners to individual panels.
             *
             * @param {object} panel
             *
             */
            addPanelListeners: function (panel, index) {
                var context = this;
                // LEFT CLICK

                google.maps.event.addListener(panel, 'click', function () {
                    // change properties (color etc.) of selected rectangle
                    // to show as enabled or disabled
                    var shiftModifier = context.getShiftKeyState();

                    var onCorner = panel.onCorner;
                    var onEdge = panel.onEdge;
                    var enabled = panel.enabled;
                    var oldPosition = panel.getOldPosition();

                    if (!shiftModifier ||
                        shiftModifier && !onEdge && !onCorner) {
                        if (enabled) {
                            disablePanel();
                        } else {
                            enablePanel();
                        }
                    }

                    if (shiftModifier) {
                        //// Handle panels on edge
                        if (enabled && onEdge && !onCorner && oldPosition !== 'onCorner') {
                            saveOldPosition('onEdge');

                            setMiddlePosition();
                        }

                        if (enabled && !onEdge && !onCorner && oldPosition === 'onEdge') {
                            disablePanel();
                        }

                        if (!enabled && oldPosition === 'onEdge') {
                            enablePanel();

                            setOnEdgePosition();
                        }


                        //// Handle panels on corner
                        if (enabled && onEdge && onCorner) {
                            saveOldPosition('onCorner');

                            setOnEdgePosition();
                        }

                        if (enabled && onEdge && !onCorner && oldPosition === 'onCorner') {
                            setMiddlePosition();
                        }

                        if (enabled && !onEdge && !onCorner && oldPosition === 'onCorner') {
                            disablePanel();
                        }

                        if (!enabled && !onEdge && !onCorner && oldPosition === 'onCorner') {
                            setOnCornerPosition();
                            enablePanel();
                        }

                    }

                    function disablePanel() {
                        panel.enabledByUser = 'disabled';
                        panel.disablePanel();
                    }

                    function enablePanel() {
                        panel.enabledByUser = 'enabled';
                        panel.enablePanel();
                    }

                    function saveOldPosition(position) {
                        panel.saveOldPosition(position);
                    }

                    function setOnEdgePosition() {
                        panel.setPosition({
                            isOutside: false,
                            onEdge: true,
                            onCorner: false
                        });
                    }

                    function setOnCornerPosition() {
                        panel.setPosition({
                            isOutside: false,
                            onEdge: true,
                            onCorner: true
                        });
                    }

                    function setMiddlePosition() {
                        panel.setPosition({
                            isOutside: false,
                            onEdge: false,
                            onCorner: false
                        });
                    }
                    context.getTotalPanels();
                });

                // RIGHT CLICK
                // google.maps.event.addListener(panel, "rightclick", function () {
                //     angle = mapHandler.maps.panels.getRotationAngle();
                //     mapHandler.maps.panels.panelOrientation(panel, index, angle);
                // });
                //
                // // DRAG
                // google.maps.event.addListener(panel, "drag", function () {
                //     mapHandler.maps.panels.dragRow(panel, index);
                // });
                // google.maps.event.addListener(panel, "dragend", function () {
                //     // TODO: draw rects?
                // });
                // if (mapHandler.maps.panels.getDraggable() === true) {
                //     google.maps.event.addListener(panel, "drag", function () {
                //         mapHandler.maps.panels.dragRow(panel, index);
                //     });
                // }
            },
        }
        return panelModel;
    }());
    window.panelModel = panelModel;
}(window));