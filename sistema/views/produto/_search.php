<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProdutoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ordensdeservico_id') ?>

    <?= $form->field($model, 'numero') ?>

    <?= $form->field($model, 'datacadastro') ?>

    <?= $form->field($model, 'dataedicao') ?>

    <?php // echo $form->field($model, 'data_validade') ?>

    <?php // echo $form->field($model, 'data_renovacao') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'empreendimento_id') ?>

    <?php // echo $form->field($model, 'fase') ?>

    <?php // echo $form->field($model, 'produto_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
