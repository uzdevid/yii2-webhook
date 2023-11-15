<?php

use uzdevid\webhook\module\assets\BootstrapAsset;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $content string */

BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="none"/>
    <?= Html::csrfMetaTags() ?>
    <title>WebHook Panel | UzDevId</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
