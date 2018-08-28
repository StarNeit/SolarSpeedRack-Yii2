$(function(){

    'use strict';

    $('.datepicker').datetimepicker({
        format: 'd.m.Y H:i'
    });

    $('.send_inspection').click(function(){
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

    $('.btn-close-inspection').click(function(){
        location.reload();
    })

});

