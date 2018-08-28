/**
 * Created by Awsaf on 12/28/2016.
 */


$(".dropdown-toggle").dropdown();
if (screen && screen.width > 768) {
    document.write('<script type="text/javascript" src="/js/jquery.fullPage.min.js"><\/script>');
    document.write('<script src="/js/jquery.stellar.min.js"><\/script>');
}


// FULL PAGE //
$(document).ready(function () {
    var pages = ['firstPage', 'secondPage', '3rdPage', '4thPage', '5thPage', '6thPage', '7thPage', '8thPage'];
    if ($.fn.fullpage !== undefined) {
        $('#fullpage').fullpage({
            sectionsColor: ['#fff', '#fff', '#fff', '#fff', '#fff', '#fff'],
            css3: true,
            scrollingSpeed: 1000,
            navigationTooltips: pages,
            showActiveTooltip: true,
            navigation: true,
            navigationPosition: 'right',
            scrollOverflow: true,
            scrollBar: true,
            paddingTop: '60px',
            anchors: pages,
            dragAndMove:false,
            onLeave: function (index, nextIndex, direction) {
                var leavingSection = $(this);

                //after leaving section 2
                if (index == 1 && direction == 'down') {
                    $(".navigation").css("background", "rgba(255,255,255,0.8)");
                    $(".navigation").css("border-bottom", "1px solid #d7d7d7");
                }
            },
            afterRender: function () {
                if ($.fn.stellar !== undefined) {
                    $.stellar();
                }
            }
        });
    }
});
$(window).load(function () {
    $(".header-background-main-image-animate").addClass("expandOpen");
    $(".header-background-image-animate").addClass("slideUp");
    $(".header-background-image-2-animate").addClass("expandOpen");
});

// CIRCLE RANGE SLIDER //
$(document).ready(function () {

    $("#shape").roundSlider({
        // value: 0,
        // radius: 70,
        // sliderType: "min-range",
        // // width: 0,
        min: 0,
        max: 10

    }).on('change', function(slideEvt) {
        getNrelData(slideEvt.value);
    });
});
// RANGE SLIDER //
$("#range-slider").slider({
    // minimum value
    min: 0,
    // max value
    max: 500,
});
function getNrelData(kw) {
    $.get('http://developer.nrel.gov/api/pvwatts/v5.json?api_key=wGWtlgzWefM2g92UYH4Bvj71gX1Vy2pIFATVal6b&module_type=0&losses=14&system_capacity=' + kw +
        '&array_type=1&tilt=20&azimuth=180&lat=' + aac.gMap.center.lat() + '&lon=' + aac.gMap.center.lng(), function (data) {
        var output = data.outputs;
        $('#monthly-kw').text((output.ac_annual / 1000).toFixed(1));
        $('#sun-hour').text(output.solrad_annual.toFixed(1));
    });
}

$("#range-slider").on("slide", function(slideEvt) {
    $("#slider-input").val(slideEvt.value);
    $('#monthly-bill').text(slideEvt.value);
});
$("#slider-input").change(function () {
    var v = $(this).val();
    $("#range-slider").val(v);
});

function sliderShapeChanged(e) {
    var options = {
        circleShape: e.value
    };
    if (e.value == "pie") options["startAngle"] = 0;
    else if (e.value == "custom-quarter" || e.value == "custom-half") options["startAngle"] = 45;
    $("#todo__round").roundSlider(options);
}

// ROOF SELECTION //
$(document).on('click', '.place__roof-images', function (e) {
    e.preventDefault();

    $('.place__roof-images').removeClass('active');
    $(this).addClass('active');
});

// PANEL SELECTION //
$(document).on('click', '.control-panel__images', function (e) {
    e.preventDefault();

    $('.control-panel__images').removeClass('active');
    $(this).addClass('active');
});

// MODAL //
$(document).on('hidden.bs.modal', function (event) {
    if ($('.modal:visible').length) {
        $('body').addClass('modal-open');
    }
});

// FINANCE EXPAND BUTTON //
$(document).on('click', '[data-target]', function (e) {
    e.preventDefault();
    var $this = $(this);
    var target_id = $(this).data('target');
    var $target = $(target_id);
    $target.slideToggle();
});


// CONTROL PANEL EXPAND //
$(document).on('click',
    '.control-panel__images',
    function (e) {
        e.preventDefault();
        var $this = $(this);
        var target_id = $this.attr('href');
        var $target = $(target_id);
        $('.control-panel__images').removeClass('active');
        $this.addClass('active');
        $('.panel__hidden').removeClass('active').hide();
        $target.addClass('active').show();
    }
);
$(document).on('mouseenter',
    '.control-panel__cube:not(.active)',
    function (e) {
        e.preventDefault();
        var $this = $(this);
        var target_id = $this.attr('href');
        var $target = $(target_id);
        $('.panel__hidden').hide();
        $target.show();
    }
);
$(document).on('mouseleave',
    '.control-panel__cube:not(.active)',
    function (e) {
        e.preventDefault();
        var $this = $(this);
        var target_id = $this.attr('href');
        var $target = $(target_id);
        $target.hide();
        $('.panel__hidden.active').show();
    }
);




// ROOF SELECTION //
$(document).on('click', '.place__roof-images', function (e) {
    e.preventDefault();

    $('.place__roof-images').removeClass('active');
    $(this).addClass('active');
});

// PANEL SELECTION //
$(document).on('click', '.control-panel__images', function (e) {
    e.preventDefault();

    $('.control-panel__images').removeClass('active');
    $(this).addClass('active');
});
