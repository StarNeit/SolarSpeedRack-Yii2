<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\RenvuAsset;

RenvuAsset::register($this);

$this->title = "Upload Products";
?>
    <?= app\widgets\Alert::widget() ?>

    <hr />

<div class="auto_update_renvo_wrap">
    <h3>Auto update price from http://www.renvu.com</h3>
    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-primary update_prices">Update now</button>
        </div>
        <div class="col-md-1">
            <div class="loader" style="display: none"></div>
        </div>
        <div class="col-md-9">

        </div>
    </div>
    <h4>Update now Status:</h4>
    <pre class="update_now_status"></pre>
    <br>

    <h4>Auto update Logs:</h4>
    <pre style="height: 300px;">
        <?php
            echo file_get_contents(\Yii::getAlias('@webroot') . '/../runtime/logs/renvu/renvu.log');
        ?>
    </pre>
    <br><hr>
</div>
    
    <?php ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data'], 'layout'=>'horizontal']); ?>
            <div class="form-group">
                <div class="col-xs-12">
                    <label>Select a JSON file</label>
                    <?= Html::fileInput('csv', NULL, ['accept'=>'.json']) ?>
                </div>
            </div>
        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
    <p>
        First make sure you are logged in at Renvu.com. On the renvu website press Ctrl+Shift+i and copy the code below in the console. Then come back here and upload the json file.
    </p>
    <pre>
        
var urls = [
            'http://www.renvu.com/PL/Price-List-Modules',
            'http://www.renvu.com/PL/Price-List-String-Inverters',
            'http://www.renvu.com/PL/Price-List-Microinverters',
            'http://www.renvu.com/PL/Price-List-Optimizers',
            'http://www.renvu.com/PL/Price-List-IronRidge',
            'http://www.renvu.com/PL/Price-List-UNIRAC',
            'http://www.renvu.com/PL/Price-List-Connectors-and-Tools',
            'http://www.renvu.com/PL/Price-List-Disconnects-and-Breakers',
            'http://www.renvu.com/PL/Price-List-Hellermann-Tyton-Safety-Labels',
            'http://www.renvu.com/PL/Price-List-PV-Wire',
            'http://www.renvu.com/PL/Price-List-QuickMount',
            'http://www.renvu.com/PL/Price-List-SolaDeck',
            'http://www.renvu.com/PL/Price-List-TROUBLESHOOTING-AND-SITE-ANALYSIS'
        ], output = [];

ExternalFunction(urls);

function ExternalFunction(value1) {
var url = value1.shift();
var url2 = url;
$.get(url, function( data ) {
        var b = [], price = [];
        $(data).find('table.listtable > tbody > tr').each(function(a, v){
            price = [];
            if($(v).find('td:nth-child(6) > table').length > 0) {
                var t = $(v).find('td:nth-child(6) > table tr');
                $(t).each(function(e, p){
                    if($(p).find('.texttable').length > 0) {
                        price.push({
                            qty: $($(p).find('.texttable')[0]).text(),
                            pr: $($(p).find('.texttable')[1]).text()
                        })
                    }
                });
            } else {
                  if($(v).find('td:nth-child(6) > span').length > 0) {
                      price = $(v).find('td:nth-child(6) > span').text();
                  } else {
                      price = $(v).find('td:nth-child(6)').text();
                  }
            }
            b.push({
                cat: $(v).find('td:nth-child(3)').text(),
                model: $(v).find('td:nth-child(4)').text(),
                url: $(v).find('td:nth-child(5)').text(),
                pri: price
            })
        });
        output.push({
            ref: url2,
            data: b
        });
        if(value1.length < 1) {
            var dat = JSON.stringify(output);
            var blob = new Blob([dat], { type: 'text/json;charset=utf-8;' });
            link = document.createElement("a");
            if (link.download !== undefined) { 
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", 'RenvuData.json');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        } else {
            ExternalFunction(value1);
        }
    });
}

    </pre>