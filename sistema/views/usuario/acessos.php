<?php
    use yii\helpers\Html;
    use yii\bootstrap5\Modal;
    use app\models\UsuarioHasContrato as UhC;
    use app\models\UsuarioHasEmpreendimento as UhE;
?>
<style>
    ul, li {
        list-style-type: none
    }
</style>
<?php
Modal::begin([
    'title' => "Permissões",
    'options' => [
        'id' => 'perms_usuarios_'.$model->id,
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'class' => 'bg-white',
    ],
    'size' => 'modal-md',
    'toggleButton' => [
        'label' => '<i class="bi bi-person"></i>',
        'class' => 'btn btn-info text-white text-center'
    ],
]);
?>
<div class="permissoes">
    <?php
    $contratos = \app\models\Contrato::find()->all();
    $formatax = "";
    foreach ($contratos as $contrato) {
        $contrato_permitido = UhC::find()->where([
            'usuario_id' => $model->id,
            'contrato_id' => $contrato->id,
        ])->one();
        if(!empty($contrato_permitido)) {
            $formatax .= '<label class="fs-4" style="padding:2px">
            '.$contrato->titulo.'
            </label>';
        }
        $formatax .= "<ul>";
        $empreendimentos = $contrato->empreendimentos;
        foreach ($empreendimentos as $emp) {
            $empreendimento_permitido = UhE::find()->where([
                'usuario_id' => $model->id,
                'empreendimento_id' => $emp->id,
            ])->one();
            if(!empty($empreendimento_permitido)) {
                $formatax .= "<li>";
                $formatax .= '<label style="padding:2px">
                '.$emp->titulo.'
                </label>';
                $formatax .= "</li>";
            }
        }
        $formatax .= "</ul>";
    }
    echo $formatax;

    ?>
</div>
<?php Modal::end(); ?>