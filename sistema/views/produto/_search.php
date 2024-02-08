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

    <?= $form->field($model, 'produto_id') ?>

    <?= $form->field($model, 'empreendimento_id') ?>

    <?= $form->field($model, 'ordensdeservico_id') ?>

    <?= $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'datacadastro') ?>

    <?php // echo $form->field($model, 'data_validade') ?>

    <?php // echo $form->field($model, 'data_renovacao') ?>

    <?php // echo $form->field($model, 'data_entrega') ?>

    <?php // echo $form->field($model, 'fase') ?>

    <?php // echo $form->field($model, 'entrega') ?>

    <?php // echo $form->field($model, 'servico') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'aprov_data') ?>

    <?php // echo $form->field($model, 'aprov_tempo_ultima_revisao') ?>

    <?php // echo $form->field($model, 'aprov_tempo_total') ?>

    <?php // echo $form->field($model, 'aprov_versao') ?>

    <?php // echo $form->field($model, 'diretorio_texto') ?>

    <?php // echo $form->field($model, 'diretorio_link') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
