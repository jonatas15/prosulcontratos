<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ordensdeservico_id')->textInput() ?>

    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datacadastro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataedicao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_validade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_renovacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'empreendimento_id')->textInput() ?>

    <?= $form->field($model, 'fase')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
