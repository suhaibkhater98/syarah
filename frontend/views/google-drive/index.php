<?php

/** @var yii\web\View $this */

use yii\console\widgets\Table;

$this->title = 'Google Drive Index';
?>

<div class="container">
    <div>
        <h1>Google Drive</h1>
    </div>

    <table>
        <thead>
        <tr>
            <th>title</th>
            <th>thumbnailLink</th>
            <th>EmbedLink (Download) Link</th>
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
        echo '<td>'.(isset($item['thumbnailLink']) ?  '<img src="'.$item['thumbnailLink'].'" alt="">' :'').'</td>';
        echo '<td>'.'<a href="'.$item['embedLink'].'" download>Download</a>'.'</td>';
        echo '<td>'.date("Y-m-d", strtotime($item['modifiedDate'])).'</td>';
        echo '<td>'.(isset($item['fileSize']) ? round($item['fileSize'] / 1024 / 1024,2) . 'MB' : '').'</td>';
        echo '<td>'.($item['ownerNames'][0] ?? '').'</td>';
        echo '</tr>';
    }
    ?>
        </tbody>
    </table>
</div>
