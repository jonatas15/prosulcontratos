<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Arquivo $model */

$this->title = 'Create Arquivo';
$this->params['breadcrumbs'][] = ['label' => 'Arquivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arquivo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
