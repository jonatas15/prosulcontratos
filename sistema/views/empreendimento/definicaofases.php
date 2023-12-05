<?php
use kartik\checkbox\CheckboxX;
use kartik\editable\Editable;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
$pluginOptions = [
    'inline'=>false,
    'threeState'=>false,
    'iconChecked'=>'<i class="fas fa-check"></i>',
    'iconUnchecked'=>'<i class="fas fa-minus"></i>'
];
?>
<?php
Modal::begin([
    'title' => "Fases do Licenciamento",
    'options' => [
        'id' => 'gerenciar-fases-em-'.$licenciamento_id,
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'class' => 'bg-white',
    ],
    'size' => 'modal-lg',
    'toggleButton' => [
        'label' => '<i class="bi bi-gear"></i> Fases em '.$licenciamento,
        'class' => 'btn btn-primary text-white float-right'
    ],
]);
?>
<div class="row">
    <div class="col-md-12">
        <div class="row card mx-4 my-3">
            <?= $this->render('add_fases', [
                'licenciamento_id' => $licenciamento_id,
                'orgao' => 'Teste de grupo'
            ]); ?>
        </div>
    </div>
    <?php
        $fases_padrao = '<div class="row">';
        $fases_padrao_lai = '<div class="row">';
        $fases_padrao_lap = '<div class="row">';
        $fases_padrao_funai = '<div class="row">';
        $fases_padrao_incra = '<div class="row">';
        $fases_padrao_iphan = '<div class="row">';
    ?>
    <?php foreach($fases as $fase): ?>
        <?php $fase_da_vez = '<div class="col-md-1">'; ?>
        <?php $fase_da_vez .= CheckboxX::widget([
            'name'=>'s_12_'.$fase->licenciamento_id.'_'.$fase->id, 
            'value' => $fase->ativo,
            'pluginOptions'=> [
                'inline'=>false,
                'threeState'=>false,
                'iconChecked'=>'<i class="fas fa-check"></i>',
                'iconUnchecked'=>'<i class="fas fa-minus"></i>',
                'id' => 's_12_'.$fase->licenciamento_id.'_'.$fase->id
            ],
            // 'initInputType' => CheckboxX::INPUT_CHECKBOX,
            'pluginEvents' => [
                "change"=> 'function() { 
                    console.log("change para: " + this.value);
                    $("#'.'s_label_'.$fase->licenciamento_id.'_'.$fase->id.'").toggleClass("fw-bolder");
                    $.ajax({url: "ativandoetapa", data: {
                        ativo: this.value,
                        fase: "'.($fase->fase).'",
                        fase_id: '.($fase->id).',
                        licenciamento_id: '.($fase->licenciamento_id).'
                    }, success: function(result){
                        console.log(result);
                    }});
                }',
            ]
        ]); ?>
        <?php $fase_da_vez .= "</div>"; ?>
        <?php $fase_da_vez .= "<div class='col-md-9'>
            <label 
            id='s_label_".$fase->licenciamento_id.'_'.$fase->id."'
            for='s_12_".$fase->licenciamento_id.'_'.$fase->id."'
            class='".($fase->ativo ? 'fw-bolder' : '')."'
            >".$fase->fase.
            "</label>
        </div>"; ?>
        <?php $ambito = ''; 
            switch ($fase->ambito) {
                case '1': $bg_ambito = 'bg-success'; $ambito = 'Estadual'; break;
                case '2': $bg_ambito = 'bg-primary'; $ambito = 'Federal'; break;
                case '3': $bg_ambito = 'bg-info'; $ambito = 'FUNAI'; break;
                case '4': $bg_ambito = 'bg-warning'; $ambito = 'INCRA'; break;
                case '5': $bg_ambito = 'bg-danger'; $ambito = 'IPHAN'; break;
            }
        ?>
        <?php if($fase->natureza != "Geral"):?>
        <?php $fase_da_vez .= "<div class='col-md-2'>".
            '<span class="position-relative top-2 start-5 translate-middle badge rounded-pill '.$bg_ambito.' tx-2">
            Órgão '.$ambito.       
            '<span class="visually-hidden">unread messages</span>
            </span>'.
        "</div>"; ?>
        <?php else: ?>
        <?php $fase_da_vez .= '<div class="col-md-2"></div>'; ?>
        <?php endif; ?>
        <?php
            if (!in_array($fase->ambito, ['3','4','5'])) {
                switch ($fase->natureza) {
                    case 'Geral': $fases_padrao .= $fase_da_vez; break;
                    case 'LAI': $fases_padrao_lai .= $fase_da_vez; break;
                    case 'LAP': $fases_padrao_lap .= $fase_da_vez; break;
                }
            } else {
                switch ($fase->ambito) {
                    case '3': $fases_padrao_funai .= $fase_da_vez; break;
                    case '4': $fases_padrao_incra .= $fase_da_vez; break;
                    case '5': $fases_padrao_iphan .= $fase_da_vez; break;
                }
            }
            // echo $fase_da_vez;
        ?>
    <?php endforeach; ?>
    <?php 
        $fases_padrao .= '</div>';
        $fases_padrao_lai .= '</div>';
        $fases_padrao_lap .= '</div>';
        $fases_padrao_funai .= '</div>';
        $fases_padrao_incra .= '</div>';
        $fases_padrao_iphan .= '</div>';
    ?>
    <div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            Fases: Padrão Geral
        </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <?=$fases_padrao?>
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
            Licença Ambiental de Instalação - LAI
        </button>
        </h2>
        <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <?=$fases_padrao_lai?>
        </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
            Licença Ambiental Prévia - LP
        </button>
        </h2>
        <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <?=$fases_padrao_lap?>
        </div>
        </div>
    </div>
    <?= $this->context->grupo_de_fases ('FUNAI', $fases_padrao_funai, 'id_fef_FUNAI'); ?>
    <?= $this->context->grupo_de_fases ('INCRA', $fases_padrao_incra, 'id_fef_INCRA'); ?>
    <?= $this->context->grupo_de_fases ('IPHAN', $fases_padrao_iphan, 'id_fef_IPHAN'); ?>
    <?php 
        $novos_grupos_de_fase = \app\models\Fase::find()->select('ambito')->where([
            'licenciamento_id' => $licenciamento_id
        ])
        ->andFilterWhere(['not', ['ambito' => '0']])
        ->andFilterWhere(['not', ['ambito' => '1']])
        ->andFilterWhere(['not', ['ambito' => '2']])
        ->andFilterWhere(['not', ['ambito' => '3']])
        ->andFilterWhere(['not', ['ambito' => '4']])
        ->andFilterWhere(['not', ['ambito' => '5']])
        ->groupBy('ambito')
        ->all();
        // $novas_fases = \app\models\Fase::find()->where([
        //     'licenciamento_id' => $licenciamento_id
        // ])
        // ->andFilterWhere(['not', ['ambito' => '0']])
        // ->andFilterWhere(['not', ['ambito' => '1']])
        // ->andFilterWhere(['not', ['ambito' => '2']])
        // ->andFilterWhere(['not', ['ambito' => '3']])
        // ->andFilterWhere(['not', ['ambito' => '4']])
        // ->andFilterWhere(['not', ['ambito' => '5']])
        // ->all();
        foreach($novos_grupos_de_fase as $gp) {
            // echo '<br>' . ' => '. $fs->ambito;
            $novas_fases = \app\models\Fase::find()->where([
                'licenciamento_id' => $licenciamento_id,
                'ambito' => $gp->ambito
            ])->all();
            $fases_listando = "";
            foreach ($novas_fases as $fase) {
                $fases_listando .= '<div class="row">';
                $fases_listando .= '<div class="col-md-1">'.
                CheckboxX::widget([
                    'name'=>'s_12_'.$fase->licenciamento_id.'_'.$fase->id, 
                    'value' => $fase->ativo,
                    'pluginOptions'=> [
                        'inline'=>false,
                        'threeState'=>false,
                        'iconChecked'=>'<i class="fas fa-check"></i>',
                        'iconUnchecked'=>'<i class="fas fa-minus"></i>',
                        'id' => 's_12_'.$fase->licenciamento_id.'_'.$fase->id
                    ],
                    // 'initInputType' => CheckboxX::INPUT_CHECKBOX,
                    'pluginEvents' => [
                        "change"=> 'function() { 
                            console.log("change para: " + this.value);
                            $("#'.'s_label_'.$fase->licenciamento_id.'_'.$fase->id.'").toggleClass("fw-bolder");
                            $.ajax({url: "ativandoetapa", data: {
                                ativo: this.value,
                                fase: "'.($fase->fase).'",
                                fase_id: '.($fase->id).',
                                licenciamento_id: '.($fase->licenciamento_id).'
                            }, success: function(result){
                                console.log(result);
                            }});
                        }',
                    ]
                ]).
                "</div>".
                "<div class='col-md-9'>
                            <label 
                            id='s_label_".$fase->licenciamento_id.'_'.$fase->id."'
                            for='s_12_".$fase->licenciamento_id.'_'.$fase->id."'
                            class='".($fase->ativo ? 'fw-bolder' : '')."'
                            >".$fase->fase.
                            "</label>
                        </div>".
                '<div class="col-md-2"></div>';
                $fases_listando .= '</div>';
            }
            echo $this->context->grupo_de_fases ($gp->ambito, $fases_listando, $this->context->limparString($gp->ambito . '_' . $licenciamento_id));
        }
    ?>
    </div>
    <div class="clearfix"><br></div>
    <center>

        <?= Html::button('Atualizar', [
            'class' => 'btn btn-primary w-50',
            'onclick' => 'location.reload()',
        ]) ?>
    </center>
</div>
<?php Modal::end(); ?>