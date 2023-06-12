<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="oficio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contrato_id')->textInput() ?>

    <?= $form->field($model, 'emprrendimento_id')->textInput() ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emprrendimento_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datacadastro')->textInput() ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'fluxo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emissor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receptor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_processo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_protocolo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Num_sei')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'assunto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'diretorio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
