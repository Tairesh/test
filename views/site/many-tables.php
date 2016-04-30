<?php

use yii\grid\GridView,
    yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $events app\models\LogEvent[][] */

$this->title = 'My Yii Application';
?>
<?php foreach ($events as $table): ?>
<div class="container">
    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $table,
            'sort' => [
                'attributes' => ['i', 'datetime', 'namespace', 'errorType', 'userId', 'sourceFile', 'lineNumber', 'message'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            'i',
            'datetime:datetime',
            'namespace',
            'errorType',
            'userId',
            'sourceFile',
            'lineNumber',            
            'message'            
        ],
    ]) ?>
</div>
<?php endforeach ?>