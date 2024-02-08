<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Impacto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="impacto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contrato_id')->textInput() ?>

    <?= $form->field($model, 'produto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'servico')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'numeroitem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <?= $form->field($model, 'unidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantidade_a')->textInput() ?>

    <?= $form->field($model, 'quantidade_utilizada')->textInput() ?>

    <?= $form->field($model, 'qt_restante_real')->textInput() ?>

    <?= $form->field($model, 'qt_restante')->textInput() ?>

    <?= $form->field($model, 'preco_unitario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custos_diretos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custos_indiretos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custo_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custo_utilizado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo_restante')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custo_real')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
