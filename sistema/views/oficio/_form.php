<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Empreendimento;
use app\models\Oficio;
use kartik\select2\Select2;
use kartik\date\DatePicker;
 

$empreendimentos = ArrayHelper::map(Empreendimento::find()->all(), 'id', 'titulo');

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
/** @var yii\widgets\ActiveForm $form */
function tacadiv($col, $conteudo) {
    return "<div class='col-md-$col'>".$conteudo."</div>";
}
?>

<div class="oficio-form">

    <?php $form = ActiveForm::begin([
        'action' => [$action]
    ]); ?>

    <?= $form->field($model, 'contrato_id')->hiddenInput(['value' => $contrato_id])->label(false) ?>
    <div class="row">
        <?php 
            $arr_tipos = Oficio::find()->select(['tipo'])->groupBy(['tipo'])->all();
            $arr_tipos_select = [];
            foreach($arr_tipos as $tipo) {
                $arr_tipos_select[$tipo->tipo] = $tipo->tipo;
            }
            
            echo tacadiv('4', $form->field($model, 'tipo')->widget(Select2::classname(), [
                'data' => $arr_tipos_select,
                'options' => ['placeholder' => 'Selecione ou cadastre ...'],
                'toggleAllSettings' => [
                ],
                'pluginOptions' => [
                    'selectLabel' => true,
                    'allowClear' => true,
                    'dropdownParent' => '#cadastrar-novo-oficio',
                    'tags' => true
                ],
            ]));
        ?>
        <?php //= tacadiv('4', $form->field($model, 'tipo')->textInput(['maxlength' => true])) ?>
        <?= tacadiv('4', $form->field($model, 'emprrendimento_id')->dropDownList($empreendimentos, [
            'prompt' => 'Selecione'
        ])->label('Empreendimentos Cadastrados')) ?>
        <?= tacadiv('4', $form->field($model, 'emprrendimento_desc')->textInput(['maxlength' => true])) ?>
        <?php //= tacadiv('6', $form->field($model, 'datacadastro')->textInput()) ?>
        <?php 
            $model->data = ($model->data ? $this->context->dataproview2($model->data) : '');
        ?>
        <?= tacadiv('3', $form->field($model, 'data')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Selecione', 'autocomplete'=>"off"],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ])) ?>
        <?php /*= tacadiv('3', $form->field($model, 'data')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
        ]))*/ ?>
        <?php //= tacadiv('3', $form->field($model, 'fluxo')->textInput(['maxlength' => true])) ?>
        <?php 
            $arr_fluxos = Oficio::find()->select(['fluxo'])->groupBy(['fluxo'])->all();
            $arr_fluxos_select = [];
            foreach($arr_fluxos as $fluxo) {
                $arr_fluxos_select[$fluxo->fluxo] = $fluxo->fluxo;
            }
            
            echo tacadiv('3', $form->field($model, 'fluxo')->widget(Select2::classname(), [
                'data' => $arr_fluxos_select,
                'options' => ['placeholder' => 'Selecione ou cadastre ...'],
                'toggleAllSettings' => [
                ],
                'pluginOptions' => [
                    'selectLabel' => true,
                    'allowClear' => true,
                    'dropdownParent' => '#cadastrar-novo-oficio',
                    'tags' => true
                ],
            ]));
        ?>
        <?php //= tacadiv('3', $form->field($model, 'emissor')->textInput(['maxlength' => true])) ?>
        <?php 
            $arr_emissor = Oficio::find()->select(['emissor'])->groupBy(['emissor'])->all();
            $arr_emissor_select = [];
            foreach($arr_emissor as $emissor) {
                $arr_emissor_select[$emissor->emissor] = $emissor->emissor;
            }
            
            echo tacadiv('3', $form->field($model, 'emissor')->widget(Select2::classname(), [
                'data' => $arr_emissor_select,
                'options' => ['placeholder' => 'Selecione ou cadastre ...'],
                'toggleAllSettings' => [
                ],
                'pluginOptions' => [
                    'selectLabel' => true,
                    'allowClear' => true,
                    'dropdownParent' => '#cadastrar-novo-oficio',
                    'tags' => true
                ],
            ]));
        ?>
        <?php //= tacadiv('3', $form->field($model, 'receptor')->textInput(['maxlength' => true])) ?>
        <?php 
            $arr_receptor = Oficio::find()->select(['receptor'])->groupBy(['receptor'])->all();
            $arr_receptor_select = [];
            foreach($arr_receptor as $receptor) {
                $arr_receptor_select[$receptor->receptor] = $receptor->receptor;
            }
            
            echo tacadiv('3', $form->field($model, 'receptor')->widget(Select2::classname(), [
                'data' => $arr_receptor_select,
                'options' => ['placeholder' => 'Selecione ou cadastre ...'],
                'toggleAllSettings' => [
                ],
                'pluginOptions' => [
                    'selectLabel' => true,
                    'allowClear' => true,
                    'dropdownParent' => '#cadastrar-novo-oficio',
                    'tags' => true
                ],
            ]));
        ?>
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
