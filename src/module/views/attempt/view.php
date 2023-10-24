<?php

use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\models\Attempt $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attempts', 'url' => ['index']];
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
                        <a class="nav-link" href="/webhook/hook/index">Hooks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/webhook/event/index">Events</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container-fluid">
    <div class="attempt-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
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
            ],
        ]) ?>
    </div>

    <h3>Payload:</h3>
    <div id="payload">
        <?php echo json_encode($model->payload, JSON_UNESCAPED_UNICODE) ?>
    </div>

    <hr>

    <h4>Response body</h4>
    <div id="response">
        <?php echo base64_decode($model->response); ?>
    </div>
</div>
