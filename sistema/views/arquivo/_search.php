<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ArquivoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="arquivo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'datacadastro') ?>

    <?= $form->field($model, 'src') ?>

    <?= $form->field($model, 'contrato_id') ?>

    <?php // echo $form->field($model, 'oficio_id') ?>

    <?php // echo $form->field($model, 'ordensdeservico_id') ?>

    <?php // echo $form->field($model, 'empreendimento_id') ?>

    <?php // echo $form->field($model, 'produto_id') ?>

    <?php // echo $form->field($model, 'licenciamento_id') ?>

    <?php // echo $form->field($model, 'pasta') ?>

    <?php // echo $form->field($model, 'ref') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
