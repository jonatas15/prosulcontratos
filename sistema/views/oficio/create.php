<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = 'Create Oficio';
$this->params['breadcrumbs'][] = ['label' => 'Oficios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oficio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
