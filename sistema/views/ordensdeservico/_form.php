<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Empreendimento;
$empreendimentos = ArrayHelper::map(Empreendimento::find()->where([
    'contrato_id' => $contrato_id ? $contrato_id : $model->contrato_id
])->all(), 'id', 'titulo');

/** @var yii\web\View $this */
/** @var app\models\Ordensdeservico $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ordensdeservico-form">

    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->homeUrl.$action
    ]); ?>

    <?= $form->field($model, 'titulo')->textInput() ?>
    <?= $form->field($model, 'numero_sei')->textInput() ?>
    <?= $form->field($model, 'fase')->dropDownList([ 'Manifestação de Interesse em Análise' => 'Manifestação de Interesse em Análise', 'OS Emitida' => 'OS Emitida', 'OS em Andamento' => 'OS em Andamento', 'OS Paralisada' => 'OS Paralisada', 'OS Finalizada' => 'OS Finalizada', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'plano')->dropDownList([ 'Plano de Trabalho Solicitado' => 'Plano de Trabalho Solicitado', 'Plano de Trabalho em Andamento' => 'Plano de Trabalho em Andamento', 'Plano de Trabalho  Entregue DNIT' => 'Plano de Trabalho  Entregue DNIT', 'Plano de Trabalho em Análise DNIT' => 'Plano de Trabalho em Análise DNIT', 'Plano de Trabalho em Revisão' => 'Plano de Trabalho em Revisão', 'Plano de Trabalho Aprovado DNIT' => 'Plano de Trabalho Aprovado DNIT', ], ['prompt' => '']) ?>
    
    <?= $form->field($model, 'oficio_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'empreendimento_id')->dropDownList($empreendimentos, ['prompt' => '']) ?>
    <?= $form->field($model, 'contrato_id')->hiddenInput([
        'value' => $contrato_id ? $contrato_id : $model->contrato_id
    ])->label(false) ?>

    <?php //= $form->field($model, 'datacadastro')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
