<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\models\Attempt $model */

$this->title = 'Create Attempt';
$this->params['breadcrumbs'][] = ['label' => 'Attempts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attempt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
