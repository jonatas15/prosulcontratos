<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Arquivo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="arquivo-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'imagem' => 'Imagem', 'logo' => 'Logo', 'video' => 'Video', 'documento' => 'Documento', 'planilia' => 'Planilia', 'outros' => 'Outros', ], ['prompt' => '']) ?>

    <?php //= $form->field($model, 'datacadastro')->textInput() ?>

    <?= $form->field($model, 'src')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contrato_id')->textInput() ?>

    <?= $form->field($model, 'oficio_id')->textInput() ?>

    <?= $form->field($model, 'ordensdeservico_id')->textInput() ?>

    <?= $form->field($model, 'empreendimento_id')->textInput() ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <?= $form->field($model, 'licenciamento_id')->textInput() ?>

    <?= $form->field($model, 'pasta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
