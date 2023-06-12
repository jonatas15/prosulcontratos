<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\OrdensdeservicoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ordensdeservico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'oficio_id') ?>

    <?= $form->field($model, 'fase') ?>

    <?= $form->field($model, 'plano') ?>

    <?= $form->field($model, 'contrato_id') ?>

    <?php // echo $form->field($model, 'datacadastro') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
