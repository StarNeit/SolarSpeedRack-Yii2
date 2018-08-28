
var app = angular
    .module('solarApp');

app.config(function($stateProvider, $urlRouterProvider, $locationProvider) {

    $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise("/new");

    $stateProvider
        .state('project', {
            url: "/:id",
            templateUrl: "/templates/toolapp/index.html",
            controller: 'designCtrl'
        })
        .state('project.select', {
            templateUrl: "/templates/toolapp/browse.html",
            url: '/select/:type',
            controller: 'StoreCtrl'
        })
        .state('project.bom', {
            url: '/bom',
            templateUrl: "/templates/toolapp/bom.html"
        })
        .state('project.customizer', {
            url: "/customizer",
            templateUrl: "/templates/toolapp/customizer.html"
        })
        .state('print', {
            url: "/:id/print",
            templateUrl: "/templates/toolapp/print.html",
            controller: 'PrintCtrl'
        })
});