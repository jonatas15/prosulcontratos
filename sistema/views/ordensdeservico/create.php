<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ordensdeservico $model */

$this->title = 'Create Ordensdeservico';
$this->params['breadcrumbs'][] = ['label' => 'Ordensdeservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordensdeservico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
