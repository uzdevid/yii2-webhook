<?php

namespace uzdevid\webhook\module\controllers;

use yii\web\Controller;

class DefaultController extends Controller {
    public function actionIndex() {
        return $this->redirect(['/webhook/attempt/index']);
    }
}