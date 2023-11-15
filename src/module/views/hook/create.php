<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var uzdevid\webhook\models\Hook $model */

$this->title = 'Create Hook';
$this->params['breadcrumbs'][] = ['label' => 'Hooks', 'url' => ['index']];
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
    <div class="hook-create">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>