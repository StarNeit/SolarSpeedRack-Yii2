<?php
/* @var $this yii\web\View */
$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mess-wrap">
    <div class="col-md-12">

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Project</th>
                <th>Notification</th>
                <th>Date/Time</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($model as $item) {?>
                <tr>
                    <th id="<?= $item->id ?>" data-id="<?= $item->id ?>">
                        <a href="<?= \yii\helpers\Url::to(['project-record/view', 'id' => $item->project_id]) ?>">
                            Project link
                        </a>
                    </th>
                    <td><?= $item->message ?></td>
                    <td><?= date('d.m.Y h:m', $item->created_at) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>
