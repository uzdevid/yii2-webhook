<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\search\AttemptSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="attempt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hook_id') ?>

    <?php echo $form->field($model, 'method') ?>

    <?php echo $form->field($model, 'url') ?>

    <?= $form->field($model, 'attempt') ?>

    <?= $form->field($model, 'event_name') ?>

    <?= $form->field($model, 'event_time') ?>

    <?php // echo $form->field($model, 'payload') ?>

    <?php // echo $form->field($model, 'response') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
