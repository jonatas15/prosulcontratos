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
    'title' => "Nova Fase",
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
    <?php
        $fases_padrao = '<div class="row">';
        $fases_padrao_lai = '<div class="row">';
        $fases_padrao_lap = '<div class="row">';
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
            switch ($fase->natureza) {
                case 'Geral': $fases_padrao .= $fase_da_vez; break;
                case 'LAI': $fases_padrao_lai .= $fase_da_vez; break;
                case 'LAP': $fases_padrao_lap .= $fase_da_vez; break;
            }
            // echo $fase_da_vez;
        ?>
    <?php endforeach; ?>
    <?php 
        $fases_padrao .= '</div>';
        $fases_padrao_lai .= '</div>';
        $fases_padrao_lap .= '</div>';
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
            Fases: Padrão LAI
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
            Fases: Padrão LAP
        </button>
        </h2>
        <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <?=$fases_padrao_lap?>
        </div>
        </div>
    </div>
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