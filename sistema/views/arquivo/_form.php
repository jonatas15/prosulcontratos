<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/** @var yii\web\View $this */
/** @var app\models\Arquivo $model */
/** @var yii\widgets\ActiveForm $form */

\Yii::$app->language ="pt-BR";

?>

<div class="arquivo-form">

    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->homeUrl.'arquivo/create',
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tipo')->dropDownList([ 'imagem' => 'Imagem', 'logo' => 'Logo', 'video' => 'Video', 'documento' => 'Documento', 'planilia' => 'Planilia', 'outros' => 'Outros', ], ['prompt' => 'Selecione']) ?>
            <?= $form->field($model, 'src')->hiddenInput(['value' => 'arquivos'])->label(false) ?>
            <?php // = $form->field($model, 'contrato_id')->hiddenInput(['value' => $contrato_id])->label(false) ?>
            <?php // = $form->field($model, 'oficio_id')->hiddenInput(['value' => $oficio_id])->label(false) ?>
            <?php // = $form->field($model, 'ordensdeservico_id')->hiddenInput(['value' => $ordensdeservico_id])->label(false) ?>
            <?php // = $form->field($model, 'empreendimento_id')->hiddenInput(['value' => $empreendimento_id])->label(false) ?>
            <?php // = $form->field($model, 'produto_id')->hiddenInput(['value' => $produto_id])->label(false) ?>
            <?php // = $form->field($model, 'licenciamento_id')->hiddenInput(['value' => $licenciamento_id])->label(false) ?>
            <?= $form->field($model, $id_tabela_referencia)->hiddenInput(['value' => $id_valor_referencia])->label(false) ?>
        </div>
        <div class="col-md-6"><?= $form->field($model, 'pasta')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'ref')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12">
            <?php
                echo $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
                    'language' => 'pt-BR',
                    'options' => [
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'previewFileType' => 'any',
                    ]
                ])->label("Subir Arquivos");
            ?>
        </div>
        <div class="col-md-12">
            <div class="form-group float-right">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success float-right']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
