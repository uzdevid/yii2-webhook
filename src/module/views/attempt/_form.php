<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\models\Attempt $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="attempt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hook_id')->textInput() ?>

    <?= $form->field($model, 'attempt')->textInput() ?>

    <?= $form->field($model, 'event_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'event_time')->textInput() ?>

    <?= $form->field($model, 'payload')->textInput() ?>

    <?= $form->field($model, 'response')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
