<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Oficio;
use app\models\Contrato;
use app\models\Ordensdeservico;

/** @var yii\web\View $this */
/** @var app\models\Empreendimento $model */
/** @var yii\widgets\ActiveForm $form */

$oficios = ArrayHelper::map(Oficio::find()->where([
    'tipo' => 'OSE'
])->all(), 'id', 'diretorio');
$contratos = ArrayHelper::map(Contrato::find()->all(), 'id', 'titulo');
$ordensdeservico = ArrayHelper::map(Ordensdeservico::find()->all(), 'id', 'titulo');

?>

<div class="empreendimento-form">

<?php $form = ActiveForm::begin([
        'action' => Yii::$app->homeUrl.$action
    ]); ?>
    <div class="row">
        <div class="col-md-8"><?= $form->field($model, 'titulo')->textInput() ?></div>
        <?php $model->contrato_id = $contrato_id; ?>
        <div class="col-md-4" style="display: block"> <?= $form->field($model, 'contrato_id')->dropDownList($contratos, [
            'prompt' => 'Selecione'
        ]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'ordensdeservico_id')->dropDownList($ordensdeservico, [
            'prompt' => 'Selecione'
        ]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'oficio_id')->dropDownList($oficios, [
            'prompt' => 'Selecione'
        ]) ?></div>
        <?php 
            $model->contrato_id = $contrato_id;
        ?>
        <div class="col-md-4"> <?= $form->field($model, 'prazo')->textInput() ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'status')->dropDownList([
            'Empreendimento' => 'Empreendimento',
            'Ref. Produtos' => 'Ref. Produtos',
        ], [
            'prompt' => 'Selecione'
        ])->label('Categoria') ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'uf')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'segmento')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'extensao_km')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'tipo_obra')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'orgao_licenciador')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'municipios_interceptados')->textInput() ?></div>
        <div class="form-group col-md-12">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success float-right']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
