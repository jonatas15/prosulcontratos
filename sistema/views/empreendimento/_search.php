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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prazo') ?>

    <?= $form->field($model, 'datacadastro') ?>

    <?= $form->field($model, 'dataupdate') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'uf') ?>

    <?php // echo $form->field($model, 'segmento') ?>

    <?php // echo $form->field($model, 'extensao_km') ?>

    <?php // echo $form->field($model, 'tipo_obra') ?>

    <?php // echo $form->field($model, 'municipios_interceptados') ?>

    <?php // echo $form->field($model, 'orgao_licenciador') ?>

    <?php // echo $form->field($model, 'ordensdeservico_id') ?>

    <?php // echo $form->field($model, 'oficio_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
