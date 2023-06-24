<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Empreendimento;

$empreendimentos = ArrayHelper::map(Empreendimento::find()->all(), 'id', 'segmento');

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
/** @var yii\widgets\ActiveForm $form */
function tacadiv($col, $conteudo) {
    return "<div class='col-md-$col'>".$conteudo."</div>";
}
?>

<div class="oficio-form">

    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->homeUrl.$action
    ]); ?>

    <?= $form->field($model, 'contrato_id')->hiddenInput(['value' => $contrato_id])->label(false) ?>
    <div class="row">
        <?= tacadiv('4', $form->field($model, 'tipo')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('4', $form->field($model, 'emprrendimento_id')->dropDownList($empreendimentos, [
            'prompt' => 'Selecione'
        ])->label('Empreendimentos Cadastrados')) ?>
        <?= tacadiv('4', $form->field($model, 'emprrendimento_desc')->textInput(['maxlength' => true])) ?>
        <?php //= tacadiv('6', $form->field($model, 'datacadastro')->textInput()) ?>
        <?php 
            $model->data = ($model->data ? $this->context->dataproview($model->data) : '');
        ?>
        <?= tacadiv('3', $form->field($model, 'data')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ])) ?>
        <?= tacadiv('3', $form->field($model, 'fluxo')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('3', $form->field($model, 'emissor')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('3', $form->field($model, 'receptor')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('3', $form->field($model, 'num_processo')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('3', $form->field($model, 'num_protocolo')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('3', $form->field($model, 'Num_sei')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('3', $form->field($model, 'status')->dropDownList([
            'Informativo' => 'Informativo',
            'Em Andamento' => 'Em Andamento',
            'Resolvido' => 'Resolvido',
            'Não Resolvido' => 'Não Resolvido',
        ])) ?>
        <?= tacadiv('12', $form->field($model, 'assunto')->textInput()) ?>
        <?= tacadiv('12', $form->field($model, 'diretorio')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('12', $form->field($model, 'link_diretorio')->textInput()) ?>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Salvar', [
                    'class' => 'btn btn-success float-right',
                    'style' => [
                        'width' => '200px'
                    ]
                ]) ?>
            </div>
        </div>


    </div>

    <?php ActiveForm::end(); ?>

</div>
