<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Licenciamento $model */

$this->title = 'Update Licenciamento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Licenciamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="licenciamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
