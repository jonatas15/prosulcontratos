<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\FaseSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'empreendimento_id') ?>

    <?= $form->field($model, 'licenciamento_id') ?>

    <?= $form->field($model, 'fase') ?>

    <?= $form->field($model, 'datacadastro') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'exigencias') ?>

    <?php // echo $form->field($model, 'ambito') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
