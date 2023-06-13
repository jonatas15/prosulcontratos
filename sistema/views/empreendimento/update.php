<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Empreendimento $model */

$this->title = 'Update Empreendimento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Contrato 1', 'url' => ['view?id=1']];
$this->params['breadcrumbs'][] = ['label' => 'Ofício: 154', 'url' => ['contrato/view?id=1&abativa=aba_oficios']];
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="empreendimento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
