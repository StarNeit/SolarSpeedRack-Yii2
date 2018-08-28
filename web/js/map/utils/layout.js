/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function(window) {
    var LayoutService = function(rows, cols, layoutNo, models, orientation, alignCenter, type) {
        if(rows === undefined) {
            rows = 4;
        }
        if(cols === undefined) {
            cols = 3;
        }

        if(models === undefined) {
            models = [];
        }
        if(orientation === undefined) {
            orientation = 1;
        }
        if(alignCenter === undefined) {
            alignCenter = false;
        }
        if(type === undefined) {
            type = 'shared';
        }
        var layout = {
            id: "layout" + layoutNo,
            name : "Layout " + layoutNo,
            type: type,
            rows : rows,
            columns : cols,
            orientation : orientation,
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
        }
            var calculator = SharedCalculator;

        // layout.setCalculator = function (toType) {
        //     if(config.type == 1) {
        //         if(toType) {
        //             this.type = toType;
        //         }
        //         if(this.type == 'shared') {
        //             calculator = SharedCalculator;
        //         } else {
        //             calculator = StandardCalculator;
        //         }
        //     } else {
        //         calculator = SpeedRackCalculator;
        //     }
        //     mainCalculator.calculate(this);
        // },
        // layout.updateCalculator = function (type) {
        //     if(type == 'standard') {
        //         config.setDifference();
        //     } else {
        //         this.groundLugs = 1;
        //     }
        //     this.setCalculator(type);
        //     config.changed = !config.changed;
        // },
        layout.getCalculator = function () {
            // if(!calculator) {
            //     this.setCalculator();
            // }
            return SharedCalculator;
        },
        layout.generateModels = function() {
            var rows = p(this.rows),
                cols = p(this.columns);
            if(this.models.length > rows) {
                this.models.splice(rows, this.models.length - rows);
            } else if(this.models.length < rows) {
                for (var i = this.models.length; i < rows; i++) {
                    this.models[i] = [];
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
        layout.updateRafters = function() {
            this.getCalculator().updateRafters(this);
        },
        layout.updateIndent = function () {
            this.getCalculator().updateIndent(this);
        },
        layout.update = function () {
            this.getCalculator().update(this);
        },
        layout.getScaled = function(val) {
            return Math.floor(val * this.scale) / 100;
        },
        layout.createModel = function(i, j) {
            return {
                i: i,
                j: j,
                active: true
            };
        },
        layout.setRafters  = function(val) {
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
        return layout;
    };
    window.LayoutService = LayoutService;
}(window));