<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Empreendimento $model */

$this->title = 'Novo Empreendimento';
$this->params['breadcrumbs'][] = ['label' => 'Contrato 1', 'url' => ['contrato/view?id=1']];
$this->params['breadcrumbs'][] = ['label' => 'Ofício: 154', 'url' => ['contrato/view?id=1&abativa=aba_oficios']];
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empreendimento-create">

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">
        <div class="col-md-8">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
