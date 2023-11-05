<?php
use kartik\checkbox\CheckboxX;
use yii\bootstrap5\Modal;
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
    'size' => 'modal-md',
    'toggleButton' => [
        'label' => '<i class="bi bi-gear"></i> Fases em '.$licenciamento,
        'class' => 'btn btn-primary text-white float-right'
    ],
]);
?>
<div class="row">
<?php foreach($fases as $fase): ?>
    <div class="col-md-12   ">
    <?= CheckboxX::widget([
        'name'=>'s_2_'.$fase->id.'_'.$fase->licenciamento_id,
        'value'=>1,
        'options'=>[
            'id'=>'s_2_'.$fase->id.'_'.$fase->licenciamento_id
        ],
        'initInputType' => CheckboxX::INPUT_CHECKBOX,
        'autoLabel' => true,
        'labelSettings' => [
            'label' => $fase->fase. ' - '.$fase->ambito,
            'position' => CheckboxX::LABEL_RIGHT
        ]
    ]); ?>
    </div>
<?php endforeach; ?>
</div>
<?php Modal::end(); ?>