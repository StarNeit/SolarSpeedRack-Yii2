/* 
 * Author: Awsaf Anam Chowdhury
 */
function p(v) {
    return parseInt(v);
}
function pf(v) {
    return parseFloat(v);
}
function get2(v) {
    return Math.floor(v * 100) / 100;
}
function get2c(v) {
    return Math.ceil(v * 100) / 100;
}
function round5(x) {
    return Math.ceil(x/5)*5;
}
(function(){  
    "use strict";
    var app = angular.module("solarApp", ["ui.router", "ngMaterial",
        // "ui.mask",
        // "ngSanitize",
        "rzModule",
        "uiGmapgoogle-maps",
        "angularUtils.directives.dirPagination"]);

    app.config(function($mdThemingProvider) {
        $mdThemingProvider.definePalette('tool', {
            '50': '#fff',
            '100': '#dcedc8',
            '200': '#c5e1a5',
            '300': '#aed581',
            '400': '#9ccc65',
            '500': '#a6db59',
            '600': '#7cb342',
            '700': '#689f38',
            '800': '#558b2f',
            '900': '#000',
            'A100': '#ccff90',
            'A200': '#b2ff59',
            'A300': '#000',
            'A400': '#76ff03',
            'A500': '#a6db59',
            'A600': '#0072c5',
            'A700': '#64dd17',
            'contrastDefaultColor': 'light',
            'contrastLightColors': '800 900',
            'contrastStrongLightColors': '800 900'
        });
        $mdThemingProvider.theme('default')
            .primaryPalette('tool', {
                'default': '500',
                'hue-2': '50',
                'hue-3': '900'
            })
            .accentPalette('blue', {
                'default': '800',
            });
    });
})();

