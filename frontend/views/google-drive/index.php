<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Google Drive Index';
?>

<div class="container">
    <div>
        <h1>Google Drive</h1>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>title</th>
            <th>thumbnailLink</th>
            <th>Download Link</th>
            <th>modifiedDate</th>
            <th>FileSize (MB)</th>
            <th>ownerNames</th>
        </tr>
        </thead>
        <tbody>
    <?php
    foreach ($data['items'] as $item) {
        echo '<tr>';
        echo '<td>'.$item['title'].'</td>';
        echo '<td>'.(isset($item['thumbnailLink']) ? Html::img($item['thumbnailLink']) :'').'</td>';
        echo '<td>'.Html::a('Download', $item['embedLink']).'</td>';
        echo '<td>'.date("Y-m-d", strtotime($item['modifiedDate'])).'</td>';
        echo '<td>'.(isset($item['fileSize']) ? round($item['fileSize'] / 1024 / 1024,2) . 'MB' : '').'</td>';
        echo '<td>'.($item['ownerNames'][0] ?? '').'</td>';
        echo '</tr>';
    }
    ?>
        </tbody>
    </table>
    <center>
        <?= isset($data['nextLink']) ? Html::a('Next', Url::current(['nextLink' => $data['nextLink']]), ['class' => 'btn btn-primary'])
            :
            Html::a('Start From Begin', Url::current(['nextLink' => 'https://www.googleapis.com/drive/v2/files?maxResults=5' ]), ['class' => 'btn btn-primary'])
        ?>
    </center>
</div>
