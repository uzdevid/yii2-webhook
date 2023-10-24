<?php

namespace uzdevid\webhook\module;

use Yii;
use yii\base\Module;
use yii\helpers\Url;

class WebHookModule extends Module {
    public $allowedIPs = ['127.0.0.1', '::1'];
    public $allowedHosts = [];
    public $disableIpRestrictionWarning = false;

    public $controllerNamespace = 'uzdevid\webhook\module\controllers';
    public $layout = 'main';

    private $pageTitle;

    public function init() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        parent::init();
    }

    public function beforeAction($action) {
        return parent::beforeAction($action) && $this->checkAccess($action);
    }

    protected function checkAccess($action = null) {
        $allowed = false;

        $ip = Yii::$app->getRequest()->getUserIP();

        if (in_array('*', $this->allowedIPs)) {
            $allowed = true;
        }

        foreach ($this->allowedIPs as $filter) {
            if (fnmatch($filter, $ip)) {
                $allowed = true;
                break;
            }
        }

        if ($allowed) {
            return true;
        }

        if (!$this->disableIpRestrictionWarning) {
            Yii::warning('Access to webhook is denied due to IP address restriction. The requesting IP address is ' . $ip, __METHOD__);
        }

        return false;
    }

    public function htmlTitle() {
        if (is_string($this->pageTitle) && !empty($this->pageTitle)) {
            return $this->pageTitle;
        }

        if (is_callable($this->pageTitle)) {
            return call_user_func($this->pageTitle, Url::base(true));
        }

        return 'Yii Debugger';
    }
}