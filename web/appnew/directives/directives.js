
(function(){
    "use strict";
    var app = angular
                .module('solarApp')
    app.directive('singleLayout', ['ConfigService', function(config){
        function link(scope, el, attr){
            var el = el[0],
                w = el.clientWidth - 100;
                
            var svg = d3.select(el).append('svg')
                    .attr({id: 'svg-' + attr.id, width: w, height: 400});
            
            var wholeContainer = svg.append("g"),
                    defs = svg.append("defs"),
                    rafContainer = wholeContainer.append("g"),
                    railContainer = wholeContainer.append("g"),
                    modelContainer = wholeContainer.append("g"),
                    accessoryContainer = wholeContainer.append("g"),
                    scaleContainer = wholeContainer.append("g");

            wholeContainer.attr('class', 'total-container');
                    
            var mg = defs.append("linearGradient").attr({
                id: "module-" + attr.id,
                x1: "0%",
                y1: "0%",
                x2: "0%",
                y2: "100%",
            });
            mg.append("stop").attr({offset: "0%", style : 'stop-color: rgb(113,179,218); stop-opacity: 1'});
            mg.append("stop").attr({offset: "100%", style : 'stop-color: rgb(36,144,206); stop-opacity: 1'});
            
            var rg = defs.append("linearGradient").attr({
                id: "rail-" + attr.id,
                x1: "0%",
                y1: "0%",
                x2: "0%",
                y2: "100%",
            });
            rg.append("stop").attr({offset: "0%", style : 'stop-color: rgb(225, 225, 225); stop-opacity: 1'});
            rg.append("stop").attr({offset: "100%", style : 'stop-color: rgb(187, 187, 187); stop-opacity: 1'});
               
            defs.append("marker")
                .attr("id", "triangle-start"+attr.id)
                .attr("viewBox", "0 0 10 10")
                .attr("refX", 10)
                .attr("refY", 5)
                .attr("markerWidth", -6)
                .attr("markerHeight", 6)
                .attr("fill", "#bbb")
                .attr("orient", "auto")
                .append("path")
                .attr("d", "M 0 0 L 10 5 L 0 10 z");

            defs.append("marker")
                .attr("id", "triangle-end"+attr.id)
                .attr("viewBox", "0 0 10 10")
                .attr("refX", 10)
                .attr("refY", 5)
                .attr("markerWidth", 6)
                .attr("markerHeight", 6)
                .attr("fill", "#bbb")
                .attr("orient", "auto")
                .append("path")
                .attr("d", "M 0 0 L 10 5 L 0 10 z");
                    
            scope.$watch(function() {
                return scope.changed;
            }, update);
            
            scope.$watch('layout.alignCenter', update);
                
            scope.$watch('layout.scale', updateZoom);
            
            function updateZoom() {
                var sh = getHeight(scope);
                svg
                    .transition()
                    .duration(300)
                    .attr( {"data-height": sh / (scope.layout.scale/100), "height" : sh});
                setWidth(svg, wholeContainer, scope.layout);
            }
                   
            
            scope.$watch('layout.rows', updateRow);

            function updateRow(nv, ov){
                var sh = getHeight(scope);
                if(nv !== ov) {
                    svg
                        .transition()
                        .duration(300)
                        .attr({"data-height": sh / (scope.layout.scale/100), "height" : sh});
                
                    if(nv < ov) {
                        for (nv; nv <=ov; nv++) {
                            wholeContainer.selectAll("rect.layout"+nv)
                                    .transition()
                                    .attr({
                                        x: 0,
                                        y: 0,
                                        height: 0,
                                        width: 0,
                                    })
                                    .remove();
                            
                        }
                    }
                    update();
                }
            }
            
            function update(){
                updateAll(scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr)
            };
        }
        function updateAll(scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr) {

            scope.layout.setCalculator();
            scope.layout.updateIndent();
            var data, r, i, j, accessories, ji, top = [], m, inc,
                data = [],
                accessories = [], height;
            for(i in scope.layout.rails) {
                i = p(i);
                if(config.type == 1) {
                    if(scope.layout.type == 'standard') {
                         if(i === 0) inc = true;
                         if(inc) {
                                 i++;
                         }
                        if (i % 2 === 0) {
                            m = (i - 2) / 2;
                            height = scope.layout.orientations[m] === 1 ? config.moduleWidth - 2 : config.moduleLength - 2;
                            top[i] = 90 + scope.layout.rowIndentY[m] + height * 0.75;
                        } else {
                            m = (i - 1) / 2;
                            height = scope.layout.orientations[m] === 1 ? config.moduleWidth - 2 : config.moduleLength - 2;
                            top[i] = 90 + scope.layout.rowIndentY[m] + height * 0.25;
                        }
                    } else {
                        if(p(i) === 0) {
                            height = scope.layout.orientations[0] === 1 ? config.moduleWidth - 2 : config.moduleLength - 2;
                            top[i] = 90 + scope.layout.rowIndentY[0] + height * 0.25;
                        } else if(i == scope.layout.models.length) {
                            height = scope.layout.orientations[i-1] === 1 ? config.moduleWidth - 2 : config.moduleLength - 2;
                            top[i] = 90 + scope.layout.rowIndentY[i-1] + height * 0.75;
                        } else {
                            top[i] = 90 + scope.layout.rowIndentY[i] - 4;
                        }
                    }
                }
                for(j in scope.layout.rails[i]) {
                    r = scope.layout.rails[i][j];

                    if(config.type == 1) {
                        data.push({i: r.i, j: r.j, left: r.left - 3, length: r.length + 6});
                    } else {
                        data.push({i: r.i, j: r.j, left: r.left, length: r.length});
                    }
                    for(ji in r.lfoots) {
                        accessories.push({i: i, type: 'lf', position: r.lfoots[ji]});
                    }
                    if(config.useSpeedFoot) {
                        for(ji in r.sfoots) {
                            accessories.push({i: i, type: 'sf', position: r.sfoots[ji]});
                        }
                    }
                    for(ji in r.splices) {
                        accessories.push({i: i, type: 'sp', position: r.splices[ji]});
                    }
                    for(ji in r.endClamps) {
                        accessories.push({i: i, type: 'ec', position: 59 + r.endClamps[ji]});
                    }
                    for(ji in r.midClamps) {
                        accessories.push({i: i, type: 'mc', position: 59 + r.midClamps[ji]});
                    }
                }
            }
            showRails(scope, data, railContainer, attr, top);

            scaleHandler(scope, scaleContainer, attr);
            layoutChanger (scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr);
            rafters(scope, rafContainer);
            modelHandler(scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr);
            showAccessories(scope, accessories, accessoryContainer, top);
            setTimeout(setWidth(svg, wholeContainer, scope.layout), 0);

        }
        function getHeight(scope) {
            return scope.layout.scale/100 * ( 150 + scope.layout.rowIndentY[scope.layout.rows]);
        }
        function setWidth(svg, wholeContainer,layout) {
            var sc = layout.scale/100,
                gw = (120+layout.rightEnd);

            svg.attr("width", gw * sc);
            wholeContainer.transition().attr("transform", "scale(" + sc + ")");
        }
        function scaleHandler (scope, scaleContainer, attr) {
            return;
            var data = [
                    {x1:60, y1: 70, x2:pf(scope.layout.rightEnd), y2: 70},
                    {x1:pf(scope.layout.rightEnd)+30, y1: 90, x2:pf(scope.layout.rightEnd)+30, y2: pf(scope.layout.rowIndentY[scope.layout.rails.length-1]) + 100}
                ],
            scales = scaleContainer.selectAll("line.scale").data(data),
            texts = scaleContainer.selectAll("text.scaletext").data(data);
            scales
                .enter()
                .append("line")
                .classed("scale", true)
                .attr({
                    x1: function(d) {
                        return d.x1;
                    },
                    y1: function(d) {
                        return d.y1;
                    },
                    x2: function(d) {
                        return d.x1;
                    },
                    y2: function(d) {
                        return d.y1;
                    }
                });
            scales
                .exit()
                .transition()
                .remove();
            scales
                .transition()
                .attr({
                    x1: function(d) {
                        return d.x1;
                    },
                    y1: function(d) {
                        return d.y1;
                    },
                    x2: function(d) {
                        return d.x2;
                    },
                    y2: function(d) {
                        return d.y2;
                    },
                    stroke: '#A6DB59',
                    "stroke-width": 1.5,
                    "marker-start": 'url(#triangle-start'+attr.id+')',
                    "marker-end": 'url(#triangle-end'+attr.id+')'
                });
            texts
                .enter()
                .append("text")
                .classed("scaletext", true)
                .text(function(d) {
                    if(d.x1 != d.x2) {
                        return  get2(d.x2-d.x1) + '"';
                    } else {
                        return  get2(pf(scope.layout.actualRowIndentY[scope.layout.rails.length-1]) + config.imdY) + '"';
                    }
                })
                .attr({
                    x: function(d) {
                        if(d.x1 != d.x2) {
                            return  d.x1 + (d.x2-d.x1) / 2;
                        } else {
                            return  d.x1 + 10;
                        }
                    },
                    y: function(d) {
                        if(d.x1 != d.x2) {
                            return  d.y1 - 20;
                        } else {
                            return  d.y1 + (d.y2-d.y1) / 2;
                        }
                    }
                });
            texts
                .exit()
                .transition()
                .remove();
            texts
                .transition()
                .text(function(d) {
                    if(d.x1 != d.x2) {
                        return  get2(d.x2-d.x1) + '"';
                    } else {
                        return  get2(pf(scope.layout.actualRowIndentY[scope.layout.rails.length-1]) + config.imdY) + '"';
                    }
                })
                .attr({
                    x: function(d) {
                        if(d.x1 != d.x2) {
                            return  d.x1 + (d.x2-d.x1) / 2;
                        } else {
                            return  d.x1 + 10;
                        }
                    },
                    y: function(d) {
                        if(d.x1 != d.x2) {
                            return  d.y1 - 20;
                        } else {
                            return  d.y1 + (d.y2-d.y1) / 2;
                        }
                    }
                });
        }
        function rafters (scope, rafContainer) {
            var height = getHeight(scope),
                    rafs = rafContainer.selectAll('rect.rafters')
                    .data(scope.layout.allRafters);
            
                rafs
                    .enter()
                    .append("rect")
                    .classed("rafters", true)
                    .attr({
                        x: function(d) {
                            return d-3;
                        },
                        y: -100,
                        height: '0',
                        width: 6,
                        fill: '#EFECE2'
                    });
                rafs
                    .exit()
                    .transition()
                    .attr({
                        y: 0,
                        height: 0
                    })
                    .remove();
                rafs
                    .transition()
                    .attr({
                        x: function(d) {
                            return d-3;
                        },
                        y: -100,
                        height: pf(height) * 2 + 90,
                        width: 6,
                        fill: '#EFECE2'
                    });
        }
        function layoutChanger (scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr) {
            
                var imgs = modelContainer.selectAll("image.layout-changer").data(scope.layout.orientations);
                
                var sh = getHeight(scope);
                svg
                    .transition()
                    .duration(300)
                    .attr({"height" : sh});
            
                imgs.enter()
                    .append("image")
                    .classed("layout-changer", true)
                    .attr({
                        x: 20,
                        y: function(d, i) {
                            return 85 + scope.layout.rowIndentY[i] + (config.moduleWidth / 2);
                        },
                        height: 0,
                        width: 0,
                        'xlink:href': function (d) {
                            if(d === 2) {
                                return SITE_ROOT + "images/tool/rotate.png";
                            } else {
                                return SITE_ROOT + "images/tool/rotate90.png";
                            }
                        }
                    }).on('click', function(d, i){
                        if (d3.event.defaultPrevented) return;
                        scope.$apply(function(){
                            if(d === 2) {
                                scope.layout.orientations[i] = 1;
                            } else {
                                scope.layout.orientations[i] = 2;
                            }

                            updateAll(scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr);
                        });
                    });
                imgs
                    .exit()
                    .transition()
                    .attr({
                        x: 0,
                        y: 0,
                        height: 0,
                        width: 0
                    })
                    .remove();  
                imgs
                    .transition()
                    .attr({
                        x: 15,
                        y: function(d, i) {
                            if(d === 1) {
                                return 95 + scope.layout.rowIndentY[i] + 3;
                            } else {
                                return 85 + scope.layout.rowIndentY[i] + (config.moduleWidth / 2);
                            }
                        },
                        height: 30,
                        width: 30,
                        'xlink:href': function (d) {
                            if(d === 2) {
                                return SITE_ROOT + "images/tool/rotate.png";
                            } else {
                                return SITE_ROOT + "images/tool/rotate90.png";
                            }
                        },
                    });
        }
        
        function modelHandler(scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr) {
            for(var i in scope.layout.models) {
                var data = [];
                if(scope.layout.alignCenter) {
                    for(var j in scope.layout.models[i]) {
                        j = p(j);
                        if(scope.layout.models[i][j].active) {
                            data.push(scope.layout.models[i][j]);
                        } else if(data.length > 0){
                            for(var ji = j+1; ji < scope.layout.models[i].length; ji++) {
                                if(scope.layout.models[i][ji].active) {
                                    data.push(scope.layout.models[i][j]);
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    for(var j in scope.layout.models[i]) {
                        data.push(scope.layout.models[i][j]);
                    }
                }
                var rects = modelContainer.selectAll("rect.layout"+i).data(data);
                
                rects.enter()
                        .append("rect")
                        .classed("layout"+i, true)
                        .classed("model", true)
                        .attr({
                            x: function(d, j) {
                                var mw = scope.layout.orientations[d.i] === 1 ? config.moduleLength : config.moduleWidth;
                                return 60 + j * mw + scope.layout.rowIndentX[d.i] + config.imdX;
                            },
                            y: function(d) {
                                if(config.type == 1) {
                                    return 90 + scope.layout.rowIndentY[d.i];
                                } else {
                                    return 90 + scope.layout.rowIndentY[d.i] + 6;
                                }
                            },
                            height: 0,
                            width: 0
                        }).on('click', function(d){
                            if (d3.event.defaultPrevented) return;
                            scope.$apply(function(){
                                d.active = !d.active;
                                updateAll(scope, svg, railContainer, modelContainer, accessoryContainer, wholeContainer, scaleContainer, rafContainer, attr);
                            });
                        });
                rects
                        .exit()
                        .transition()
                        .duration(300)
                        .attr({
                            x: 0,
                            y: 0,
                            height: 0,
                            width: 0,
                        })
                        .remove();
                rects
                        .classed("active", function(d) {
                            return d.active;
                        })
                        .transition()
                        .attr({
                            id: function(d) {return d.id;},
                            x: function(d, j) {
                                var mw = scope.layout.orientations[d.i] === 1 ? config.moduleLength : config.moduleWidth; 
                                return 60 + j * (mw + config.imdX) + scope.layout.rowIndentX[d.i]  ;
                            },
                            y: function(d) {
                                if(config.type == 1) {
                                    return 90 + scope.layout.rowIndentY[d.i];
                                } else {
                                    return 90 + scope.layout.rowIndentY[d.i] + 6;
                                }
                            },
                            width: function(d) {return scope.layout.orientations[d.i] === 1 ? config.moduleLength - 1 : config.moduleWidth - 1},
                            height : function(d) {
                                return scope.layout.orientations[d.i] === 1 ? config.moduleWidth : config.moduleLength;
                            }
                        });
            }
        }
        function showRails(scope, data, container, attr, top) {
            var rects = container.selectAll("rect.rail-layout").data(data);

            rects.enter()
                .append("rect")
                .classed("rail-layout", true)
                .classed("rails", true)
                .attr({
                    x: function(d) { return d.left;},
                    y: function(d) {
                        if(config.type == 1) {
                            return top[d.i];
                        } else {
                            return 90 + scope.layout.rowIndentY[d.i];
                        }
                    },
                    height: 0,
                    width: 0
                });
            rects
                .exit()
                .transition()
                .duration(300)
                .attr({
                    width: 0,
                })
                .remove();
            rects
                .transition()
                .attr({
                    id: function(d) {return 'rail-' + d.i + '-' + d.j;},
                    x: function(d) { return d.left;},
                    y: function(d) {
                        if(config.type == 1) {
                            return top[d.i];
                        } else {
                            return 90 + scope.layout.rowIndentY[d.i];
                        }
                    },
                    width: function(d) {return d.length - 1;},
                    height: 6, /* Rail Height*/
                });
        }
        
        function showAccessories(scope, data, container, top) {
            container.selectAll("rect.rail-accessory").remove();
            var rects = container.selectAll("rect.rail-accessory").data(data);
            rects.enter()
                .append("rect")
                .classed("rail-accessory", true)
                .attr({
                    x: function(d) { return d.position - 1.5;},
                    y: function(d) {
                        if(config.type == 1) {
                            return top[d.i];
                        } else {
                            return 90 + scope.layout.rowIndentY[d.i];
                        }
                    },
                    height: 0,
                    width: 0
                });
            rects
                .exit()
                .transition()
                .duration(300)
                .attr({
                    width: 0,
                })
                .remove();
            rects
                .classed("sf", function(d) { return d.type == 'sf'; })
                .classed("lf", function(d) { return d.type == 'lf'; })
                .classed("sp", function(d) { return d.type == 'sp'; })
                .classed("mc", function(d) { return d.type == 'mc'; })
                .classed("ec", function(d) { return d.type == 'ec'; })
                .transition()
                .attr({
                    x: function(d) { return d.position - 1.5;},
                    y: function(d) {
                        if(config.type == 1) {
                            return top[d.i];
                        } else {
                            return 90 + scope.layout.rowIndentY[d.i];
                        }
                    },
                    width: 3,
                    height: 6
                });
        }
        return {
            link: link,
            restrict: 'E',
            replace: true,
            scope: { layout: '=dmLayout', changed: '='}
        };
    }]);
    app.directive('focusMe', function() {
        return {
            scope: { trigger: '=focusMe' },
            link: function(scope, element) {
                scope.$watch('trigger', function(value) {
                    if(value === true) { 
                        element[0].focus();
                    }
                });
            }
        };
    });
    app.directive('slideable', function () {
        return {
            restrict:'C',
            compile: function (element, attr) {
                // wrap tag
                var contents = element.html();
                element.html('<div class="slideable_content" style="margin:0 !important; padding:0 !important" >' + contents + '</div>');

                return function postLink(scope, element, attrs) {
                    // default properties
                    attrs.duration = (!attrs.duration) ? '.3s' : attrs.duration;
                    attrs.easing = (!attrs.easing) ? 'ease-in-out' : attrs.easing;
                    element.css({
                        'overflow': 'hidden',
                        'height': '0px',
                        'transitionProperty': 'height',
                        'transitionDuration': attrs.duration,
                        'transitionTimingFunction': attrs.easing
                    });
                };
            }
        };
    });
    app.directive('slideToggle', function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                var target = document.querySelector(attrs.slideToggle);
                attrs.expanded = false;
                element.bind('click', function() {
                    var content = target.querySelector('.slideable_content');
                    if(!attrs.expanded) {
                        content.style.border = '1px solid rgba(0,0,0,0)';
                        var y = content.clientHeight;
                        content.style.border = 0;
                        target.style.height = y + 'px';
                    } else {
                        target.style.height = '0px';
                    }
                    attrs.expanded = !attrs.expanded;
                });
            }
        }
    });
    app.directive('img', function () {
        return {
            restrict: 'E',
            link: function (scope, element, attrs) {
                element.error(function () {
                    element.prop('src', '/images/no-img.png');
                });
            }
        }
    });

})();