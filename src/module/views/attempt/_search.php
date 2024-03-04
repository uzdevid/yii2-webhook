<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\search\AttemptSearch $model */
/** @var yii\widgets\ActiveForm $form */

$activeAccordion = isset($_GET['AttemptSearch']);
?>

<div class="accordion mb-5" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button <?php echo $activeAccordion ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#filter" aria-expanded="true" aria-controls="collapseOne">
                Filter
            </button>
        </h2>
        <div id="filter" class="accordion-collapse collapse <?php echo $activeAccordion ? 'show' : ''; ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="post-search">

                    <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                    ]); ?>

                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col">
                                    <?php echo $form->field($model, 'id', ['options' => ['class' => 'mb-3']]) ?>
                                </div>
                                <div class="col">
                                    <?php echo $form->field($model, 'hook_id', ['options' => ['class' => 'mb-3']]) ?>
                                </div>
                                <div class="col">
                                    <?php echo $form->field($model, 'job_id', ['options' => ['class' => 'mb-3']]) ?>
                                </div>
                            </div>

                            <?php echo $form->field($model, 'url', ['options' => ['class' => 'mb-3']])->textInput(); ?>

                            <?php echo $form->field($model, 'event_name', ['options' => ['class' => 'mb-3']]) ?>

                            <div class="row">
                                <div class="col">
                                    <?php echo $form->field($model, 'event_time_from', ['options' => ['class' => 'mb-3']])->textInput(['type' => 'datetime-local']); ?>
                                </div>
                                <div class="col">
                                    <?php echo $form->field($model, 'event_time_to', ['options' => ['class' => 'mb-3']])->textInput(['type' => 'datetime-local']); ?>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <?php echo $form->field($model, 'property_name', ['options' => ['class' => 'mb-3']]); ?>
                                </div>
                                <div class="col">
                                    <?php echo $form->field($model, 'property_value', ['options' => ['class' => 'mb-3']]); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
