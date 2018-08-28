(function($) {
  var circle = $('.circle');
  circle.circleProgress({
    startAngle: -Math.PI / 4 * 3,
    value: 0,
    lineCap: 'round',
    fill: {color: '#00aeef'}
  }).on('circle-animation-progress', function(event, progress, stepValue) {
    $(this).find('strong').html((stepValue*60).toFixed(2) + '<i>kW</i>');
  });
})(jQuery);