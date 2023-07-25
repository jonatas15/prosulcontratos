<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Impacto $model */

$this->title = 'Update Impacto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Impactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="impacto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
