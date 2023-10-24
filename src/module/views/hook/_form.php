<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\models\Hook $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="hook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'events')->checkboxList($model->allEvents()) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
