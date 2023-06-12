<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Licenciamento $model */

$this->title = 'Create Licenciamento';
$this->params['breadcrumbs'][] = ['label' => 'Licenciamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="licenciamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
