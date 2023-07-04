<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <?= $form->field($model, 'empreendimento_id')->textInput() ?>

    <?= $form->field($model, 'ordensdeservico_id')->textInput() ?>

    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datacadastro')->textInput() ?>

    <?= $form->field($model, 'data_validade')->textInput() ?>

    <?= $form->field($model, 'data_renovacao')->textInput() ?>

    <?= $form->field($model, 'data_entrega')->textInput() ?>

    <?= $form->field($model, 'fase')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entrega')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'servico')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'aprov_data')->textInput() ?>

    <?= $form->field($model, 'aprov_tempo_ultima_revisao')->textInput() ?>

    <?= $form->field($model, 'aprov_tempo_total')->textInput() ?>

    <?= $form->field($model, 'aprov_versao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diretorio_texto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diretorio_link')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
