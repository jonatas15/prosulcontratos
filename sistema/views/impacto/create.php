<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Impacto $model */

$this->title = 'Create Impacto';
$this->params['breadcrumbs'][] = ['label' => 'Impactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="impacto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
