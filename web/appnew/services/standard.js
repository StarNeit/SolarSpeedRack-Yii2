/**
 * Created by Awsaf on 6/28/2016.
 */

(function(){
    "use strict";
    var app = angular.module('solarApp');

    app.service('StandardCalculator',['CalculatorService', 'ConfigService', function(CalculatorService, config){
        this.updateRafters = function (layout) {
            var cantilever = config.getCantilever();

            this.setRafters(layout, cantilever);
        };
        this.setRafters = function(layout, val) {
            layout.rafters = [];
            layout.allRafters = [];
            for( var rt = val; rt < 2000; rt += config.rafterDistance ) {
                layout.rafters.push(59 + get2(rt));
            }
            while(val+180 > 0) {
                val -= config.rafterDistance;
                layout.allRafters.push(60 + get2(val));
            }
            Array.prototype.push.apply(layout.allRafters, layout.rafters);
        };
        this.updateIndent = function (layout) {
            var i, j, height, width, tempRight, length;

            layout.colMaxLength = 0;
            layout.rightEnd = 0;
            layout.tempRightEnd = 0;
            layout.activePanels = 0;
            layout.rowIndentY[0] = 0;
            layout.actualRowIndentY[0] = 0;
            for(i in layout.models) {
                i = p(i);
                if(layout.orientations[i] === 1) {
                    height = config.moduleWidth;
                    width = config.moduleLength;
                } else {
                    height = config.moduleLength;
                    width = config.moduleWidth;
                }

                layout.rowIndentY[p(i)+1] = layout.rowIndentY[i] + height + config.imdY;
                layout.actualRowIndentY[p(i)+1] = layout.actualRowIndentY[i] + height + config.imdY;
                length = 0;
                tempRight = 0;
                for(j in layout.models[i]) {
                    tempRight += width + config.imdX;
                    j = p(j);
                    if(layout.models[i][j].active) {
                        length += width + config.imdX;
                        layout.activePanels++;
                    } else if(length > 0){
                        for(var ji = j+1; ji < layout.models[i].length; ji++) {
                            if(layout.models[i][ji].active) {
                                length += width + config.imdX;
                                break;
                            }
                        }
                    }
                }
                if(tempRight > layout.tempRightEnd) {
                    layout.tempRightEnd = tempRight;
                }
                layout.colLengths[i] = length;
                if(length > layout.colMaxLength) {
                    layout.colMaxLength = length;
                }
            }
            this.updateRafters(layout);

            for(i in layout.colLengths) {
                if(layout.alignCenter) {
                    layout.rowIndentX[i] = get2((layout.colMaxLength - layout.colLengths[i]) / 2) ;
                } else {
                    layout.rowIndentX[i] = 0;
                }
            }
            CalculatorService.calculate(layout);
        };
        this.update = function(layout) {
            var i, j, height, width, rstart, iniGap,
                tempRailsAccessory = [],
                start, curr, continuous, curRailLength, a, b;
            layout.cutRails = [];
            layout.railCount = 0;
            layout.lfootCount = 0;
            layout.sfootCount = 0;
            layout.spliceCount = 0;
            layout.endClampCount = 0;
            layout.midClampCount = 0;
            layout.railClipCount = 0;
            layout.groundLugs = 0;
            layout.endCaps = 0;

            layout.rails = [];
            for(i in layout.models) {
                iniGap = 0;
                rstart = 0;
                i = p(i);
                if(layout.orientations[i] === 1) {
                    height = config.moduleWidth;
                    width = config.moduleLength;
                } else {
                    height = config.moduleLength;
                    width = config.moduleWidth;
                }
                start = -1;
                tempRailsAccessory[i] = [];
                tempRailsAccessory[i].midClamps = [];
                tempRailsAccessory[i].endClamps = [];
                tempRailsAccessory[i].clips = [];
                curRailLength = 0;
                continuous = false;
                for(j in layout.models[i]) {
                    a = i * 2 + 1;
                    b = i * 2 + 2;
                    if(layout.rails[a] == undefined) {
                        layout.rails[a] = [];
                        layout.rails[b] = [];
                    }

                    j = p(j);
                    if(layout.models[i][j].active) {

                        if(layout.alignCenter) {
                            curr = layout.rowIndentX[i] + (j - iniGap) * (width + config.imdX);
                        } else {
                            curr = j * (width  + config.imdX);
                        }

                        if(continuous === false){
                            tempRailsAccessory[i].endClamps.push(curr);
                            start = j;
                            curRailLength = width;
                            continuous = true;
                        } else if(continuous){
                            curRailLength += width + config.imdX;
                            tempRailsAccessory[i].endClamps.pop();
                            tempRailsAccessory[i].midClamps.push(curr);
                        }

                        tempRailsAccessory[i].endClamps.push(curr + width  + config.imdX);


                        if(j == ( layout.models[i].length - 1)) {
                            if(layout.alignCenter) {
                                start = layout.rowIndentX[i] + (start - iniGap) * (width + config.imdX);
                            } else {
                                start = start * (width  + config.imdX);
                            }
                            layout.rails[a].push(this.createRail(layout, a, rstart, start, curRailLength, tempRailsAccessory[i]));
                            layout.rails[b].push(this.createRail(layout, b, rstart, start, curRailLength, tempRailsAccessory[i]));

                            tempRailsAccessory[i] = [];
                            tempRailsAccessory[i].midClamps = [];
                            tempRailsAccessory[i].endClamps = [];
                            tempRailsAccessory[i].clips = [];
                            rstart++;
                        }
                    } else {
                        if(curRailLength > 0) {
                            if(layout.alignCenter) {
                                start = layout.rowIndentX[i] + (start - iniGap) * (width + config.imdX);
                            } else {
                                start = start * (width + config.imdX);
                            }
                            layout.rails[a].push(this.createRail(layout, a, rstart, start, curRailLength, tempRailsAccessory[i]));
                            layout.rails[b].push(this.createRail(layout, b, rstart, start, curRailLength, tempRailsAccessory[i]));
                            tempRailsAccessory[i] = [];
                            tempRailsAccessory[i].midClamps = [];
                            tempRailsAccessory[i].endClamps = [];
                            tempRailsAccessory[i].clips = [];

                            rstart++;
                            continuous = false;
                            curRailLength = 0;
                            start = j;
                        } else if(start === -1) {
                            if(layout.alignCenter) {
                                iniGap++;
                            } else {
                                start = j;
                            }
                        } else {
                            start = j;
                        }
                    }
                }
            }
        };


        this.createRail = function(layout, i, j, start, rlength, tempRailsAccessory) {

            var Rail = {
                id : 'r' + i + 'x' + j,
                i: i,
                j: j,
                left: 59+start,
                length : rlength + 2,
                lfoots : [],
                sfoots : [],
                splices : [],
                endClamps : tempRailsAccessory.endClamps,
                midClamps : tempRailsAccessory.midClamps,
                clips : tempRailsAccessory.clips,
                fullRailCount : 0,
                cutPiece1 : 0,
                cutPiece2 : 0,
                cutPiece3 : 0
            }, sf;

            var ini, current, max, ns;

            max = Rail.length + Rail.left;

            ini = Rail.left + config.getCantilever();
            current = d3.bisect(layout.rafters, ini);
            current = layout.rafters[current - 1];
            if(current < Rail.left) {
                current += config.rafterDistance;
            }
            if(rlength < config.railSize && current - config.rafterDistance > Rail.left ) {
                current -= config.rafterDistance;
            } else if(rlength > config.railSize && ini > current + config.rafterDistance) {
                current += config.rafterDistance;
            }
            Rail.fullRailCount = Math.floor(rlength / config.railSize);

            if(rlength >= config.railSize) {
                for(i = 1; i <= Rail.fullRailCount; i++) {
                    ns = i * config.railSize + Rail.left;
                    if(ns + 20 < max) {
                        Rail.splices.push(ns);
                        if(ns + config.railSize + 20 > max) {
                            Rail.cutPiece2 = get2(max - ns);
                        }
                    } else {
                        Rail.fullRailCount--;
                        Rail.splices.push(ns - config.rafterDistance);
                        Rail.cutPiece2 = get2((max - ns) + config.rafterDistance);
                        Rail.cutPiece3 = config.railSize - config.rafterDistance;
                    }
                }
            } else if(rlength < config.railSize) {
                Rail.cutPiece1 = rlength;
            }
            while (current < max) {
                Rail.lfoots.push(current);

                if(config.useSpeedFoot === true && Rail.lfoots.length > 1) {
                    if(config.speedFootType > 0) {
                        var csp = Rail.lfoots[Rail.lfoots.length - 2] + config.rafterDistance * 2;
                        while(csp < current) {
                            Rail.sfoots.push(get2(csp));
                            csp += config.rafterDistance * 2;
                        }
                    } else {
                        var csp = Rail.lfoots[Rail.lfoots.length - 2] + config.rafterDistance;
                        while(csp < current) {
                            Rail.sfoots.push(get2(csp));
                            csp += config.rafterDistance;
                        }
                    }
                }

                current = current + config.span;
                if((max - current) > 0 && (max - current) < 4) {
                    current = current - config.rafterDistance;
                }
            }

            if(
                max - Rail.lfoots[Rail.lfoots.length - 1] > config.getCantilever() ||
                Rail.lfoots.length === 1 ||
                Rail.lfoots[Rail.lfoots.length - 1] < Rail.splices[Rail.splices.length - 1]
            ) {
                current = d3.bisect(layout.rafters, max);

                if(
                    max - layout.rafters[current - 2] > Rail.lfoots[Rail.lfoots.length - 1] &&
                    max - layout.rafters[current - 2] < config.getCantilever()
                ) {
                    Rail.lfoots.push(layout.rafters[current - 2]);
                } else {
                    Rail.lfoots.push(layout.rafters[current - 1]);
                }
                current = layout.rafters[current - 1];
                if(config.useSpeedFoot === true) {
                    if (config.speedFootType > 0) {
                        var csp = Rail.lfoots[Rail.lfoots.length - 2] + config.rafterDistance * 2;
                        while (csp < current) {
                            Rail.sfoots.push(get2(csp));
                            csp += config.rafterDistance * 2;
                        }
                    } else {
                        var csp = Rail.lfoots[Rail.lfoots.length - 2] + config.rafterDistance;
                        while (csp < current) {
                            Rail.sfoots.push(get2(csp));
                            csp += config.rafterDistance;
                        }
                    }
                }
            }
            layout.railCount += Rail.fullRailCount;
            layout.lfootCount += Rail.lfoots.length;
            layout.sfootCount += Rail.sfoots.length;
            layout.spliceCount += Rail.splices.length;
            layout.endClampCount += Rail.endClamps.length;
            layout.midClampCount += Rail.midClamps.length;
            layout.railClipCount += Rail.clips.length;
            layout.endCaps += 2;
            if(Rail.i % 2 == 1) {
                layout.groundLugs++;
            }
            if(Rail.cutPiece1 > 0) {
                layout.cutRails.push(Rail.cutPiece1);
            }
            if(Rail.cutPiece2 > 0) {
                layout.cutRails.push(Rail.cutPiece2);
            }
            if(Rail.cutPiece3 > 0) {
                layout.cutRails.push(Rail.cutPiece3);
            }
            if(max > layout.rightEnd) {
                layout.rightEnd = get2(max);
            }
            return Rail;
        };
    }]);
})();