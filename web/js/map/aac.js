/**
 * Created by Awsaf on 11/17/2016.
 */



(function(window) {
    var aac = {
        gMap: null,
        pano: null,
        allPanels: [],
        allOverlays: [],
        panelCounts: [],
        drawingManager: '',
        totalPanel: 0,
        maps: null,
        activeId: -1,
        selectingArr: false,
        transparency: false
    };

    aac.setMap = function(element, opts, dopts) {
        this.gMap = new google.maps.Map(element, opts);
        if (!google.maps.Polygon.prototype.getBounds) {
            google.maps.Polygon.prototype.getBounds = function () {
                var bounds = new google.maps.LatLngBounds();
                this.getPath().forEach(function (element) {
                    bounds.extend(element);
                });
                return bounds;
            };
        }
        this.drawingManager = new google.maps.drawing.DrawingManager(dopts);

        this.pano = new google.maps.StreetViewPanorama(
            document.getElementById('pano'), {
                position: {
                    lat: opts.center.lat,
                    lng: opts.center.lng
                },
                pov: {
                    heading: 34,
                    pitch: 10
                }
            });

        var controlDiv = document.createElement('div');
        new MapControls(controlDiv);

        controlDiv.index = 1;
        this.gMap.controls[google.maps.ControlPosition.LEFT_TOP].push(controlDiv);
    };
    aac.redraw = function(layout) {
        layout.forEach(function (l, i) {
             console.log(IO.OUT(l.overlay));
        });
    };
    aac.getAvailablePanel = function() {
        var maxPanel = Math.ceil(parseFloat($("#s2_txt_system_size").val()) * 1000 / config.moduleWatt);
        return maxPanel - config.totalPanel;
    };
    aac.updatePanels = function(count) {
        this.panelCounts[this.activeId] = count;
        var a = 0;
        this.panelCounts.forEach(function(v) {
            a = a + v;
        });
        setTimeout(function(){
            if (document.getElementById('total_watts')) {
                document.getElementById('total_watts').textContent = parseFloat(a * config.moduleWatt / 1000).toFixed(2)  + "kW";
            }
            config.totalPanel = a;
        }, 0);
    }
    window.aac = aac;
}(window));