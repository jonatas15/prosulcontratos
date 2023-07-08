<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$modelRevisao->data = $modelRevisao->data != '' ? date('d/m/Y', strtotime($modelRevisao->data)) : '';
?>
<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
        <?php
        $form = ActiveForm::begin([
            'action' => [
                Yii::$app->homeUrl.'produto/editreview',
                'id' => $id
            ]
        ]); ?>
        <?= $form->field($modelRevisao, 'produto_id')->hiddenInput(['value' => $produto_id])->label(false) ?>
        <div class="row">
            <div class="col-md-12"><?= $form->field($modelRevisao, 'titulo')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-6"><?= $form->field($modelRevisao, 'data')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '99/99/9999',
                'options' => [
                    'id' => 'campodataedicao-'.$modelRevisao->id
                ],
            ]) ?></div>
            <div class="col-md-6"><?= $form->field($modelRevisao, 'tempo_ultima_etapa')->textInput([
                'type' => 'number'
            ]) ?></div>
            <div class="col-md-6"><?= $form->field($modelRevisao, 'responsavel')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-6"><?= $form->field($modelRevisao, 'status')->dropDownList([
                'Em andamento' => 'Em andamento',
                'Aprovado' => 'Aprovado',
                'Reprovado' => 'Reprovado',
            ]) ?></div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Salvar Alterações', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-1 mb-10">
        <br />
        <?= Html::a('X', ['deletereview', 'id' => $modelRevisao->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja realmente excluir a Revisão "'.$modelRevisao->titulo.'"?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
