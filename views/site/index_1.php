<?php
use app\assets\HomeAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

HomeAsset::register($this);
/* @var $this yii\web\View */

$this->title = 'Oneclicksolar';
?>
<div class="site-index">
    <div class="address-main">
        <div class="text-wrap text-center">
            <h1>All Solar is Local...</h1>
            <h2>SolarNexus provides a second-to-none customer service experience.  The staff is fast and efficient.</h2>
            <?php $form = ActiveForm::begin(['method'=>'get', 'action'=>'/calculator/address', 'options'=>[ 'onsubmit'=>'javascript:return false;', 'id'=>'address-form', 'class'=>'address-form center-block']]) ?>
                <h3>Are you ready to cut the cord?</h3>
                <div class="form-group">
                    <?= Html::textInput('address', '', ['id'=>'address', 'class'=>'form-control', 'placeholder'=>'Your address',
//                        'onFocus' => "geolocate()"
                    ]) ?>
                    <input value="" type="hidden" id="lat" name="lat" />
                    <input value="" type="hidden" id="lng" name="lng" />
                    <input value="" type="hidden" id="zip" name="zip"/>
                </div>
                <?= Html::button('FIND ADDRESS', ['class'=>'btn btn-orange goToTool']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="container">
        <div class="blok-a text-center">
            <h2>THE SOLAR INDUSTRY’S ONLY</h2>
            <h2>BUSINESS OPERATIONS PLATFORM</h2>
            <br>
            <p>
                Are you an independent solar sales and/or installation company that is struggling to manage growing sales opportunities with your current processes and software? Our software gives you a single place to manage leads through project completion. Now you can leverage the same level of sophistication used by the biggest solar companies.
                Join us.
            </p>
        </div>
    </div>
</div>
<script type="text/javascript">
    var placeSearch, autocomplete;
    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById("address"),
            {types: ["geocode"]});

        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {
        var place = autocomplete.getPlace();

        if(place.geometry.location) {
            document.getElementById("lat").value = place.geometry.location.lat();
            document.getElementById("lng").value = place.geometry.location.lng();
        }
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (addressType == 'postal_code') {
                document.getElementById("zip").value = place.address_components[i]['long_name'];
            }
        }
    }
</script>
<?php
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyC15OkDyDw78Zt8T-PfZHdEpjodipGG8FY&libraries=places&callback=initAutocomplete', ['async'=>'', 'defer'=>'']);
$this->registerJs('
    $("#address").keypress(function () {
        $("#lat").val(0);
        $("#lng").val(0);
    });

    $(".goToTool").on("click", function () {
        if($("#lat").val() > 0) {
            $("form#address-form").attr("onsubmit", false).submit();
//            $.post({
//                type: "POST",
//                url: "/calculator/address",
//                data: {
//                    lat: $("#lat").val(),
//                    lng: $("#lng").val(),
//                    address: $("#address").val(),
//                    zip: $("#zip").val(),
//                },
//            })
        } else {
            alert("Please select a valid address");
        }
    });
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }');
?>
</script>

