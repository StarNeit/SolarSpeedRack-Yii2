/**
 * Created by Awsaf on 6/28/2016.
 */

(function(){
    "use strict";
    var app = angular.module('solarApp');

    app.service('SpeedRackCalculator',['CalculatorService', 'ConfigService', function(CalculatorService, config) {
        this.updateRafters = function (layout) {
            var loop = 0,
                rlength = layout.tempRightEnd,
                cantilever = config.getCantilever(),
                total = cantilever,
                a, rlSize = config.railSize, min, max, start, i;
            while ( 0 < (cantilever - loop) ) {
                loop++;
                start = total;
                i = 1;
                while(total < rlength) {
                    a = (config.spliceSize / 2) + (config.lfootLength / 2) + config.minimumSpace;
                    min = ((i * rlSize) - a);
                    max = ((i * rlSize) + a);
                    if(
                        (min < total) &&
                        (total < max)
                    ) {
                        total = cantilever - loop;
                        break;
                    }
                    total += config.span;
                    i++;
                }
                if(total > rlength) {
                    this.setRafters(layout, start);
                    break;
                }
            }
        };
        this.setRafters = function(layout, val) {
            layout.rafters = [];
            layout.allRafters = [];
            for( var rt = val; rt < 2000; rt += config.rafterDistance ) {
                layout.rafters.push(60 + get2(rt));
            }
            while(val+60 > 0) {
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

                layout.rowIndentY[p(i)+1] = layout.rowIndentY[i] + height + 6;
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



        var railModel = function(t) {
            return {
                start: t.start,
                end: t.end,
                setStart: function (v) {
                    this.start = v.start;
                },
                setEnd: function (v) {
                    this.end = v.end;
                }
            };
        };


        this.rails = [];
        this.manageRail = function (r) {
            if(r.judged) {
                return;
            }
            r.judged = true;
            var rail, found = false, lastFound = false;
            for(var i in this.rails) {
                if(found) {
                    rail = this.rails[lastFound];
                    if(this.rails[i].start >= rail.start && this.rails[i].start < rail.end + 2) {
                        if (this.rails[i].end > rail.end) {
                            rail.end = this.rails[i].end;
                        }
                        this.rails.splice(i, 1);
                    }
                } else {
                    rail = this.rails[i];
                }
                if(r.start >= rail.start) {
                    if(r.start <= rail.end + 2) {
                        if(r.end > rail.end) {
                            rail.end = r.end;
                        }
                        found = true;
                        lastFound = i;
                    }
                } else {
                    if(r.end + 2 >= rail.start) {
                        rail.start = r.start;
                        if(r.end > rail.end) {
                            rail.end = r.end;
                        }
                        found = true;
                        lastFound = i;
                    }
                }
            }
            if(!found) {
                this.rails.push(new railModel(r));
            }
        };

        this.update = function(layout) {
            var i, j, height, width, rstart, iniGap,
                tempRails = [],
                start, continuous, curRailLength, newRailStart, newRailEnd;
            layout.cutRails = [];
            layout.railCount = 0;
            layout.lfootCount = 0;
            layout.sfootCount = 0;
            layout.spliceCount = 0;
            layout.endCaps = 0;
            layout.groundLugs = 0;

            layout.rails = [];
            layout.rails[0] = [];
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
                layout.rails[i+1] = [];
                tempRails[i+1] = [];
                tempRails[i+1]['a'] = [];
                tempRails[i+1]['b'] = [];
                curRailLength = 0;
                continuous = false;
                for(j in layout.models[i]) {
                    j = p(j);
                    if(layout.models[i][j].active) {
                        if(continuous === false){
                            start = j;
                            curRailLength = width;
                            continuous = true;
                        } else if(continuous){
                            curRailLength += width + config.imdX;
                        }
                        if(j == ( layout.models[i].length - 1)) {
                            if(layout.alignCenter) {
                                start = (start - iniGap) * (width + config.imdX);
                            } else {
                                start = start * (width  + config.imdX);
                            }
                            if(i === 0) {
                                this.createRail(layout, i, rstart, layout.rowIndentX[i] + start, curRailLength);
                                if(layout.models.length > 1) {
                                    tempRails[i+1]['a'].push({
                                        i : i+1,
                                        j : j,
                                        start: layout.rowIndentX[i] + start,
                                        end: layout.rowIndentX[i] + start + curRailLength,
                                        length: curRailLength,
                                        judged: false
                                    });
                                } else {
                                    this.createRail(layout, i+1, rstart, layout.rowIndentX[i] + start, curRailLength);
                                }
                            } else if(i == layout.models.length - 1) {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: layout.rowIndentX[i] + start,
                                    end: layout.rowIndentX[i] + start + curRailLength,
                                    length: curRailLength,
                                    judged: false
                                });
                                this.createRail(layout, i+1, rstart, layout.rowIndentX[i] + start, curRailLength);
                            } else {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: layout.rowIndentX[i] + start,
                                    end: layout.rowIndentX[i] + start + curRailLength,
                                    length: curRailLength,
                                    judged: false
                                });
                                tempRails[i+1]['a'].push({
                                    i : i,
                                    j : j,
                                    start: layout.rowIndentX[i] + start,
                                    end: layout.rowIndentX[i] + start + curRailLength,
                                    length: curRailLength,
                                    judged: false
                                });
                            }
                            rstart++;
                        }
                    } else {
                        if(curRailLength > 0) {
                            if(layout.alignCenter) {
                                start = (start - iniGap) * (width + config.imdX);
                            } else {
                                start = start * (width + config.imdX);
                            }
                            if(i === 0) {
                                this.createRail(layout, i, rstart, layout.rowIndentX[i] + start, curRailLength);
                                if(layout.models.length > 1) {
                                    tempRails[i+1]['a'].push({
                                        i : i+1,
                                        j : j,
                                        start: layout.rowIndentX[i] + start,
                                        end: layout.rowIndentX[i] + start + curRailLength,
                                        length: curRailLength,
                                        judged: false
                                    });
                                } else {
                                    this.createRail(layout, i+1, rstart, layout.rowIndentX[i] + start, curRailLength);
                                }
                            } else if(i == layout.models.length - 1) {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: layout.rowIndentX[i] + start,
                                    end: layout.rowIndentX[i] + start + curRailLength,
                                    length: curRailLength,
                                    judged: false
                                });
                                this.createRail(layout, i+1, rstart, layout.rowIndentX[i] + start, curRailLength);
                            } else {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: layout.rowIndentX[i] + start,
                                    end: layout.rowIndentX[i] + start + curRailLength,
                                    length: curRailLength,
                                    judged: false
                                });
                                tempRails[i+1]['a'].push({
                                    i : i,
                                    j : j,
                                    start: layout.rowIndentX[i] + start,
                                    end: layout.rowIndentX[i] + start + curRailLength,
                                    length: curRailLength,
                                    judged: false
                                });
                            }
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
                if(i !== 0) {
                    this.rails = [];
                    for(var ai in tempRails[i]['a']) {
                        this.manageRail(tempRails[i]['a'][ai]);

                        for(j in tempRails[i]['b']) {
                            this.manageRail(tempRails[i]['b'][j]);
                        }
                    }
                    for(var ri in this.rails) {
                        this.createRail(layout, i, ri, this.rails[ri].start, this.rails[ri].end - this.rails[ri].start);
                    }
                }
            }
        };

        this.createRail = function(layout, i, j, start, rlength) {
            var Rail = {
                id : 'r' + i + 'x' + j,
                i: i,
                j: j,
                left: 60+start,
                length : rlength,
                lfoots : [],
                sfoots : [],
                splices : [],
                fullRailCount : 0,
                cutPiece1 : 0,
                cutPiece2 : 0,
                cutPiece3 : 0
            }, sf;

            var ini, current, max, curSFoot;

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
            if(p(start) !== 0) {
                var fullRails = Math.floor(rlength / config.railSize),
                    a, rlSize = config.railSize, min, amax,
                    total = current, found = false;
                if(fullRails > 0) {
                    for(i = 1; i <= fullRails; i++) {
                        a = (config.spliceSize / 2) + (config.lfootLength / 2) + config.minimumSpace;
                        min = Rail.left + ((i * rlSize) - a);
                        amax = Rail.left + ((i * rlSize) + a);
                        while(total < amax) {
                            if(
                                (min < total) &&
                                (total < amax)
                            ) {
                                found = true;

                                break;
                            }
                            total += config.span;
                        }
                    }
                }
                if(found === false) {
                    if(fullRails > 0) {
                        Rail.fullRailCount = fullRails;
                        for(i = 1; i <= Rail.fullRailCount; i++) {
                            ns = i * config.railSize + Rail.left;
                            if(ns + 22 < max) {
                                Rail.splices.push(ns);
                                if(ns + config.railSize > max) {
                                    Rail.cutPiece2 = get2(max - ns);
                                }
                            } else if (ns + config.railSize > max) {
                                Rail.fullRailCount--;
                                Rail.splices.push(ns - config.rafterDistance);
                                Rail.cutPiece2 = get2((max - ns) + config.rafterDistance);
                                Rail.cutPiece3 = config.railSize - config.rafterDistance;
                            }
                        }
                    } else {
                        Rail.cutPiece1 = rlength;
                    }
                } else {
                    var ns = 60;
                    while (ns < Rail.left) {
                        ns += config.railSize;
                    }
                    if(ns > current) {
                        Rail.cutPiece1 = ns - Rail.left;
                        Rail.splices.push(ns);
                        ns += config.railSize;
                    } else {
                        ns = Rail.left + config.railSize;
                    }
                    while(ns < max) {
                        if(ns + 22 < max) {
                            Rail.splices.push(ns);
                            Rail.fullRailCount++;
                            if(ns + config.railSize > max) {
                                Rail.cutPiece2 = get2(max - ns);
                            }
                        } else if (ns + config.railSize > max) {
                            Rail.fullRailCount--;
                            Rail.splices.push(ns - config.rafterDistance);
                            Rail.cutPiece2 = get2((max - ns) + config.rafterDistance);
                            Rail.cutPiece3 = config.railSize - config.rafterDistance;
                        }
                        ns += config.railSize;
                    }
                }
            } else if(rlength >= config.railSize) {
                Rail.fullRailCount = Math.floor(rlength / config.railSize);
                for(i = 1; i <= Rail.fullRailCount; i++) {
                    ns = i * config.railSize + Rail.left;
                    if(ns + 22 < max) {
                        Rail.splices.push(ns);
                        if(ns + config.railSize > max) {
                            Rail.cutPiece2 = get2(max - ns);
                        }
                    } else if (ns + config.railSize > max) {
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

                if(config.useSpeedFoot === true && Rail.lfoots.length !== 1) {
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
            layout.endCaps += 2;
            layout.groundLugs++;
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
            layout.rails[Rail.i][Rail.j] = Rail;
            return true;
        };
    }]);
})();