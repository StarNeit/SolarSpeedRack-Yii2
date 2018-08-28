/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



(function(){
    "use strict";
    var app = angular
                .module('solarApp');
    app.factory('LayoutService',['$mdDialog', 'ConfigService', 'SpeedRackCalculator', 'StandardCalculator', 'SharedCalculator', 'CalculatorService', function($mdDialog, config, SpeedRackCalculator, StandardCalculator, SharedCalculator, mainCalculator) {
            
            function LayoutService(rows, cols, layoutNo, models, orientations, alignCenter, type) {
                if(rows === undefined) {
                    rows = 4;
                }
                if(cols === undefined) {
                    cols = 3;
                }

                if(models === undefined) {
                    models = [];
                }
                if(orientations === undefined) {
                    orientations = [];
                }
                if(alignCenter === undefined) {
                    alignCenter = false;
                }
                if(type === undefined) {
                    type = 'shared';
                }

                angular.extend(this, {
                    id: "layout" + layoutNo,
                    name : "Layout " + layoutNo,
                    type: type,
                    rows : rows,
                    columns : cols,
                    orientations : orientations,
                    scale: 120,
                    models : models,
                    activePanels : 0,
                    colLengths: [],
                    colMaxLength: 0, 
                    rowIndentX: [],
                    rowIndentY: [],
                    actualRowIndentY: [],
                    rails : [],
                    rightEnd : 0,
                    tempRightEnd : 0,
                    railCount : 0,
                    lfootCount : 0,
                    sfootCount : 0,
                    spliceCount : 0,
                    endClampCount : 0,
                    midClampCount : 0,
                    railClipCount : 0,
                    endCaps: 0,
                    groundLugs:1,
                    alignCenter: alignCenter,
                    cutRails: [],
                    rafters:[],
                    allRafters: [],
                    isActive: true
                });
                for (var i = 0; i < 20; i++ ){
                    this.rowIndentX[i] = 0;
                    this.rowIndentY[i] = 0;
                }

                this.setCalculator();
                this.generateModels();
                this.updateRafters();
            };

            var calculator;

            LayoutService.prototype = {
                setCalculator: function (toType) {
                    if(config.type == 1) {
                        if(toType) {
                            this.type = toType;
                        }
                        if(this.type == 'shared') {
                            calculator = SharedCalculator;
                        } else {
                            calculator = StandardCalculator;
                        }
                    } else {
                        calculator = SpeedRackCalculator;
                    }
                    mainCalculator.calculate(this);
                },
                updateCalculator: function (type) {
                    if(type == 'standard') {
                        config.setDifference();
                    } else {
                        this.groundLugs = 1;
                    }
                    this.setCalculator(type);
                    config.changed = !config.changed;
                },
                getCalculator: function () {
                    if(!calculator) {
                        this.setCalculator();
                    }
                    return calculator;
                },
                generateModels: function() {
                    var rows = p(this.rows),
                        cols = p(this.columns);
                    if(this.models.length > rows) {
                        this.models.splice(rows, this.models.length - rows);
                        this.orientations.splice(rows, this.orientations.length - rows);
                    } else if(this.models.length < rows) {
                        for (var i = this.models.length; i < rows; i++) {
                            this.models[i] = [];
                            this.orientations[i] = 2;
                            for (var j = 0; j < this.columns; j++) {
                                this.models[i][j] = this.createModel(i, j);
                            }
                        }
                    } else if(this.models[0].length > cols) {
                        for (var i = 0; i < rows; i++) {
                            this.models[i].splice(cols, this.models[i].length - cols);
                        }
                    } else if(this.models[0].length < cols) {
                        for (var i = 0; i < rows; i++) {
                            for (var j = this.models[i].length; j < cols; j++) {
                                this.models[i].push(this.createModel(i, j));
                            }
                        }
                    }

                    this.activePanels = 0;
                    
                    for(i in this.models) {
                        for(j in this.models[i]) {
                            if(this.models[i][j].active) {
                                this.activePanels++;
                            }
                        }
                    }
                    config.changed = !config.changed;
                },
                updateRafters: function() {
                    calculator.updateRafters(this);
                },
                updateIndent: function () {
                    calculator.updateIndent(this);
                },
                update: function () {
                    calculator.update(this);
                },
                getScaled: function(val) {
                    return Math.floor(val * this.scale) / 100;
                },
                changeName: function($event) {
                
                        var parentEl = angular.element(document.body);
                        $mdDialog.show({
                          parent: parentEl,
                          targetEvent: $event,
                          template:
                            '<md-dialog aria-label="Layout Name Changer">' +
                            '  <md-dialog-content>'+
                            '      <md-input-container flex>' +
                            '           <label>Layout Name</label>' +
                            '           <input class="" required ng-model="layout.name" placeholder="Enter Layout Name...">' +
                            '      </md-input-container>' +
                            '  </md-dialog-content>' +
                            '  <div class="md-actions">' +
                            '    <md-button ng-click="closeDialog()" class="md-primary">' +
                            '      Close' +
                            '    </md-button>' +
                            '  </div>' +
                            '</md-dialog>',
                          locals: {
                            layout: Layout
                          },
                          controller: DialogController
                       });
                       function DialogController($scope, $mdDialog, layout) {
                         $scope.layout = layout;
                         $scope.closeDialog = function() {
                           $mdDialog.hide();
                         };
                       }
                },
                createModel: function(i, j) {
                    return {
                        i: i,
                        j: j,
                        active: true
                    };
                },
                setRafters : function(val) {
                    this.rafters = [];
                    this.allRafters = [];
                    for( var rt = val; rt < 2000; rt += config.rafterDistance ) {
                        this.rafters.push(60 + get2(rt));
                    }
                    while(val+60 > 0) {
                        val -= config.rafterDistance;
                        this.allRafters.push(60 + get2(val));
                    }
                    Array.prototype.push.apply(this.allRafters, this.rafters);
                }
            };


            return LayoutService;
    }]);
})();