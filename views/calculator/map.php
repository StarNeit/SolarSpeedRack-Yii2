<?php
/**
 * Created by PhpStorm.
 * User: Awsaf
 * Date: 11/17/2016
 * Time: 12:01 AM
 */

use app\assets\GoogleToolAsset;

$this->title = "BOM Calculator";

GoogleToolAsset::register($this);
?>
<span style="display: block;height: 80px;"></span>
<div class="intro section calculator">
    <div class="container">
        <div class="place">
            <aside class="place__sidebar">
                <div id="pano"></div>
                <div class="place__roof">
                    <h2 class="place__title">Roof Selection</h2> 
                    <div class="place__roof-selection">
                        <a href="javascript:return false;" class="place__roof-images">
                            <img src="/img/roof-1.png" alt="Roof 1">
                            <div class="place__roof-name">Metal</div>
                        </a>
                        <a href="javascript:return false;" class="place__roof-images">
                            <img src="/img/roof-2.png" alt="Roof 2">
                            <div class="place__roof-name">Flat</div>
                        </a>
                        <a href="javascript:return false;" class="place__roof-images">
                            <img src="/img/roof-3.png" alt="Roof 3">
                            <div class="place__roof-name">Spanish</div>
                        </a>
                        <a href="javascript:return false;" class="place__roof-images">
                            <img src="/img/roof-4.png" alt="Roof 4">
                            <div class="place__roof-name">Asphalt</div>
                        </a>
                        <a href="javascript:return false;" class="place__roof-images">
                            <img src="/img/roof-5.png" alt="Roof 5">
                            <div class="place__roof-name">Wood</div>
                        </a>
                        <a href="javascript:return false;" class="place__roof-images">
                            <img src="/img/roof-6.png" alt="Roof 6">
                            <div class="place__roof-name">Slate</div>
                        </a>
                    </div>
                    <div class="place__items">
                        <div class="place__item-holder">
                                <span class="place__item-values" id="total_watts">
                                    0kW
                                </span>
                            <p class="place__item-text">
                                AVG monthly kWh
                            </p>
                        </div>
                        <div class="place__item-holder">
                                <span class="place__item-values">
                                    $225
                                </span>
                            <p class="place__item-text">
                                AVG monthly bill
                            </p>
                        </div>
                    </div>

                    <div class="place__items">
                        <div class="place__item-holder">
                                <span class="place__item-values">
                                    90%
                                    <i class="fa fa-pencil-square-o place__item-icon" aria-hidden="true"></i>
                                </span>
                            <p class="place__item-text">
                                % of off set energy
                            </p>
                        </div>
                        <div class="place__item-holder">
                                <span class="place__item-values">
                                    5.5
                                    <i class="fa fa-pencil-square-o place__item-icon place__item-icon_orange" aria-hidden="true"></i>
                                </span>
                            <p class="place__item-text">
                                Peak sun hours
                            </p>
                        </div>
                    </div>
                    <div class="place__tune">
                        <a href="javascript:return false;" class="button" data-toggle="modal" data-target=".tune-modal">Fine Tune Usage</a>
                        <p class="place__tune-text">
                            *Please enter your last years electricity bill and usage for an accurate layout and bill
                        </p>
                    </div>
                    <hr class="place__divider">
                    <h2 class="place__title">Layout Tools</h2>
                    <div class="place__tools">
                        <div class="place__tools-holder">
                            <a href="#" id="add_panel" class="place__tools-items place__tools-items_border">
                                <img src="/img/tool-1.png" alt="Tool 1">
                                <span class="place__tools-text">
                                    Add roof<br> outline
                                </span>
                                <div class="place__popup">Click panles to remove or add where needed</div>
                            </a>
                        </div>
                        <div class="place__tools-holder">
                            <a href="#" id="remove_all" class="place__tools-items">
                                <img src="/img/tool-2.png" alt="Tool 2">
                                    <span class="place__tools-text">
                                        Clear<br> Selection
                                    </span>
                                <div class="place__popup">Click panles to remove or add where needed</div>
                            </a>
                        </div>
                    </div>

                    <div class="place__tools">
                        <div class="place__tools-holder">
                            <a href="javascript:return false;" class="place__tools-items ">
                                <img src="/img/tool-3.png" alt="Tool 3">
                                    <span class="place__tools-text">
                                        Panel<br> Orientation
                                    </span>
                                <div class="place__popup">Click panles to remove or add where needed</div>
                            </a>
                        </div>
                        <div class="place__tools-holder">
                            <a href="#" class="place__tools-items " id="rotate_all">
                                <img src="/img/tool-4.png" alt="Tool 4">
                                    <span class="place__tools-text">
                                        Rotate all
                                    </span>
                                <div class="place__popup">Rotate panels.</div>
                            </a>
                        </div>
                    </div>
                    <div class="button_margin-t">
                        <button type="button" class="button button_margin-t">Save for Later</button>
                        <button type="button" class="button button_green" id="save">Save &amp; Continue</button>
                    </div>
                </div>
            </aside>
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

        options.center.lat = <?= $model->lat ?>;
        options.center.lng = <?= $model->lng ?>;
        aac.setMap(element, options, doptions);
        listenEverything();
    }
</script>
<?php
$this->registerJs("initMap2()");