<?php

namespace uzdevid\webhook\module\controllers;

use uzdevid\webhook\search\AttemptSearch;

class DefaultController extends \yii\web\Controller {
    public function actionIndex() {
        return $this->render('index');
    }
}