<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ContratoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contrato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'datacadastro') ?>

    <?= $form->field($model, 'dataupdate') ?>

    <?= $form->field($model, 'icone') ?>

    <?php // echo $form->field($model, 'obs') ?>

    <?php // echo $form->field($model, 'lote') ?>

    <?php // echo $form->field($model, 'objeto') ?>

    <?php // echo $form->field($model, 'num_edital') ?>

    <?php // echo $form->field($model, 'empresa_executora') ?>

    <?php // echo $form->field($model, 'data_assinatura') ?>

    <?php // echo $form->field($model, 'data_final') ?>

    <?php // echo $form->field($model, 'saldo_prazo') ?>

    <?php // echo $form->field($model, 'valor_total') ?>

    <?php // echo $form->field($model, 'valor_faturado') ?>

    <?php // echo $form->field($model, 'saldo_contrato') ?>

    <?php // echo $form->field($model, 'valor_empenhado') ?>

    <?php // echo $form->field($model, 'saldo_empenho') ?>

    <?php // echo $form->field($model, 'data_base') ?>

    <?php // echo $form->field($model, 'vigencia') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
