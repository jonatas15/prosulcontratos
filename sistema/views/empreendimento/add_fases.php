<?php 
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    
?>
<?php $form = ActiveForm::begin([
    'action' => ['savechecklist']
]); ?>
<?php $model = new \app\models\Fase(); ?>
<?php
    $this->registerJs("
        var valor_id = 1;
        $(document).on('click', '#adicionarCampo', function() {
            valor_id = valor_id + 1;
            var novoCampo = '<div class=\"form-group\">' +
                                '<div class=\"row\">' +
                                '<div class=\"col-md-11\">' +
                                '<input class=\"form-control\" id=\"\" name=\"Fase[' + valor_id + '][fase]\" placeholder=\"Nova fase ' + valor_id + '\" >' +
                                '<input class=\"form-control\" id=\"\" name=\"Fase[' + valor_id + '][licenciamento_id]\" value=\"".$licenciamento_id."\" type=\"hidden\">' +
                                '</div>' +
                                '<div class=\"col-md-1\">' +
                                '<button class=\"btn btn-warning removerCampo\" >x</button>' +
                                '</div>' +
                                '</div>' +
                            '</div>';
            $('#camposExtras').append(novoCampo);
        });
        $(document).on('click', '.removerCampo', function() {
            $(this).parent().parent().remove();
        });
    ");
?>
<div class="row">
    <div class="col-md-12 my-3">
        <?= $form->field($model, 'orgao_grupo')->textInput(['required' => true])->label("<h4>Novo Grupo de Fases</h4>") ?>
    </div>
    <div class="col-md-1">
    </div>
    <div class="col-md-11">
        <?= $form->field($model, '[1]fase')->textInput()->label('Cadastrar Fases:') ?>
        <?= $form->field($model, '[1]licenciamento_id')->hiddenInput(['value' => $licenciamento_id])->label(false) ?>
        <?php //= $form->field($model, '[1]ambito')->hiddenInput(['value' => $orgao])->label(false) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-11" id="camposExtras"></div>
</div>

<!-- Repita conforme necessário -->

<div class="row my-3">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <?= Html::button('Adicionar Campo <i class="fas fa-plus"></i>', ['class' => 'btn btn-success float-right', 'id' => 'adicionarCampo']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <?= Html::submitButton('Salvar Tudo', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
