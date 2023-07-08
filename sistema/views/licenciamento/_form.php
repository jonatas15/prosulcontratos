<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Empreendimento;
use app\models\Ordensdeservico;

/** @var yii\web\View $this */
/** @var app\models\Licenciamento $model */
/** @var yii\widgets\ActiveForm $form */

$empreendimentos = ArrayHelper::map(Empreendimento::find()->all(), 'id', 'titulo');
$ordensdeservico = ArrayHelper::map(Ordensdeservico::find()->all(), 'id', 'titulo');

$model->data_validade = $model->data_validade != '' ? date('d/m/Y', strtotime($model->data_validade)) : '';
$model->data_renovacao = $model->data_renovacao != '' ? date('d/m/Y', strtotime($model->data_renovacao)) : '';

?>

<div class="licenciamento-form">

    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->homeUrl.$action
    ]); ?>
    <?= $form->field($model, 'contrato_id')->hiddenInput([
        'value' => $contrato_id
    ])->label(false) ?>
    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'empreendimento_id')->dropDownList($empreendimentos, [
            'prompt' => 'Selecione'
        ])->label('Empreendimentos Cadastrados') ?></div>
        <div class="col-md-4"><?= $form->field($model, 'ordensdeservico_id')->dropDownList($ordensdeservico, [
            'prompt' => 'Selecione'
        ])->label('Ordens de Serviço Cadastradas') ?></div>
        <div class="col-md-2"><?= $form->field($model, 'data_validade')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ]) ?>
        <?= $form->field($model, 'data_renovacao')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ]) ?></div>
        <div class="col-md-10">
            <?= $form->field($model, 'descricao')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
