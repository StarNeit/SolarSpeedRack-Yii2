
(function(){
    "use strict";
    var app = angular
                .module('solarApp');
    app.service('ConfigService',['$http', function($http){

        var conf = {
            id: 0,
            name: '',
            moduleManufacturer : "Default (64.5 X 38.7 X 1.6)",
            moduleModel : "",
            modulePrices : [],
            moduleMinimum : 0,
            moduleId : 0,
            inverterType : 'micro',
            inverterManufacturer : "None",
            inverterModel : "",
            inverterPrices : [],
            inverterMinimum : 0,
            inverterId : 0,
            inverterWatt : 0,
            raManufacturer : "None",
            raModel : "",
            raId : 0,
            raPrices : [],
            raMinimum : 0,
            ppManufacturer : "None",
            ppModel : "",
            ppPrices : [],
            ppMinimum : 0,
            usePP : false,
            type: 1, // 0 for SpeedRack, 1 for hrs
            imdX: 0.4,
            imdY: 1.82,
            railSize: 138,
            maxSpan: 96,
            maxCantilever: 38.4,
            roofType: 0,
            roofPitch: 1,
            windExposer: 0,
            exposerType: 0,//
            windZoneType: 0,//
            useSpeedFoot: false,//
            speedFootType: 0,//
            useIB: false,//
            useMicroInverter: true,//
            useOptimizer: false,//
            span: 96,//
            moduleWatt: 300,//
            moduleLength: 64.5,//
            moduleWidth: 38.7,//
            moduleHeight: 1.6,//
            condition: 'Not Set',
            buildingCode: 1, //
            windSpeed: 110,//
            snowLoad: 20,//
            discount: 0,
            rafterDistance: 24,
            layoutNo: 1,
            spliceSize: 6,
            lfootLength: 1.5,
            sfootLength: 1.5,
            minimumSpace: 1,
            requiredParts: [],
            userParts: [],
            partColor: [],
            defaultColor: "BC",
            changed: true
        },
            parts,
            sharedPenetration = false,
            selectableParts = ['module', 'inverter', 'ra', 'pp'],
            defaults = {
                condition : 'Default',
                windSpeed : 110,
                snowLoad : 20
            }, tp;

        conf.setDifference = function () {
            sharedPenetration = this.requiredParts['LFootBrackets'];
            setTimeout(function () {
                sharedPenetration = false;
            }, 500);
        };
        conf.showCustomRafter = function() {
            return this.rafterDistance == 12 || this.rafterDistance == 16 || this.rafterDistance == 24;
        };
        conf.getDifference = function () {
            if(sharedPenetration) {
                return this.requiredParts['LFootBrackets'] - sharedPenetration;
            } else {
                return false;
            }
        };
        conf.staticParts = function() {
            return parts;
        };
        conf.getSelectableParts = function() {
            return selectableParts;
        };
        conf.resetQty = function (part) {
            this.userParts[part] = this.requiredParts[part];
        }
        conf.getParts = function() {
            var part, allParts = [], qty;
            for(var i in parts) {
                part = parts[i];
                qty = pf(this.userParts[part.slug]);
                if(qty > 0) {
                    allParts.push({
                        id: part.id,
                        qty: qty
                    });
                }
            }

            for(var i in selectableParts) {
                if(this[selectableParts[i] + 'Id'] > 0) {
                    qty = pf(this.userParts[selectableParts[i]]);
                    if (qty > 0) {
                        allParts.push({
                            id: this[selectableParts[i] + 'Id'],
                            qty: qty
                        });
                    }
                }
            }
            return allParts;
        };
        var root = document.getElementsByTagName('base')[0].getAttribute('href');
        $http.get(root +'get?alias=parts').success(
            function (data) {
                parts = data;
                conf.resetRequired();
                if(conf.id === 0) {
                    conf.copyToUser();
                    for(var i in parts) {
                        conf.partColor[parts[i].slug] = parts[i].colors[0];
                    }
                }
                conf.changed = !conf.changed;
            });

        conf.resetRequired = function () {
            for(var i in parts) {
                this.requiredParts[parts[i].slug] = 0;
            }
            for(var i in selectableParts) {
                this.requiredParts[selectableParts[i]] = 0;
            }
        };

        conf.copyToUser = function () {
            this.userParts = [];
            for(var i in this.requiredParts) {
                this.userParts[i] = this.requiredParts[i];
            }
        };

        conf.partPrice = function(part, qty) {
            return get2(this.getPrice(part['price'][this.partColor[part.slug]], qty, qty));
        };
        conf.getPrice = function(prices, qty, totalQuantity) {
            if(prices.length > 0) {
                for(var i in prices) {
                    if(qty >= prices[i].min && (qty <= prices[i].max || prices[i].max === 0)) {
                        return prices[i]['price'] * totalQuantity;
                    }
                }
            }
            return 0;
        };

        conf.priceFor = function(name, qty, totalQuantity) {
            return this.getPrice(this[name+'Prices'], qty, totalQuantity);
        };
        conf.totalPrice = function() {
            var tot = 0, i, qty;

            for(i in parts) {
                qty = pf(this.userParts[parts[i].slug], qty);
                if(qty > 0) {
                    tot += this.partPrice(parts[i], qty, qty);
                }
            }
            for(i in selectableParts) {
                if(this[selectableParts[i] + 'Id'] > 0) {
                    tot += this.priceFor(selectableParts[i], this.userParts[selectableParts[i]], this.userParts[selectableParts[i]]);
                }
            }
            tp = tot;
            return tp;
        };
        conf.costPerWatt = function() {
            var totalWatt = this.userParts['module'] * this.moduleWatt;
            if(totalWatt === 0) {
                return 0;
            } else {
                return tp / totalWatt;
            }
        };
        conf.costPerPanel = function() {
            if(this.userParts['module'] === 0) {
                return 0;
            } else {
                return tp / this.userParts['module'];
            }
        };

        conf.mainCsvData = function() {
            var arr = [
                {
                    a: "Name",
                    b: "Description",
                    c: "Quantity",
                    d: "Suggested Quantity",
                    e: "$/Unit",
                    f: "Price"
                }
            ], i, part;

            for(i in selectableParts) {
                if(this[selectableParts[i] + 'Id'] > 0) {
                    arr.push({
                        a: conf[selectableParts[i] + 'Manufacturer'],
                        b: conf[selectableParts[i] + 'Model'],
                        c: conf.userParts[selectableParts[i]],
                        d: conf.requiredParts[selectableParts[i]],
                        e: conf.priceFor(selectableParts[i], this.userParts[selectableParts[i]], 1),
                        f: conf.priceFor(selectableParts[i], this.userParts[selectableParts[i]], this.userParts[selectableParts[i]])
                    });
                }
            }
            for(i in parts) {
                part = parts[i];
                if(this.requiredParts[part.slug] !== 0) {
                    arr.push({
                        a: part.code,
                        b: part.description,
                        c: conf.userParts[part.slug],
                        d: conf.requiredParts[part.slug],
                        e: conf.partPrice(part, conf.userParts[part.slug], 1),
                        f: conf.partPrice(part, conf.userParts[part.slug], conf.userParts[part.slug])
                    });
                }
            }

            return arr;
        };

        conf.switch = function () {
            this.type = !this.type;
            if(this.type == 1) {
                this.railSize = 138;
                this.spliceSize = 10;
                this.imdX = 1;
                this.imdY = 1.06;
            } else {
                this.railSize = 120;
                this.spliceSize = 6;
                this.imdX = 0.4;
                this.imdY = 1.82;
            }
        };
        conf.railFix = function () {
            if(this.type == 1) {
                this.railSize = 138;
                this.spliceSize = 10;
                this.imdX = 1;
                this.imdY = 1.06;
            }
        };


        conf.setConfig =  function(data) {
            angular.extend(conf, data); 
        };

        conf.getCantilever = function() {
            var sideAllowance = 0;
            if(this.type) {
                sideAllowance = 1;
            }
            if(this.maxCantilever > (this.span * .4)) {
                return get2(this.span * .4) - sideAllowance;
            } else {
                return this.maxCantilever - sideAllowance;
            }
        };

        conf.currentMaxSpan = 0;
        conf.getMaxSpanLength = function() {
            this.currentMaxSpan = round5(get2((100 * this.maxSpan) / 144));
            return this.currentMaxSpan;
        };

        conf.customized = function(dflt) {
            if(dflt) {
                this.moduleManufacturer = 'Default (64.5 X 38.7 X 1.6)';
                this.moduleWatt =  300;
                this.moduleLength = 64.5;
                this.moduleWidth = 38.7;
                this.moduleHeight = 1.6;
                this.moduleModel = '';
                this.moduleId = 0;
                this.modulePrices = [];
                this.changed = !this.changed;
            } else {
                this.moduleManufacturer = 'Custom (' + this.moduleLength + ' X ' + this.moduleWidth + ' X ' + this.moduleHeight + ')';
                this.moduleModel = '';
                this.moduleId = 0;
                this.modulePrices = [];
                this.changed = !this.changed;
            }
        };

        conf.setColor = function (color) {
            this.defaultColor = color;
            for(var i in parts) {
                if(parts[i].colors.indexOf(color) != -1) {
                    this.partColor[parts[i].slug] = color;
                }
            }
            this.changed = !this.changed;
        }

        window.conf = conf;
        return conf;
    }]);
})();