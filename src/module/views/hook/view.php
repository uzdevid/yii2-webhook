<?php

use uzdevid\webhook\models\Hook;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\models\Hook $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<header class="mb-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/webhook">WebHook</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/webhook/attempt/index">Attempts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/webhook/hook/index">Hooks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/webhook/event/index">Events</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container-fluid">
    <div class="hook-view">
        <h1><?= Html::encode($model->url) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'url:url',
                'auth',
                [
                    'attribute' => 'events',
                    'value' => function (Hook $model) {
                        return implode(', ', ArrayHelper::getColumn($model->hookEvents, 'event.name'));
                    }
                ]
            ],
        ]) ?>
    </div>
</div>