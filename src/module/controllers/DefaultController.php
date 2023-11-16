<?php

namespace uzdevid\webhook\module\controllers;

use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller {
    public function actionIndex(): Response {
        return $this->redirect(['/webhook/attempt/index']);
    }
}