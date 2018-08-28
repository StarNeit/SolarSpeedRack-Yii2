<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\InstallerAsset;

InstallerAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;

//    $clients = [
//        ['id' => 1, 'name' => 'Debbie Talker', 'address' => '123 ABC Rd, Hemit, Ca. 99568',  'lat' => '-33.890542', 'lng' => '151.274856', 'color' => 'green'],
//        ['id' => 2, 'name' => 'David Tagert', 'address' => '345 ABC Rd, Hemit, Ca. 92568', 'lat' => '-33.923036', 'lng' => '151.259052', 'color' => 'yellow'],
//        ['id' => 3, 'name' => 'Mark Hamilton', 'address' => '334 ABC Rd, Hemit, Ca. 99568', 'lat' => '-34.028249', 'lng' => '151.157507', 'color' => 'blue'],
//        ['id' => 4, 'name' => 'Ray Donold', 'address' => '24 ABCs Rd, Hemit, Ca. 92568', 'lat' => '-33.80010128657071', 'lng' => '151.28747820854187', 'color' => 'red']
//    ]

?>
<div class="projects-installer">

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <h4>Projects</h4>
                </div>
            </div>
            <div class="user-content">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Property Address</th>
                        <th>Customer Phone </th>
                        <th>Status</th>
                        <th>Project Size</th>
                        <th>Roof Type</th>
                        <th>Due By</th>
                        <th>Budget</th>
                        <th>Progress</th>
                        <th>Notes</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clients as $item) {?>
                            <tr>
                                <th><a href="<?= \yii\helpers\Url::to(['project-record/view', 'id' => $item->id])  ?>"><?= $item->customer_name_tmp ?></a></th>
                                <td><?= $item->customer_address_tmp ?></td>
                                <td>925-565-5566</td>
                                <td>NEW</td>
                                <th><?= $item->project_size ?></th>
                                <td><?= $item->roof_type ?></td>
                                <td>22.10.2016</td>
                                <td>$476</td>
                                <td><div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30"
                                             aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                            30% Complete
                                        </div>
                                    </div></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row map_wrap">
        <div class="col-md-12">
            <div id="map" style="width:100%;height:420px"></div>
            <div id="menu-widget">
                <div class="inner">
                    <strong class="title">Project Location Map</strong>
                    <ul class="client_list">
                        <?php foreach ($clients as $item){ ?>
                            <li data-cid="<?= $item->id ?>"><img src="http://maps.google.com/mapfiles/ms/icons/<?= $item->color ?>-dot.png"><span><?= $item->customer_name_tmp ?></span></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div id="search-widget">
                <div class="inner">
                    <div class="input-group">
                        <input type="text" class="form-control search-map-inp">
                        <div class="input-group-addon search-map-btn"><span class="search-btn glyphicon glyphicon-search" aria-hidden="true"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var clients = <?php echo json_encode(\yii\helpers\ArrayHelper::toArray($clients)) ?>
</script>
<?php $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDidW4DUhGMwtZ43fmsaBvpD0ZGdS4zunM&callback=initMap', ['depends' => [\app\assets\AppAsset::className()]]) ?>