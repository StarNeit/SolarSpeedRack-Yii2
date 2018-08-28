/**
 * Created by Awsaf on 6/28/2016.
 */
(function(window) {
    var SharedCalculator = (function() {
        var SharedCalculator = {}

        SharedCalculator.updateRafters = function (layout) {
            var cantilever = config.getCantilever();

            this.setRafters(layout, cantilever);
        };
        SharedCalculator.setRafters = function(layout, val) {
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
        SharedCalculator.updateIndent = function (layout) {
            var i, j, height, width, tempRight, length;

            layout.colMaxLength = 0;
            layout.rightEnd = 0;
            layout.tempRightEnd = 0;
            layout.activePanels = 0;
            layout.rowIndentY[0] = 0;
            layout.actualRowIndentY[0] = 0;
            for(i in layout.models) {
                i = p(i);
                if(isNaN(i)) continue;

                // if(layout.orientations[i] === 1) {
                if(layout.orientation === 1) {
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
                    j = p(j);
                        if(isNaN(j)) continue;

                    tempRight += width + config.imdX;
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

        SharedCalculator.getParts = function (safeZones) {
            var exist = [], ret = {}, m;
            ret.endClamps = [];
            ret.midClamps = [];
            ret.clips = [];

            for(var i in safeZones) {
                if(exist[safeZones[i]]) {
                    if(exist[safeZones[i]] < 2) {
                        ret.endClamps.pop();
                        ret.midClamps.push(safeZones[i]);
                        ret.clips.push(safeZones[i]);
                        exist[safeZones[i]] = 2;
                    }
                } else {
                    m = bisect(safeZones, safeZones[i]) - 1;
                    if(m < 0) m = 0;

                    if(safeZones[i] - safeZones[m-1] < 10) {
                        if(exist[safeZones[m-1]] > 1) {
                            continue;
                        }
                        exist[safeZones[m-1]] = 2;
                        ret.endClamps.pop();
                        ret.midClamps.push(safeZones[i]);
                        ret.clips.push(safeZones[i]);
                    } else {
                        exist[safeZones[i]] = -1;
                        ret.endClamps.push(safeZones[i]);
                        ret.clips.push(safeZones[i]);
                    }
                }
            }
            return ret;
        };

        var emptyRail = function (i) {
            var arr = [];
            arr[i] = [];
            arr[i]['a'] = [];
            arr[i]['b'] = [];
            arr[i+1] = [];
            arr[i+1]['a'] = [];
            arr[i+1]['b'] = [];
            arr[i+1].midClamps = [];
            arr[i+1].endClamps = [];
            arr[i+1].clips = [];
            return arr;
        };

        var railModel = function(t) {
            return {
                start: t.start,
                end: t.end,
                safeZones: t.safeZones,
                setStart: function (v) {
                    this.start = v.start;
                },
                setEnd: function (v) {
                    this.end = v.end;
                },
                addSafeZones: function (s) {
                    Array.prototype.push.apply(this.safeZones, s);
                },
            };
        };


        SharedCalculator.rails = [];

        SharedCalculator.manageRail = function (r) {
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
                        rail.addSafeZones(this.rails[i].safeZones);
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
                        rail.addSafeZones(r.safeZones);
                        found = true;
                        lastFound = i;
                    }
                } else {
                    if(r.end + 2 >= rail.start) {
                        rail.start = r.start;
                        if(r.end > rail.end) {
                            rail.end = r.end;
                        }
                        rail.addSafeZones(r.safeZones);
                        found = true;
                        lastFound = i;
                    }
                }
            }
            if(!found && typeof r === 'object') {
                this.rails.push(new railModel(r));
            }
        };
        SharedCalculator.addRail = function (layout, nr, i, j, safeZones) {
            if(!safeZones) {
                safeZones = nr.safeZones;
                console.log(nr);
            }
            safeZones.sort(function (a, b) {  return a - b;  });

            var current = null, cnt = 0;
            for (var si = 0; si < safeZones.length; si++) {
                if (safeZones[si] != current) {
                    current = safeZones[si];
                    cnt = 1;
                } else {
                    cnt++;
                    if(cnt > 2) {
                        safeZones.splice(si, 1);
                    }
                }
            }
            return this.createRail(layout, i, j, nr.start, nr.end - nr.start, this.getParts(safeZones));
        };

        SharedCalculator.update = function(layout) {
            var i, j, height, width, rstart, iniGap,
                tempRails = [], tempRailsAccessory = [],
                start, curr, continuous, curRailLength;
            layout.cutRails = [];
            layout.railCount = 0;
            layout.lfootCount = 0;
            layout.sfootCount = 0;
            layout.spliceCount = 0;
            layout.endClampCount = 0;
            layout.midClampCount = 0;
            layout.railClipCount = 0;
            layout.endCaps = 0;

            layout.rails = [];
            layout.rails[0] = [];
            for(i in layout.models) {
                iniGap = 0;
                rstart = 0;
                i = p(i);
                if(isNaN(i)) continue;
                if(layout.orientation === 1) {
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
                tempRailsAccessory = emptyRail(i);
                curRailLength = 0;
                continuous = false;
                var ab = [];
                ab.midClamps = [];
                ab.endClamps = [];
                ab.clips = [];

                for(j in layout.models[i]) {
                    j = p(j);
                    if(isNaN(j)) continue;
                    if(layout.models[i][j].active) {
                        if(layout.alignCenter) {
                            curr = layout.rowIndentX[i] + (j - iniGap) * (width + config.imdX);
                        } else {
                            curr = j * (width  + config.imdX);
                        }
                        if(continuous){
                            curRailLength += width + config.imdX;
                            if(i === 0 || i == layout.models.length - 1) {
                                tempRailsAccessory[i+1].endClamps.pop();
                                tempRailsAccessory[i+1].midClamps.push(get2(curr));
                            }
                        } else{
                            if(i === 0 || i == layout.models.length - 1) {
                                tempRailsAccessory[i+1].endClamps.push(get2(curr));
                            }

                            start = j;
                            curRailLength = width;
                            continuous = true;
                        }
                        tempRailsAccessory[i]['b'].push(get2(curr + width * .25));
                        tempRailsAccessory[i]['b'].push(get2(curr + width * .75));

                        tempRailsAccessory[i+1]['a'].push(get2(curr + width * .25));
                        tempRailsAccessory[i+1]['a'].push(get2(curr + width * .75));

                        tempRailsAccessory[i+1].endClamps.push(get2(curr + width  + config.imdX));

                        if(j == ( layout.models[i].length - 1)) {
                            if(layout.alignCenter) {
                                start = layout.rowIndentX[i] + (start - iniGap) * (width + config.imdX);
                            } else {
                                start = start * (width  + config.imdX);
                            }
                            if(i === 0) {
                                this.createRail(layout, 0, rstart, start, curRailLength, tempRailsAccessory[i+1]);
                                if(layout.models.length > 1) {
                                    tempRails[1]['a'].push({
                                        i : 1,
                                        j : j,
                                        start: start,
                                        end: start + curRailLength,
                                        length: curRailLength,
                                        safeZones: tempRailsAccessory[1]['a'],
                                        judged: false
                                    });
                                } else {
                                    this.createRail(layout, 1, rstart, start, curRailLength, tempRailsAccessory[i+1]);
                                }
                            } else if(i == layout.models.length - 1) {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: start,
                                    end: start + curRailLength,
                                    length: curRailLength,
                                    safeZones: tempRailsAccessory[i]['b'],
                                    judged: false
                                });
                                this.createRail(layout, i+1, rstart, start, curRailLength, tempRailsAccessory[i+1]);
                            } else {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: start,
                                    end: start + curRailLength,
                                    length: curRailLength,
                                    safeZones: tempRailsAccessory[i]['b'],
                                    judged: false
                                });
                                tempRails[i+1]['a'].push({
                                    i : i,
                                    j : j,
                                    start: start,
                                    end: start + curRailLength,
                                    length: curRailLength,
                                    safeZones: tempRailsAccessory[i+1]['a'],
                                    judged: false
                                });
                            }
                            tempRailsAccessory = emptyRail(i);
                            rstart++;
                        }
                    } else {
                        if(curRailLength > 0) {
                            if(layout.alignCenter) {
                                start = layout.rowIndentX[i] + (start - iniGap) * (width + config.imdX);
                            } else {
                                start = start * (width + config.imdX);
                            }
                            if(i === 0) {
                                this.createRail(layout, 0, rstart, start, curRailLength, tempRailsAccessory[1]);
                                if(layout.models.length > 1) {
                                    tempRails[1]['a'].push({
                                        i : i+1,
                                        j : j,
                                        start: start,
                                        end: start + curRailLength,
                                        length: curRailLength,
                                        safeZones: tempRailsAccessory[1]['a'],
                                        judged: false
                                    });
                                } else {
                                    this.createRail(layout, 1, rstart, start, curRailLength, tempRailsAccessory[1]);
                                }
                            } else if(i == layout.models.length - 1) {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: start,
                                    end: start + curRailLength,
                                    length: curRailLength,
                                    safeZones: tempRailsAccessory[i]['b'],
                                    judged: false
                                });
                                this.createRail(layout, i+1, rstart, start, curRailLength, tempRailsAccessory[i+1]);
                            } else {
                                tempRails[i]['b'].push({
                                    i : i,
                                    j : j,
                                    start: start,
                                    end: start + curRailLength,
                                    length: curRailLength,
                                    safeZones: tempRailsAccessory[i+1]['a'],
                                    judged: false
                                });
                                tempRails[i+1]['a'].push({
                                    i : i,
                                    j : j,
                                    start: start,
                                    end: start + curRailLength,
                                    length: curRailLength,
                                    safeZones: tempRailsAccessory[i]['b'],
                                    judged: false
                                });
                            }
                            tempRailsAccessory = emptyRail(i);
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
                        if(typeof this.rails[ri] === 'object')
                            this.addRail(layout, this.rails[ri], i, ri);
                    }
                }
            }
        };

        SharedCalculator.createRail = function(layout, i, j, start, rlength, tempRailsAccessory) {
            var Rail = {
                id : 'r' + i + 'x' + j,
                i: i,
                j: j,
                left: 60+start,
                length : rlength,
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

            var ini, current, max;

            max = Rail.length + Rail.left;

            ini = Rail.left + config.getCantilever();
            current = bisect(layout.rafters, ini);
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
                current = bisect(layout.rafters, max);

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
        }
        return SharedCalculator;
    }());
    window.SharedCalculator = SharedCalculator;
}(window));