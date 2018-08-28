$(function(){

    'use strict';

    $('.datepicker').datetimepicker({
        format: 'd.m.Y H:i'
    });

    var installer = {};

    $('.btn-close-inspection').click(function(){
        location.reload();
    });

    installer.confirm_appoint = function(){

        $('.confirm_appoint').click(function(){
            var url = $(this).data('url');
            var id = $(this).data('id');

            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: {
                    id: id,
                    action: 'confirm_appoint',
                },
                success: function(data){
                    if(data.status == 'success'){
                        $('.modal-body .form-group').html('');
                        $('.inspectionModal .form-group').text('Appointment was confirmed');
                    } else {
                        alert('Error, please contact to administrator');
                    }
                }
            })
        });
    };

    installer.change_appoint = function(){
        $('.change_appoint').click(function(){
            var self = this;
            var id = $('.inspection').data('id');
            var url = $(this).data('url');
            var msg = $('.inspectionModal .msg').val();

            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: {
                    id: id,
                    msg: msg,
                },
                success: function(data){
                    console.log(data);
                    if(data.status == 'success'){
                        $('.inspectionModal .form-group').text('Your request has been sent');
                        $(self).hide();
                    } else {
                        alert('Error, please contact to administrator');
                    }
                }
            })
        });
    };

    installer.confirm_appoint();
});

function initMap() {
    var mapCanvas = document.getElementById("map");
    var markers = {};
    var myLatLng = {lat: parseFloat(clients[0].lat), lng: parseFloat(clients[0].lng)};
    var mapOptions = {
        center: myLatLng,
        zoom: 9,
        mapTypeControlOptions: {
            mapTypeIds: [
                google.maps.MapTypeId.ROADMAP,
                google.maps.MapTypeId.SATELLITE
            ],
            position: google.maps.ControlPosition.BOTTOM_LEFT
        }
    };
    var map = new google.maps.Map(mapCanvas, mapOptions);
    var infowindow = new google.maps.InfoWindow();

    function infoWindowTemplate(client){

        return '<p><strong>' + client.customer_name_tmp + '</strong></p>' +
            '<div>' + client.customer_address_tmp + '</div>' +
            '<div>'+ client.project_size + ' ' + client.roof_type +'</div>' +
            '<div class="inf-lat"><i class="fa fa-map-marker" aria-hidden="true"></i> '+ client.lat + ', ' + client.lng +'</div>';
    };

    //draw markers
    clients.forEach(function(client, i, arr){
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(client.lat),lng: parseFloat(client.lng)},
            map: map,
            title: client.customer_name_tmp,
            icon: 'http://maps.google.com/mapfiles/ms/icons/'+client.color+'-dot.png'
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(infoWindowTemplate(client));
            infowindow.open(map, this);
        });
        markers[client.id] = {marker: marker, markerClient: client};
    });

    //left menu
    var widgetDiv = document.getElementById('menu-widget');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(widgetDiv);

    //left clients map menu
    $('.client_list li').click(function(){
        var cid = $(this).data('cid');
        var marker = markers[cid];

        infowindow.setContent(infoWindowTemplate(marker.markerClient));
        infowindow.open(map, marker.marker);
    });
    //search html block
    var searchWidgetDiv = document.getElementById('search-widget');
    map.controls[google.maps.ControlPosition.TOP].push(searchWidgetDiv);

    $('.search-map-btn').click(function(){
        var val = $('.search-map-inp').val();

        clients.forEach(function(client, i, arr){//todo
            if(client.customer_name_tmp.search(val) !== -1) {
                var marker = markers[client.id];

                infowindow.setContent(infoWindowTemplate(marker.markerClient));
                infowindow.open(map, marker.marker);
            }
        });
    })

}