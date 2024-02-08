<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ImpactoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="impacto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'contrato_id') ?>

    <?= $form->field($model, 'produto') ?>

    <?= $form->field($model, 'servico') ?>

    <?= $form->field($model, 'numeroitem') ?>

    <?php // echo $form->field($model, 'produto_id') ?>

    <?php // echo $form->field($model, 'unidade') ?>

    <?php // echo $form->field($model, 'quantidade_a') ?>

    <?php // echo $form->field($model, 'quantidade_utilizada') ?>

    <?php // echo $form->field($model, 'qt_restante_real') ?>

    <?php // echo $form->field($model, 'qt_restante') ?>

    <?php // echo $form->field($model, 'preco_unitario') ?>

    <?php // echo $form->field($model, 'custos_diretos') ?>

    <?php // echo $form->field($model, 'custos_indiretos') ?>

    <?php // echo $form->field($model, 'custo_total') ?>

    <?php // echo $form->field($model, 'custo_utilizado') ?>

    <?php // echo $form->field($model, 'saldo_restante') ?>

    <?php // echo $form->field($model, 'custo_real') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
