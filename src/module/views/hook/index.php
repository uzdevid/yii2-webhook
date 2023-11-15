<?php

use uzdevid\webhook\models\Hook;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\temp\HookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Hooks';
$this->params['breadcrumbs'][] = $this->title;
?>

<header class="mb-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo Url::toRoute(['/webhook']); ?>">WebHook</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Url::toRoute(['/webhook/attempt/index']); ?>">Attempts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo Url::toRoute(['/webhook/hook/index']); ?>">Hooks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Url::toRoute(['/webhook/event/index']); ?>">Events</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container-fluid">
    <div class="hook-index">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Hook', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'url',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Hook $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>