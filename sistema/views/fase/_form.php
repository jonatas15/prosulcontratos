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

    <?= $form->field($model, 'empreendimento_id')->textInput() ?>

    <?= $form->field($model, 'licenciamento_id')->textInput(['value' => $licenciamento_id]) ?>

    <?= $form->field($model, 'fase')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'exigencias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ambito')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
