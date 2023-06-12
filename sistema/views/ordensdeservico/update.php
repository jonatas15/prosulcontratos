<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ordensdeservico $model */

$this->title = 'Update Ordensdeservico: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ordensdeservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ordensdeservico-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
