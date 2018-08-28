/**
 * Created by Awsaf on 7/4/2016.
 */

(function(window) {
    var CalculatorService = (function() {
        var CalculatorService = {}
        
        var layouts = [], cutRails = [];

        CalculatorService.updateLayoutData = function(layout) {
            console.log(layout);
            layout.update();
            cutRails[layout.id] = layout.cutRails;

            layouts[layout.id] = {
                type: layout.type,
                activePanels: layout.activePanels,
                railCount: layout.railCount,
                lfootCount: layout.lfootCount,
                sfootCount: layout.sfootCount,
                spliceCount: layout.spliceCount,
                endClampCount: layout.endClampCount,
                midClampCount: layout.midClampCount,
                railClipCount: layout.railClipCount,
                endCaps: layout.endCaps,
                groundLugs: layout.groundLugs
            };
        };

        CalculatorService.calculate = function (layout) {
            var i, totalRail = 0;

            if(layout !== undefined) {
                this.updateLayoutData(layout);
            }

            config.resetRequired();

            for(i in layouts) {
                config.requiredParts['module'] += layouts[i].activePanels;
                if(config.type) {
                    if(config.useIB) {
                        if(layouts[i].type == 'standard') {
                            if(config.inverterType == 'micro') {
                                config.requiredParts['HRSMiFastener'] += layouts[i].activePanels;
                            } else {
                                config.requiredParts['HRSMiFastener'] += 1;
                            }
                        } else {
                            if(config.inverterType == 'micro') {
                                config.requiredParts['IBKit'] += layouts[i].activePanels;
                            } else {
                                config.requiredParts['IBKit'] += 1;
                            }
                        }
                    }

                    config.requiredParts['HRSRails'] += layouts[i].railCount;
                    config.requiredParts['HRSSpliceBars'] += layouts[i].spliceCount;
                    config.requiredParts['HRSTekScrews'] += layouts[i].spliceCount * 2;
                    config.requiredParts['EndClamp'] += layouts[i].endClampCount;
                    config.requiredParts['MidClamp'] += layouts[i].midClampCount;
                    config.requiredParts['RailClip'] += layouts[i].railClipCount;
                    config.requiredParts['HRSEndCaps'] += layouts[i].endCaps;
                } else {
                    config.requiredParts['Rails'] += layouts[i].railCount;
                    if(config.useIB) {
                        if(config.inverterType == 'micro') {
                            config.requiredParts['IBKit'] += layouts[i].activePanels;
                        } else {
                            config.requiredParts['IBKit'] += 1;
                        }
                    }
                    config.requiredParts['SpliceBars'] += layouts[i].spliceCount;
                    config.requiredParts['EndCaps'] += layouts[i].endCaps;
                }
                config.requiredParts['LFootBrackets'] += layouts[i].lfootCount;
                config.requiredParts['SpeedFoot'] += layouts[i].sfootCount;
                config.requiredParts['GroundLugs'] += layouts[i].groundLugs;
            }

            var newCutRails = [], ni, nc, notFound, oldCutRails = [];
            for(i in cutRails) {
                notFound = true;
                for (nc in cutRails[i]) {
                    oldCutRails = oldCutRails.concat(cutRails[i][nc]);
                }
            }
            oldCutRails.sort(function(a, b) {
                return a - b;
            });

            for(i in oldCutRails) {
                notFound = true;
                for(ni in newCutRails) {
                    if(oldCutRails[i] <= newCutRails[ni]) {
                        newCutRails[ni] = newCutRails[ni] - oldCutRails[i];
                        notFound = false;
                        break;
                    }
                }
                if(notFound) {
                    for (ni in oldCutRails) {
                        if (oldCutRails[i] <= cutRails[ni]) {
                            totalRail++;
                            oldCutRails[ni] = 0;
                            newCutRails.push(oldCutRails[ni] - oldCutRails[i]);
                            notFound = false;
                            break;
                        }
                    }
                }
                if(notFound) {
                    totalRail++;
                    newCutRails.push(config.railSize - oldCutRails[i]);
                }
            }
            if(config.type) {
                config.requiredParts['HRSRails'] += totalRail;
            } else {
                config.requiredParts['Rails'] += totalRail;
            }


            config.requiredParts['TBolts'] = config.requiredParts['LFootBrackets'] + config.requiredParts['SpeedFoot'];

            if(config.inverterType == 'micro') {
                config.requiredParts['inverter'] = config.requiredParts['module'];
            } else {
                config.requiredParts['inverter'] = 1;
            }
            config.requiredParts['ra'] = config.userParts['LFootBrackets'];

            config.requiredParts['pp'] = 1;

            config.copyToUser();

            this.totalWatts = config.requiredParts['module'] * config.moduleWatt;
        }
        return CalculatorService;
    }());
    window.CalculatorService = CalculatorService;
}(window));