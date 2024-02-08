<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$modelFase->data = $modelFase->data != '' ? date('d/m/Y', strtotime($modelFase->data)) : '';
?>
<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
        <?php
        $form = ActiveForm::begin([
            'action' => [
                Yii::$app->homeUrl.'empreendimento/editfase',
                'id' => $id
            ]
        ]); ?>
        <div class="row">
            <?= $form->field($modelFase, 'empreendimento_id')->hiddenInput(['value' => $modelFase->empreendimento_id])->label(false) ?>
            <div class="col-md-9"><?= $form->field($modelFase, 'fase')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-3"><?= $form->field($modelFase, 'data')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '99/99/9999',
                'options' => [
                    'id' => 'campo-data-empreendimento-'.$modelFase->id
                ]
            ]) ?></div>
            <div class="col-md-6"><?= $form->field($modelFase, 'exigencias')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-6"><?= $form->field($modelFase, 'ambito')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-9"><?= $form->field($modelFase, 'status')->dropDownList([
                'Em andamento' => 'Em andamento',
                'Aprovado' => 'Aprovado',
                'Reprovado' => 'Reprovado',
            ]) ?></div>
            <div class="col-md-3">
                <br />
                <div class="form-group">
                    <?= Html::submitButton('Salvar Alterações', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-1 mb-10">
        <br />
        <?= Html::a('X', ['deletereview', 'id' => $modelFase->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja realmente excluir a Fase "'.$modelFase->fase.'"?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
