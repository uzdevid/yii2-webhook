<?php

use uzdevid\webhook\models\Attempt;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\search\AttemptSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Attempts';
$this->params['breadcrumbs'][] = $this->title;
?>

<header class="mb-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo Url::toRoute(['/webhook']); ?>">WebHook</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo Url::toRoute(['/webhook/attempt/index']); ?>">Attempts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Url::toRoute(['/webhook/hook/index']); ?>">Hooks</a>
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
    <div class="attempt-index">
        <?php Pjax::begin(); ?>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <h2><?= Html::encode($this->title) ?></h2>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'pager' => [
                    'class' => LinkPager::class,
                    'maxButtonCount' => 15,
                    'options' => [
                        'tag' => 'ul',
                        'class' => 'pagination justify-content-center',
                    ],
                    'linkContainerOptions' => [
                        'tag' => 'li',
                        'class' => 'page-item'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    'disabledPageCssClass' => [
                        'class' => 'page-link'
                    ],
                    'disableCurrentPageButton' => true,
                ],
                'rowOptions' => static function ($model) use ($searchModel) {
                    return $searchModel->rowOptions($model);
                },
                'columns' => [
                    'id',
                    'hook_id',
                    'job_id',
                    'attempt',
                    'method',
                    'url:url',
                    'event_name',
                    'event_time',
                    'status',
                    'create_time',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{view}',
                        'buttons' => [
                            'view' => static function ($url, Attempt $model, $key) {
                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => 'View',
                                    'data-loader' => 'disable'
                                ]);
                            },
                        ],
                        'contentOptions' => ['class' => 'text-end', 'style' => 'width: 100px'],
                        'urlCreator' => static function ($action, Attempt $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>