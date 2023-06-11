<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Contrato $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contrato-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'datacadastro')->textInput() ?>

    <?= $form->field($model, 'dataupdate')->textInput() ?>

    <?= $form->field($model, 'icone')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'obs')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lote')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'objeto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_edital')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'empresa_executora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_assinatura')->textInput() ?>

    <?= $form->field($model, 'data_final')->textInput() ?>

    <?= $form->field($model, 'saldo_prazo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor_faturado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo_contrato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor_empenhado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo_empenho')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_base')->textInput() ?>

    <?= $form->field($model, 'vigencia')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
