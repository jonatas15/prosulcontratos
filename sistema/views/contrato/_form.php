<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Contrato $model */
/** @var yii\widgets\ActiveForm $form */

// Definição de variáveis
$model->data_assinatura = $model->data_assinatura ? date('d/m/Y', strtotime($model->data_assinatura)) : '';
$model->data_final = $model->data_final ? date('d/m/Y', strtotime($model->data_final)) : '';
$model->data_base = $model->data_base ? date('d/m/Y', strtotime($model->data_base)) : '';
$model->vigencia = $model->vigencia ? date('d/m/Y', strtotime($model->vigencia)) : '';

?>
<style>
    .fundo-evidente {
        background-color: #e9ecef;
    }
</style>
<div class="col-md-12" style="padding: 10px; text-align:center;">
    <button class="btn btn-primary" id="editar-contrato">Editar dados do Contrato</button>
</div>
<div class="contrato-form row"  style="padding: 10px;">

    <?php $form = ActiveForm::begin([
        'options' => [],
        'action' => ['contrato/update?id='.$model->id]
    ]); ?>
    <div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'objeto')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'num_edital')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'empresa_executora')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'data_assinatura')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ]); ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'data_final')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ]); ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'saldo_prazo')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'valor_total')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'valor_faturado')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'saldo_contrato')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'valor_empenhado')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'saldo_empenho')->textInput(['maxlength' => true, 'type' => 'number']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'data_base')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ]); ?>
        
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'vigencia')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ]); ?>
        
    </div>

    <?php //= $form->field($model, 'datacadastro')->textInput() ?>

    <?php //= $form->field($model, 'dataupdate')->textInput() ?>
    <?php //= $form->field($model, 'icone')->textarea(['rows' => 6]) ?>
    
    <div class="col-md-12">
        <?= $form->field($model, 'obs')->textarea(['rows' => 6]) ?>
    </div>
    
    <div class="col-md-12">
        <?= $form->field($model, 'lote')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
        $script = <<< JS
        $('.contrato-form input').attr('disabled', true);
        $('.contrato-form textarea').attr('disabled', true);
        $('.contrato-form button').css({'display': 'none'});
        $('#editar-contrato').on('click', function() {
            $('.contrato-form input').attr('disabled', false);
            $('.contrato-form textarea').attr('disabled', false);
            $('.contrato-form button').css({'display': 'block'});
            $('.contrato-form').toggleClass('fundo-evidente');
        });
        JS;
        $this->registerJs($script);
    ?>
</div>
