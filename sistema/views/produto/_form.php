<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Empreendimento;
use app\models\Ordensdeservico;


/** @var yii\web\View $this */
/** @var app\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */

$empreendimentos = ArrayHelper::map(Empreendimento::find()->all(), 'id', 'titulo');
$ordensdeservico = ArrayHelper::map(Ordensdeservico::find()->all(), 'id', 'titulo');

$model->data_validade = $model->data_validade != '' ? date('d/m/Y', strtotime($model->data_validade)) : '';
$model->data_renovacao = $model->data_renovacao != '' ? date('d/m/Y', strtotime($model->data_renovacao)) : '';
$model->data_entrega = $model->data_entrega != '' ? date('d/m/Y', strtotime($model->data_entrega)) : '';
$model->aprov_data = $model->aprov_data != '' ? date('d/m/Y', strtotime($model->aprov_data)) : '';

?>

<div class="produto-form">
    
    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->homeUrl.$action
    ]); ?>
    <div class="row">
        <div class="col-md-12"><br><br></div>
        <div class="col-md-12"><?= $form->field($model, 'subproduto')->textInput() ?></div>
        <div class="col-md-4"><?= $form->field($model, 'empreendimento_id')->dropDownList($empreendimentos, [
            'prompt' => 'Selecione'
        ])->label('Empreendimentos Cadastrados') ?></div>
        <div class="col-md-4"><?= $form->field($model, 'ordensdeservico_id')->dropDownList($ordensdeservico, [
            'prompt' => 'Selecione'
        ])->label('Ordens de Serviço Cadastradas') ?></div>
        <div class="col-md-4"><?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?></div>
        <!-- <div class="col-md-6"><?php //= $form->field($model, 'datacadastro')->textInput() ?></div> -->
        <div class="col-md-3"><?= $form->field($model, 'data_validade')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'data_renovacao')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'data_entrega')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'fase')->dropDownList([
            'Em andamento' => 'Em andamento',
            'Aprovado' => 'Aprovado',
            'Reprovado' => 'Reprovado',
        ]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'entrega')->textInput() ?></div>
        <div class="col-md-12"><?= $form->field($model, 'servico')->textInput() ?></div>
        <div class="col-md-12"><?= $form->field($model, 'descricao')->textInput() ?></div>
        <div class="col-md-4"><?= $form->field($model, 'aprov_data')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'aprov_tempo_ultima_revisao')->textInput([
            'type' => 'number'
        ]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'aprov_tempo_total')->textInput([
            'type' => 'number'
        ]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'aprov_versao')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'diretorio_texto')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'diretorio_link')->textInput() ?></div>
        <div class="col-md-12"><?= $form->field($model, 'produto_id')->hiddenInput()->label(false) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'contrato_id')->hiddenInput([
            'value' => $contrato_id
        ])->label(false) ?></div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Salvar Alterações', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
