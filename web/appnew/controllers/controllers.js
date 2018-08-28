/* 
 * Author: Awsaf Anam Chowdhury
 */
(function(){
    "use strict";
    var app = angular
                .module('solarApp')
                .controller('designCtrl', ['$scope', '$state', "$stateParams", 'ProjectService',  "ConfigService", "$http", DesignCtrl])
                .controller('PrintCtrl', ['$scope', '$timeout', '$window', '$state', "$stateParams", 'ProjectService',  "ConfigService", PrintCtrl])
                .controller('StoreCtrl', ['$scope', '$state', '$http', '$timeout', 'ConfigService', StoreCtrl]);


    function StoreCtrl ($scope, $state, $http, $timeout, config) {
        $scope.products = [];
        $scope.closeSelector = function () {
            $state.go('project');
        }

        $scope.sorter = '';
        $scope.orderArr = function() {
            return ['-order', this.sorter]
        };
        $scope.priceFilter = false;
        $scope.powerFilter = false;
        $scope.ppdFilter = false;

        $scope.powerFilterMin = 0;
        $scope.powerFilterMax = 0;
        $scope.priceFilterMin = 0;
        $scope.priceFilterMax = 0;
        $scope.ppdFilterMin = 0;
        $scope.ppdFilterMax = 0;

        $scope.powerSlider = {
            min: this.powerFilterMin,
            max: this.powerFilterMax,
            options: {
                floor: $scope.powerFilterMin,
                ceil: this.powerFilterMax,
                hideLimitLabels: true,
                translate: function (value) {
                    return value + ' W';
                }
            }
        };
        $scope.priceSlider = {
            min: this.priceFilterMin,
            max: this.priceFilterMax,
            options: {
                step: .01,
                precision: 2,
                floor: this.priceFilterMin,
                ceil: this.priceFilterMax,
                hideLimitLabels: true,
                translate: function (value) {
                    return '$' + value;
                }
            }
        };

        $scope.ppdSlider = {
            min: this.ppdFilterMin,
            max: this.ppdFilterMax,
            options: {
                floor: this.ppdFilterMin,
                ceil: this.ppdFilterMax,
                hideLimitLabels: true,
                step: .01,
                precision: 2,
                translate: function (value) {
                    return '$' + value;
                }
            }
        };
        $scope.onSale = false;

        $scope.noneSelected = function(arr) {
            if(arr && arr.length > 0) {
                for (var i in arr) {
                    if (arr[i]) {
                        return false;
                    }
                }
                return true;
            } else {
                return true;
            }
        };
        $scope.filterCell = function () {
            return function (p) {
                if($scope.noneSelected($scope.cellTech)) {
                    return true;
                } else {
                    for (var i in $scope.cellTech) {
                        if (p.cell_tech_id == i && $scope.cellTech[i]) {
                            return true;
                        }
                    }
                    return false;
                }
            };
        };
        $scope.filterProduct = function () {
            return function (p) {
                var ret  = true;
                if($scope.onSale) {
                    if(!p.on_sale) {
                        return false;
                    }
                }
                if($scope.powerFilter && ($scope.powerSlider.min > $scope.powerFilterMin || $scope.powerSlider.max < $scope.powerFilterMax)) {
                    if(isNaN(p.rated_power)) {
                        return true;
                    } else {
                        if (p.rated_power >= $scope.powerSlider.min && p.rated_power <= $scope.powerSlider.max) {
                            ret  = true;
                        } else {
                            return false;
                        }
                    }
                }
                if($scope.priceFilter && ($scope.priceSlider.min > $scope.priceFilterMin || $scope.priceSlider.max < $scope.priceFilterMax)) {
                    if (p.priceMax >= $scope.priceSlider.min && p.priceMin <= $scope.priceSlider.max) {
                        ret  = true;
                    } else {
                        return false;
                    }
                }
                if($scope.ppdFilter && ($scope.ppdSlider.min > $scope.ppdFilterMin || $scope.ppdSlider.max < $scope.ppdFilterMax)) {
                    var rp = parseFloat(p.rated_power);
                    if(isNaN(p.rated_power)) {
                        ret  = true;
                    } else {
                        if (get2c(p.priceMax / rp) >= $scope.ppdSlider.min && get2c(p.priceMin / rp) <= $scope.ppdSlider.max) {
                            ret  = true;
                        } else {
                            return false;
                        }
                    }
                }
                if($scope.noneSelected($scope.color)) {
                    ret  = true;
                } else {
                    var found = false;
                    for (var i in $scope.color) {
                        if (p.frame_color == i && $scope.color[i]) {
                            found = true;
                        }
                    }
                    if(!found) {
                        return false;
                    }
                };
                if($scope.noneSelected($scope.manufacturer)) {
                    return true;
                } else {
                    for (var i in $scope.manufacturer) {
                        if (p.manufacturer_id == i && $scope.manufacturer[i]) {
                            return true;
                        }
                    }
                    return false;
                };

                return ret;
            };
        };

        $scope.selectProduct = function(product) {
            var type = $state.params.type;
            config[type + 'Manufacturer'] = product.manufacturer_name;
            config[type + 'Model'] = product.model;
            config[type + 'Prices'] = product.prices;
            config[type + 'Minimum'] = product.minimum;
            config[type + 'Id'] = p(product.id);
            if(type == 'module') {
                config[type + 'Watt'] = pf(product.rated_power);
                config[type + 'Length'] = pf(product.length);
                config[type + 'Width'] = pf(product.width);
                config[type + 'Height'] = pf(product.height);
            } else if (type == 'inverter') {
                this.config[type + 'Watt'] = pf(product.rated_power);
            }

            $scope.$parent[type] = config[type + 'Manufacturer'] + ' ' + config[type + 'Model'];
            config.changed = !config.changed;
            this.closeSelector();
        };
        
        $scope.refreshSlider = function () {
            $timeout(function () {
                $scope.$broadcast('rzSliderForceRender');
            });
        };

        $scope.manufacturer = [];
        $scope.manufacturers = [];
        $scope.colors = [];
        $scope.cellTechs = [];
        $scope.products = [];
        var name = $state.params.type;
        if(name == 'inverter') {
            name += '&itype=' + config.inverterType;
        }
        var root = document.getElementsByTagName('base')[0].getAttribute('href');
        $http.get(root + 'get?alias=list&type='+name).success(function(data) {

            $scope.manufacturers = data.manufacturers;
            $scope.colors = data.colors;
            $scope.cellTechs = data.cellTechs;
            $scope.products = data.products;

            $scope.powerFilter = data.powerFilter;
            $scope.priceFilter = data.priceFilter;
            $scope.ppdFilter = data.ppdFilter;

            $scope.powerFilterMin = 0;
            $scope.powerFilterMax = 0;
            $scope.priceFilterMin = 0;
            $scope.priceFilterMax = 0;
            $scope.ppdFilterMin = 0;
            $scope.ppdFilterMax = 0;

            if($scope.powerFilter) {
                var pow;
                for(var i in $scope.products) {
                    pow = parseFloat($scope.products[i].rated_power);
                    if(!isNaN(pow)) {
                        if($scope.powerFilterMin === 0 && pow > 0) {
                            $scope.powerFilterMin = pow;
                            $scope.powerFilterMax = pow;
                        } else if(pow < $scope.powerFilterMin) {
                            $scope.powerFilterMin = pow;
                        }
                        if(pow > $scope.powerFilterMax) {
                            $scope.powerFilterMax = pow;
                        }
                    }
                }
            }

            if($scope.priceFilter) {
                var priceMin, priceMax;
                for(var i in $scope.products) {
                    priceMin = get2c($scope.products[i].priceMin);
                    priceMax = get2c($scope.products[i].priceMax);
                    if(!isNaN(priceMax)) {

                        if($scope.priceFilterMin === 0 && priceMin > 0) {
                            $scope.priceFilterMin = priceMin;
                        } else if(priceMin < $scope.priceFilterMin) {
                            $scope.priceFilterMin = priceMin;
                        }
                        if(priceMax > $scope.priceFilterMax) {
                            $scope.priceFilterMax = priceMax;
                        }
                    }
                }
            }
            if($scope.ppdFilter) {
                var ppdMin, ppdMax, rp;
                for(var i in $scope.products) {
                    rp = parseFloat($scope.products[i].rated_power);
                    if(rp > 0) {
                        ppdMin = get2c($scope.products[i].priceMin / rp);
                        ppdMax = get2c($scope.products[i].priceMax / rp);

                        if($scope.ppdFilterMin === 0 && ppdMin > 0) {
                            $scope.ppdFilterMin = ppdMin;
                        } else if(ppdMin < $scope.ppdFilterMin) {
                            $scope.ppdFilterMin = ppdMin;
                        }
                        if(ppdMax > $scope.ppdFilterMax) {
                            $scope.ppdFilterMax = ppdMax;
                        }
                    }
                }
            }

            $scope.priceSlider.min = $scope.priceFilterMin;
            $scope.priceSlider.max = $scope.priceFilterMax;
            $scope.ppdSlider.min = $scope.ppdFilterMin;
            $scope.ppdSlider.max = $scope.ppdFilterMax;
            $scope.powerSlider.min = $scope.powerFilterMin;
            $scope.powerSlider.max = $scope.powerFilterMax;

            $scope.priceSlider.options.floor = $scope.priceFilterMin;
            $scope.priceSlider.options.ceil = $scope.priceFilterMax;
            $scope.ppdSlider.options.floor = $scope.ppdFilterMin;
            $scope.ppdSlider.options.ceil = $scope.ppdFilterMax;
            $scope.powerSlider.options.floor = $scope.powerFilterMin;
            $scope.powerSlider.options.ceil = $scope.powerFilterMax;

            for(var i in $scope.manufacturers) {
                $scope.manufacturer[$scope.manufacturers[i].id] = false;
            }
            $scope.refreshSlider();

            $('#product-selector').removeClass('loading');
        });
    }

    function PrintCtrl ($scope, $timeout, $window, $state, $stateParams, Project, ConfigService) {
        $scope.project = Project.get($stateParams.id);
        $scope.config = ConfigService;

        $scope.partFilter = function () {
            return function (p) {
                return $scope.config.requiredParts[p.slug] > 0;
            };
        };

        $scope.selectablePartFilter = function () {
            return function (p) {
                return $scope.config[p+'Id'] > 0;
            };
        };

        $scope.today = new Date();

        $scope.$on('$viewContentLoaded', function(){
            $timeout(function() {
                $window.print();
                $state.go('project', {id: $stateParams.id});
            }, 500);
        });
    }

    function DesignCtrl ($scope, $state, $stateParams, Project, ConfigService, $http) {
        $scope.loading = false;
        $scope.project = Project.get($stateParams.id);
        $scope.config = ConfigService;

        $scope.partFilter = function () {
            return function (p) {
                return $scope.config.requiredParts[p.slug] > 0;
            };
        };

        $scope.selectablePartFilter = function () {
            return function (p) {
                return $scope.config[p+'Id'] > 0;
            };
        };

        $scope.getLocation = function(ev) {
            $('.dark-bg').fadeIn();
            window.navigator.geolocation.getCurrentPosition(function(pos){
                $http.get('https://maps.googleapis.com/maps/api/geocode/json?latlng='+pos.coords.latitude+','+pos.coords.longitude+'&sensor=true').then(function(res){
                    // jQuery("#loader").fadeOut(300);
                    var da = res.data.results[0], zip = 'n';
                    if(da.address_components[da.address_components.length-1].types[0] === 'postal_code') {
                        zip = da.address_components[da.address_components.length-1].long_name;
                    } else if(da.address_components[da.address_components.length-1].types[0] === 'postal_code_suffix') {
                        zip = da.address_components[da.address_components.length-2].long_name;
                    }
                    if (zip.match(/[a-z]/i) || zip.length < 4) {
                        $scope.project.alert(ev, 'Sorry!', 'Zip code could not be found from your location, please type the zip code manually in the box.', 'Ok');
                        return false;
                    } else {
                        $scope.config.zipCode = zip;
                        $scope.getZipData();
                    }
                    $('.dark-bg').fadeOut();
                });
            });
        };

        $scope.zipChanged = function() {
            if(this.config.zipCode && this.config.zipCode.length === 5) {
                this.getZipData();
            }
        };
        $scope.getZipData = function() {
            var z = this.config.zipCode, b= this.project.buildingTypes[this.config.buildingCode].code;
            $http.get("/site/get?alias=zip&z="+z+"&b="+b).success(function(data) {
                if(data.status === 'success') {
                    $scope.config.condition = data.condition;
                    $scope.config.windSpeed = data.wind;
                    $scope.config.snowLoad = data.snow;
                } else {
                    $scope.config.condition = defaults.condition;
                    $scope.config.windSpeed = defaults.windSpeed;
                    $scope.config.snowLoad = defaults.snowLoad;
                }
                $scope.config.setSpan();
            });
        };

        $scope.customize = function () {
            $state.go("project.customizer");
        };

        $scope.setModuleToDefault = function () {
            $state.go("project.customizer");
        };

        $scope.downloadCSV = function(ev){
            if(this.config.id > 0) {
                window.location.pathname = '/files/csv/project-' + this.config.id + '.csv';
            } else {
                this.project.alert(ev, '', 'Please save your project first.', 'Ok');
                return;
            }
        };

        $scope.addToCart = function(ev) {
            $('.dark-bg').show();
            if(!(this.config.id > 0)) {
                this.project.alert(ev, '', 'Please save your project first.', 'Ok');
                return;
            }

            if(this.config.usePP && this.config.ppId > 0) {
                var pp = {
                    ppid : this.config.ppId,
                    projectId : this.config.id,
                    projectName : this.config.name
                };
                var parts = config.getSelectableParts()
                for(var i in parts) {
                    if(parts[i] != 'pp') {
                        pp[parts[i]+'Mfr'] = this.config[parts[i]+'Manufacturer'];
                        pp[parts[i]+'Model'] = this.config[parts[i]+'Model'];
                        pp[parts[i]+'Qty'] = this.config.userParts[parts[i]];
                    }
                }

                var root = document.getElementsByTagName('base')[0].getAttribute('href');
                $.ajax({
                    url: root + 'saveppdata',
                    type: 'post',
                    dataType: 'json',
                    data: pp,
                    success: function(data) {
                        location.pathname = '/store/add-project-to-cart/' + $scope.config.id;
                    }
                });
                $('.dark-bg').hide();
            } else {
                location.pathname = '/store/add-project-to-cart/' + this.config.id;
            }
        };
        $scope.printReport = function(ev) {
            $state.go('print', {id: $stateParams.id});
        };
        $scope.getPart = function(type) {
            return this.config[type + 'Manufacturer'] + ' ' + this.config[type + 'Model'];
        }
        $scope.showDeselect = function(name) {
            if(this.config[name + 'Id'] > 0) {
                return true;
            } else {
                return false;
            }
        };

        $scope.deselect = function(name) {
            this.config[name + 'Id'] = 0;
            this.config[name + 'Manufacturer'] = 'None';
            this.config[name + 'Model'] = '';
            this.config[name + 'Prices'] = [];
        };

        $scope.toArray = function(start, stop, step) {
            return d3.range(start, stop, step);
        };

        $scope.newDesign = function() {
            window.location.href = "/calculator/new";
        };
        $scope.browseAll = function() {
            window.location.href = "/calculator/my-projects";
        };
    };
})();