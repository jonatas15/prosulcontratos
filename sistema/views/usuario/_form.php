<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */

use app\models\UsuarioHasContrato as UhC;
use app\models\UsuarioHasEmpreendimento as UhE;

function tacadiv($col, $conteudo) {
    return "<div class='col-md-$col'>".$conteudo."</div>";
}
?>
<div class="usuario-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <?php if(!$model->isNewRecord): ?>
                <div class="col-md-2 p-2"><img src="/usuarios/<?=$model->foto?>" style="max-height: 100px; max-width: 100%; border-radius: 50px"></div>
                <div class="col-md-10"><h4 class="pt-5"><strong><?=$model->nome?></strong></h4></div>
                <?php endif; ?>
                <?= tacadiv('12', $form->field($model, 'nome')->textInput(['maxlength' => true])) ?>
                <?= tacadiv('12', $form->field($model, 'telefone')->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
                ])) ?>
                <?= tacadiv('12', $form->field($model, 'email')->textInput(['maxlength' => true])) ?>
                <?= tacadiv('12', $form->field($model, 'cpf')->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '999.999.999-99',
                ])) ?>
                <?= tacadiv('12', $form->field($model, 'nivel')->dropDownList([ 
                    'administrador' => 'Administrador', 
                    'gestor' => 'Editor', 
                    'fiscal' => 'Visualizador' 
                ], ['prompt' => ''])) ?>
                <?= tacadiv('12', $form->field($model, 'login')->textInput(['maxlength' => true])) ?>
                <?= tacadiv('12', $form->field($model, 'senha')->textInput(['maxlength' => true])) ?>
                <?= tacadiv('12', $form->field($model, 'imageFile')->fileInput()) ?>
            </div>
        </div>
        <div class="col-md-6">
            <h3 class="control-label summary text-center">Acessos</h3>
            <?php // = $form->field($searchModel, 'status')->dropDownList([ 'Não Resolvido' => 'Não Resolvido', 'Parcialmente Resolvido' => 'Parcialmente Resolvido', 'Em andamento' => 'Em andamento', 'Resolvido' => 'Resolvido', ], ['prompt' => '']);?>
            <?php
                $contratos = \app\models\Contrato::find()->all();
                $formatax = "";
                foreach ($contratos as $contrato) {
                    $contrato_permitido = UhC::find()->where([
                        'usuario_id' => $model->id,
                        'contrato_id' => $contrato->id,
                    ])->one();
                    $checked = '';
                    if(!empty($contrato_permitido)) {
                        $checked = 'checked';
                    }
                    $formatax .= '<label class="fs-4" style="padding:2px" for="contrato_'.$contrato->id.'">
                    <input '.$checked.' class="fs-4" type="checkbox" name="Contrato[]" value="'.$contrato->id.'" style="width:20px;height:20px" id="contrato_'.$contrato->id.'">
                    '.$contrato->titulo.'
                    </label>';
                    $formatax .= "<ul>";
                    $empreendimentos = $contrato->empreendimentos;
                    foreach ($empreendimentos as $emp) {
                        $empreendimento_permitido = UhE::find()->where([
                            'usuario_id' => $model->id,
                            'empreendimento_id' => $emp->id,
                        ])->one();
                        $checked = '';
                        if(!empty($empreendimento_permitido)) {
                            $checked = 'checked';
                        }
                        $formatax .= "<li>";
                        $formatax .= '<label style="padding:2px" for="emp_'.$emp->id.'">
                        <input '.$checked.' type="checkbox" name="Empreendimento[]" value="'.$emp->id.'" style="width:15px;height:15px" id="emp_'.$emp->id.'">
                        '.$emp->titulo.'
                        </label>';
                        $formatax .= "</li>";
                    }
                    $formatax .= "</ul>";
                }
                echo $formatax;
            
            ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Salvar Usuário', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
