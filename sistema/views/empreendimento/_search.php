<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EmpreendimentoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="empreendimento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php //= $form->field($model, 'id') ?>
    <?php //= $form->field($model, 'prazo') ?>
    <?php //= $form->field($model, 'datacadastro') ?>
    <?php //= $form->field($model, 'dataupdate') ?>
    <div class="row">
        <div class="col-3"><?= $form->field($model, 'titulo') ?></div>
        <div class="col-2"><?= $form->field($model, 'status') ?></div>
        <div class="col-1"><?= $form->field($model, 'uf') ?></div>
        <div class="col-3"><?= $form->field($model, 'segmento') ?></div>
        <div class="col-3"><?= $form->field($model, 'orgao_licenciador') ?></div>
        <div class="col-3"><?= $form->field($model, 'extensao_km') ?></div>
        <div class="col-3"><?= $form->field($model, 'tipo_obra') ?></div>
        <div class="col-6"><?= $form->field($model, 'municipios_interceptados') ?></div>
    </div>
    <?php // echo $form->field($model, 'ordensdeservico_id') ?>
    <?php // echo $form->field($model, 'oficio_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?php //= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
