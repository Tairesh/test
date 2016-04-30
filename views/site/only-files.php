<?php

use yii\grid\GridView,
    yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $events app\models\LogEvent[] */

$this->title = 'My Yii Application';
?>
<div class="container">
    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $events,
            'sort' => [
                'attributes' => ['i', 'datetime', 'namespace', 'errorType', 'sourceFile', 'message'],
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
            [
                'attribute' => 'sourceFile',
                'value' => function(\app\models\LogEvent $model) {
                    return $model->sourceFile.':'.$model->lineNumber.'<br><pre>'.$model->errorLine.'</pre>';
                },
                'format' => 'raw'
            ],
            'message'
        ],
    ]) ?>
</div>