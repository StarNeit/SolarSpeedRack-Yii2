<?php
/* @var $this yii\web\View */
use app\assets\GoogleToolAsset;

/* @var $profile app\models\Profile */
/* @var $user app\models\User */
/* @var $form ActiveForm */

GoogleToolAsset::register($this);
?>

<div class="container section3 scale_mode">
  <div class="row">
      <div class="col-xs-offset-1 col-xs-4">
<!--          <img src="img/map1.png" style="height:120px; width:100%">-->
          <div id="pano"></div>
          <div class="s3_box1 text-center">
              <h4>Roof Selection</h4>
              <div>
                  <div>
                    <img src="img/roof-1.png">
                    <h6>Metal</h6>
                  </div>
                  <div>
                    <img src="img/roof-2.png">
                    <h6>Flat</h6>
                  </div>
                  <div>
                    <img src="img/roof-3.png">
                    <h6>Spanish</h6>
                  </div>
                  <div>
                    <img src="img/roof-4.png">
                    <h6>Asphalt</h6>
                  </div>
                  <div>
                    <img src="img/roof-5.png">
                    <h6>Wood</h6>
                  </div>
                  <div>
                    <img src="img/roof-6.png">
                    <h6>Slate</h6>
                  </div>
              </div>        
          </div>
          <div class="s3_box2">
              <div class="row">
                  <div class="col-xs-6 text-center">
                      <h4><span id="total_watts">0.0kW</span></h4>
                      <h5>AVG monthly kWh</h5>
                  </div>
                  <div class="col-xs-6 text-center">
                      <h4>$<span id="avg_bill">0</span></h4>
                      <h5>AVG monthly bill</h5>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-6 text-center">
                      <h4>90% <a href="#"><img src="img/btn_edit.png"></a></h4>
                      <h5>% of offset energy</h5>
                  </div>
                  <div class="col-xs-6 text-center">
                      <h4>5.5 <a href="#"><img src="img/btn_edit.png"></a></h4>
                      <h5>Peak sun hours</h5>
                  </div>
              </div>
          </div>
          <div class="s3_box3">
              <div class="row">
                  <div class="col-xs-offset-1 col-xs-5">
                      <h5>Panel Rotation '</h5>
                  </div>
                  <div class="col-xs-6">
                      <div id="protate"></div>
                  </div>
              </div>
          </div>
          <div style="display:flex; justify-content:center">
            <button type="button" class="form-control s3_btn1">Save for Later</button>
          </div>
          <div style="display:flex; justify-content:center">
            <button type="button" class="form-control s3_btn2" id="save">Save and Continue</button>
          </div>

      </div>
      <div class="col-xs-6">
          <div class="place__main map_holder">
              <div id="map_canvas" class=""></div>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
    function initMap2() {
        var aac = window.aac;
        var options = aac.MAP_OPTIONS,
            doptions = aac.DRAWING_OPTIONS,
            element = document.getElementById("map_canvas");

        options.center.lat = 33.696031;
        options.center.lng = -117.900018;
        aac.setMap(element, options, doptions);
        listenEverything();
    }
</script>
<?php
$this->registerJs("initMap2()");
?>