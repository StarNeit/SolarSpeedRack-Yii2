(function(window) {
    var conf = (function() {
        var conf = {
            id: 0,
            name: 'its a project',
            moduleManufacturer : "Default (64.5 X 38.7 X 1.6)",
            moduleModel : "",
            modulePrices : [],
            moduleMinimum : 0,
            moduleId : 0,
            usePP : false,
            type: 1, // 0 for SpeedRack, 1 for hrs
            imdX: 0.4,
            imdY: 1.82,
            railSize: 138,
            maxSpan: 96,
            maxCantilever: 31.4,
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
            panelRotation: [],
            defaultColor: "BC",
            totalPanel: 0,
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
        $.get('/calculator/get?alias=parts').success(
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
        conf.package = function(no) {
            var tot = this.totalPrice();
            tot += 500 + 500; // bos and permit cost

            switch(no) {
                case 1:
                    tot += (220 + 50) * this.requiredParts['module']; // 220 for module, 50 for microinverter
                    break;
                case 2:
                    tot += 220 * this.requiredParts['module']; // 220 for module
                    tot += 50 + 1500;
                    break;
                default:
                    tot += 220 * this.requiredParts['module']; // 220 for module
                    tot += 1500;
                    break;
            }
            tot += .9 * this.requiredParts['module'] * this.moduleWatt; // installation cost  
            tot += tot * .05; //order processing fee
            return tot;
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

        conf.save = function(ev) {
            $('.dark-bg').show();
            var layouts = [], config = this, l;
            if(!getPanel()) {
                toastr.error('Please create overlay first.', 'Nothing to save!')
                return;
            }
            if(config.name.length < 3) {
                toastr.error('Please type a Project Name with minimum length 3.', 'Name too small!')
                return;
            } else {
                jQuery("#loader").fadeIn(100);
            }
            aac.allOverlays.forEach(function (e, v) {
                if(e !== null) {
                    layouts.push({
                        name: "Layout " + (v + 1),
                        orientation: aac.allPanels[e.id].orientation === 'landscape' ? 1 : 2,
                        models: aac.allPanels[e.id].forSave(),
                        overlay: e.forSave(),
                        alignCenter: false,
                        type: 'shared'
                    });
                    l = new LayoutService(aac.allPanels[e.id].arrayDims.height - 1, aac.allPanels[e.id].arrayDims.width - 2, v,
                         aac.allPanels[e.id].forSave(), aac.allPanels[e.id].orientation === 'landscape' ? 1 : 2);
                    l.updateIndent();
                }
            });
            var wat = this.requiredParts['module'] * this.moduleWatt;
            $(".system-kw").text(get2(wat / 1000));
            $(".total-cost-p1").text(get2(this.package(1)));
            $(".cost-per-watt-p1").text(get2(this.package(1) / wat));
            $(".total-cost-p2").text(get2(this.package(2)));
            $(".cost-per-watt-p2").text(get2(this.package(2) / wat));
            $(".total-cost-p3").text(get2(this.package(3)));
            $(".cost-per-watt-p3").text(get2(this.package(3) / wat));
            $.fn.fullpage.moveSectionDown();
            $.fn.fullpage.moveSectionDown();
            return;
            layouts = JSON.stringify(layouts);
            $.ajax({
                url: '/calculator/save',
                type: 'post',
                dataType: 'json',
                data: {
                    id: config.id,
                    name: config.name,
                    zip: config.zipCode,
                    totalWatts: config.userParts['module'] * config.moduleWatt,
                    totalMaterial: config.requiredParts['LFootBrackets'],
                    costPerWatt: config.costPerWatt(),
                    costPerPanel: config.costPerPanel(),
                    lat: aac.gMap.center.lat(),
                    lng: aac.gMap.center.lng(), 
                    config: JSON.stringify(config),
                    // parts: config.getParts(),
                    layouts: layouts,
                    mainCsvData: config.mainCsvData(),
//                        csvData: this.csvData() // for dxf
                },
                success: function (data) {
                    if (data.status == 'success') {
                        if (!data.userId) {
                            window.location.pathname = '/calculator/newuser/' + data.id;
                            return;
                        }
                        var nw = 'Saved';
                        if (config.id > 0) {
                            nw = 'Updated';
                        } else {
                            window.location.pathname = '/calculator/' + data.id;
                        }
                        config.id = data.id;
                        toastr.success('Your Tool Configuration Was ' + nw + ' Successfully.');
                    } else {
                        alert('Sorry, ' + data.errors[0]);
                    }
                    $('.dark-bg').fadeOut();
                }
            });
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
                this.railSize = 138;
                if(this.type == 1) {
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
        return conf;
    }());
    window.config = conf;
}(window));