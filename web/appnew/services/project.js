/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



(function(){
    "use strict";
    var app = angular
                .module('solarApp');
    app.service('ProjectService',['$state', '$http', 'LayoutService', 'ConfigService', 'CalculatorService', '$mdDialog', function($state, $http, Layout, config, calculator, $mdDialog){

        var layoutsArr = [];

        this.changeType = function () {
            config.switch();
            this.setSpan();
            this.configUpdated();
        }

        this.configUpdated = function () {
            for(var i in layoutsArr) {
                layoutsArr[i].setCalculator();
            }
            config.changed = !config.changed;
        }
        this.updateLayout = function (index, toType) {
            layoutsArr[index].setCalculator(toType);

            for(var i in layoutsArr) {
                layoutsArr[i].update();
            }
            calculator.calculate();
            config.changed = !config.changed;
        }

        this.addLayout = function(rows, cols) {
            var type = 'shared';
            for(var i in layoutsArr) {
                if(layoutsArr[i].isActive) {
                    type = layoutsArr[i].type;
                }
                layoutsArr[i].isActive = false;
            }
            layoutsArr.push(new Layout(rows, cols, config.layoutNo, [], [], false, type));
            config.layoutNo++;
        };


        this.removeLayout = function(ev, index) {
            var confirm = $mdDialog.confirm()
                    .parent(angular.element(document.body))
                    .title('Are you sure?')
                    .content('You can not undo this step later. Select yes if you really want to remove this layout.')
                    .ariaLabel('Warning')
                    .ok('Yes!')
                    .cancel('No')
                    .targetEvent(ev),
                $this = this;
            $mdDialog.show(confirm).then(function() {
                layoutsArr.splice(index, 1);
                for(var i in layoutsArr) {
                    $this.showLayout(i);
                    break;
                }
                config.changed = !config.changed;
            }, function() {});
        }

        this.showLayout = function(index) {
            for(var i in layoutsArr) {
                layoutsArr[i].isActive = false;
            }
            layoutsArr[index].isActive = true;
            return false;
        };
        this.getAllLayout = function() {
            return layoutsArr;
        };

        this.alert = function(ev, label, msg, done) {
            $mdDialog.show(
                $mdDialog.alert()
                    .parent(angular.element(document.body))
                    .title(label)
                    .content(msg)
                    .ariaLabel(label)
                    .ok(done)
                    .targetEvent(ev)
            );
        };

        var initiated = false;
        this.get = function(id) {
            if(initiated) {
                return this;
            } else {
                initiated = true;
            }
            if(parseInt(id) > 0){
                $('.dark-bg').show();
                var root = document.getElementsByTagName('base')[0].getAttribute('href'), $this = this;
                $http.get(root + 'get?alias=project&id=' + $state.params.id).success(function (response) {
                    response.config.id = $state.params.id;
                    config.setConfig(response.config);

                    config.layoutNo = 1;
                    for (var i in response.layouts) {
                        var l = response.layouts[i];
                        layoutsArr.push(new Layout(l.models.length, l.models[0].length, config.layoutNo, l.models, l.orientations, l.alignCenter, l.type));
                        config.layoutNo++;
                    }
                    $this.showLayout(i);
                    config.railFix();
                    config.changed = !config.changed;
                    $('.dark-bg').hide();
                });
            } else {
                this.addLayout(4, 3);
            }
            return this;
        };

        this.save = function(ev) {
            $('.dark-bg').show();
            var root = document.getElementsByTagName('base')[0].getAttribute('href');
            var layouts = [], $this = this;

            if(config.name.length < 3) {
                this.alert(ev, 'Project Name', 'Please type a Project Name with minimum length 3.', 'Got it!');
                return;
            } else {
                jQuery("#loader").fadeIn(100);
            }
            for(var i in layoutsArr) {
                layouts.push({
                    name: layoutsArr[i].name,
                    orientations: layoutsArr[i].orientations,
                    models: layoutsArr[i].models,
                    alignCenter: layoutsArr[i].alignCenter,
                    type: layoutsArr[i].type
                });
            }
            layouts = JSON.stringify(layouts);
            $.ajax({
                url: root + 'save',
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
                    config: JSON.stringify(config),
                    parts: config.getParts(),
                    layouts: layouts,
                    mainCsvData: config.mainCsvData(),
//                        csvData: this.csvData() // for dxf
                },
                success: function (data) {
                    if (data.status == 'success') {
                        if (!data.userId) {
                            window.location.pathname = '/tool/newuser/' + data.id;
                            return;
                        }
                        var nw = 'Saved';
                        if (config.id > 0) {
                            nw = 'Updated';
                        } else {
                            $state.go('project', {id: data.id});
                        }
                        config.id = data.id;
                        $this.alert(ev, 'Done!', 'Your Tool Configuration Was ' + nw + ' Successfully.', 'Ok!');
                    } else {
                        $this.alert(ev, 'Error!', 'Sorry, ' + data.errors[0], 'Ok!');
                    }
                    $('.dark-bg').fadeOut();
                }
            });
        };


        this.setSpan = function() {
            var b= this.buildingTypes[config.buildingCode].code,
                w = config.windSpeed,
                s = config.snowLoad,
                sf = config.useSpeedFoot ? '1' : '0',
                e = this.exposerTypes[config.exposerType].id;

            config.condition = "Custom Condition";
            $http.get("/site/get?alias=span&b="+b+"&w="+w+"&s="+s+"&e="+e+"&sf="+sf).success(function(data) {
                if(data.status === 'success') {
                    if(data.max_span >= 144) {
                        config.maxSpan = 144;
                    } else if(data.max_span >= 120) {
                        config.maxSpan = 120;
                    } else if(data.max_span > 96) {
                        config.maxSpan = 96;
                    } else if(data.max_span > 72) {
                        config.maxSpan = 72;
                    } else if(data.max_span) {
                        config.maxSpan = 48;
                    }
                    if(config.type && config.maxSpan > 96) {
                        config.maxSpan = 96;
                    }
                    config.maxCantilever = get2(data.max_cantilever);

                    if(config.maxCantilever > (config.span * .4)) {
                        config.maxCantilever = get2(config.span * .4);
                    }

                    if(config.span > config.maxSpan) {
                        config.span = config.maxSpan;
                    }
                }
            });
        };

        this.buildingTypes = [
            {
                code: 1,
                name: 'ASCE 7-05'
            },
            {
                code: 2,
                name: 'ASCE 7-10'
            }
        ];

        this.exposerTypes = [
            {
                id: 2,
                name: 'Category B'
            },
            {
                id: 3,
                name: 'Category C'
            },
            {
                id: 4,
                name: 'Category D'
            }
        ];
        this.windZoneTypes = [
            {
                code: 1,
                name: 'Zone 1'
            },
            {
                id: 2,
                name: 'Zone 2'
            },
            {
                code: 3,
                name: 'Zone 3'
            }
        ];

        this.orientationTypes = [
            {
                value: 1,
                name: 'Landscape'
            },
            {
                value: 2,
                name: 'Portrait'
            }
        ];

        this.roofTypes = [
            {
                value: 1,
                name: 'Shingle'
            },
            {
                value: 2,
                name: 'S-Tile'
            },
            {
                value: 3,
                name: 'w-Tile'
            },
            {
                value: 4,
                name: 'Flat Tile'
            },
            {
                value: 5,
                name: 'Corrugated Metal'
            },
            {
                value: 6,
                name: 'Standing Seam'
            }
        ];

        this.roofPitches = [
            {
                value: 1,
                name: '0-7°',
                disabled: true
            },
            {
                value: 2,
                name: '7-27°',
                disabled: false
            },
            {
                value: 1,
                name: '27-45°',
                disabled: true
            }
        ];
        this.windExposers = [
            {
                value: 1,
                name: 'In Town'
            },
            {
                value: 2,
                name: 'Open Terrain'
            }
        ];
        this.flashingTypes = [
            {
                value: 1,
                name: 'EcoFasten'
            },
            {
                value: 2,
                name: 'Customer choice'
            }
        ];
        this.inverterTypes = [
            {
                type: 'micro',
                name: 'Grid-Tie Microinverters'
            },
            {
                type: 'string',
                name: 'Grid-Tie String Inverters'
            },
            {
                type: 'optimizer',
                name: 'Optimizers / Maximizers'
            },
        ];
        this.inverterLabel = function () {
            switch (config.inverterType) {
                case 'string':
                    return 'Grid-Tie String Inverters';
                case 'optimizer':
                    return 'Optimizers / Maximizers';
                default:
                    return 'Grid-Tie Microinverters';
            }
        }
        window.project = this;
    }]);
})();