<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\OficioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="oficio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'contrato_id') ?>

    <?= $form->field($model, 'emprrendimento_id') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'emprrendimento_desc') ?>

    <?php // echo $form->field($model, 'datacadastro') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'fluxo') ?>

    <?php // echo $form->field($model, 'emissor') ?>

    <?php // echo $form->field($model, 'receptor') ?>

    <?php // echo $form->field($model, 'num_processo') ?>

    <?php // echo $form->field($model, 'num_protocolo') ?>

    <?php // echo $form->field($model, 'Num_sei') ?>

    <?php // echo $form->field($model, 'assunto') ?>

    <?php // echo $form->field($model, 'diretorio') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
