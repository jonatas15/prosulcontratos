<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Fase $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fase-form">

    <?php $form = ActiveForm::begin([
        'action' => $action
    ]); ?>

    <?= $form->field($model, 'empreendimento_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'licenciamento_id')->hiddenInput(['value' => $licenciamento_id])->label(false); ?>

    <?= $form->field($model, 'fase')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textInput()->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
    ]); ?>

    <?= $form->field($model, 'exigencias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ambito')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        'Pendente' => 'Pendente',
        'Em andamento' => 'Em andamento',
        'Concluído' => 'Concluído',
    ], ['prompt' => 'Selecione']) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
