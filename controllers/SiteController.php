<?php

namespace app\controllers;

use Yii,
    yii\web\Controller,
    app\models\LogEvent,
    yii\data\ArrayDataProvider;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $events = LogEvent::find()->all();
        
        return $this->render('index', [
            'events' => $events
        ]);
    }

    public function actionWithUser()
    {
        $events = LogEvent::find()->withUser()->all();
        
        return $this->render('only-users', [
            'events' => $events
        ]);
    }

    public function actionWithSystem()
    {
        $events = LogEvent::find()->withSystem()->all();
        
        return $this->render('only-files', [
            'events' => $events
        ]);
    }

    public function actionTwoTables()
    {
        $errors = LogEvent::find()->byErrorType('error')->all();
        $warnings = LogEvent::find()->byErrorType('warning')->all();
        
        return $this->render('many-tables', [
            'events' => [
                $errors,
                $warnings
            ]
        ]);
    }
    
}
