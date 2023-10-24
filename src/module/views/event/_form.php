<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\models\Event $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="event-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="w-50">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
