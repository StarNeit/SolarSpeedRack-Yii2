<?php 
use yii\bootstrap\Html;
$this->title = "Admin Dashborad";
?>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Generate Sitemaps', ['/manage/sitemap/generate'], ['class'=>'btn btn-success']); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <h3>Logged In Members</h3>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        Username
                    </th>
                    <th>
                        Last Active
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                
        <?php foreach ($recentLogins as $m) {
            echo '<tr><td>' . $m['username'] . '</td><td>' . \Yii::$app->formatter->asDatetime($m['last_login']) . '</td><td>' . Html::a('View', ['/user/admin/update', 'id'=>$m['id']]) . '</td>';
                    }
            ?>
            </tbody>
        </table>
    </div>
</div>