<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\DatetimepickerAsset;
use app\assets\InstallerAsset;

DatetimepickerAsset::register($this);
InstallerAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\ProjectRecord */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Project name';
?>
<div class="project-rec-v row">
    <div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <span class="bold">Installer: </span>
            <div>Atlas Solar</div>
        </div>
        <div class="col-md-4">
            <span class="bold">Deadline:</span>
            <div>15.01.2017</div>
        </div>
        <div class="col-md-4">
            <span class="bold">Highlight Activities</span>
            <div>This Week [18 Jun - 24 Jun]</div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <span class="bold">Address: </span> 123 ABC Rd, Hemit, Ca. 92568
        </div>
        <div class="col-md-6">
            <span class="bold">Installer's Phone: </span>          925-565-5566
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <h4 class="bold">Project Size:</h4>
        </div>
        <div class="col-md-4">
            <h4 class="bold">Project: <span>$149.53/month</span></h4>
        </div>
        <div class="col-md-4">

        </div>
    </div>
    <br>
    <div class="row activity-table">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Activity</th>
                <th>Completed</th>
                <th>% Done</th>
                <th>Progress</th>
                <th>Notes</th>
                <th>Documents</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($model->projectActivitiesInstaller as $item) {?>
                <tr>
                    <th id="<?= $item->id ?>" data-id="<?= $item->id ?>" class="<?= $item->activityList->slug ?>">
                        <a href="#" data-toggle="modal" data-target="#<?= $item->activityList->slug ?>Modal">
                            <?= $item->activityList->name ?>
                        </a>
                    </th>
                    <td><?= date('d.m.Y', $item->completed) ?></td>
                    <td><?= $item->done_percent ?>%</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $item->done_percent ?>"
                                 aria-valuemin="0" aria-valuemax="100" style="width:<?= $item->done_percent ?>%">
                                <?= $item->done_percent ?>% Complete
                            </div>
                        </div>
                    </td>
                    <td><?= $item->notes_installer ?></td>
                    <td><?= $item->document ?></td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#<?= $item->activityList->slug ?>Modal">
                            <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- Modal -->
    <div id="inspectionModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content inspectionModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Inspection Request</h4>
                </div>
                <?php if($data['inspection']->status ==  \app\models\ProjectActivity::INSPECTION_APROVED) { ?>
                    <div class="group">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-8">
                                    <h4><?= $data['inspection']->notes_installer ?></h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-close-inspection" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                <?php } else if($data['inspection']->status ==  \app\models\ProjectActivity::INSPECTION_WAIT_INSTALLER){ ?>
                    <div class="group">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <p><?= $data['inspection']->notes_installer ?></p>
                                    <button data-id="<?= $model->id ?>" data-url="<?= \yii\helpers\Url::to(['message/confirm-inspection-request']) ?>" class="btn btn-success confirm_appoint">Confirm Appointments</button>
                                    <p></p>
                                </div>
                                <div class="col-md-8">
                                    <h4>OR Change Appointments</h4>
                                    <label>Please change date and time for Inspection</label>
                                    <input class="form-control datepicker change_time_inp msg" type="text">
                                    <p class="help-block">Your date/time request will be send to customer.
                                        Customer may approve or change your date/time. You will be notified by the system and email.
                                    </p>
                                    <button class="btn btn-warning change_appoint">Change Appointments</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-close-inspection" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

</div>
