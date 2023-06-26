<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */
function tacadiv($col, $conteudo) {
    return "<div class='col-md-$col'>".$conteudo."</div>";
}
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <?= tacadiv('4', $form->field($model, 'nome')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('4', $form->field($model, 'telefone')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
        ])) ?>
        <?= tacadiv('4', $form->field($model, 'email')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('4', $form->field($model, 'cpf')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '999.999.999-99',
        ])) ?>
        <?= tacadiv('4', $form->field($model, 'nivel')->dropDownList([ 'administrador' => 'Administrador', 'gestor' => 'Gestor', 'fiscal' => 'Fiscal', ], ['prompt' => ''])) ?>
        <?= tacadiv('4', $form->field($model, 'login')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('4', $form->field($model, 'senha')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('4', $form->field($model, 'imageFile')->fileInput()) ?>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Salvar Usuário', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
