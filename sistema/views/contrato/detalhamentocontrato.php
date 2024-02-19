<?php 
use kartik\tabs\TabsX as Tabs;

use app\models\Oficio;
use app\models\Ordensdeservico as Ordens;
use app\models\Produto;

function retorna_uma_sequencia ($funcao) {
    $i = 1;
    $api_contrato_dnit .= '<div class="row">';
    $api_contrato_dnit .= '<div class="col-md-4">';
    $api_contrato_dnit .= '<table class="table table-striped table-bordered">';
    foreach ($funcao as $key => $value) {
        $api_contrato_dnit .= '<tr>';
        $api_contrato_dnit .= "<td><strong>{$value['campo']}</strong></td><td>{$value['valor']}</td>";
        $api_contrato_dnit .= '</tr>';
        if ($i%5==0) {
            $api_contrato_dnit .= '</table>';
            $api_contrato_dnit .= '</div>';
            $api_contrato_dnit .= '<div class="col-md-4">';
            $api_contrato_dnit .= '<table class="table table-striped table-bordered">';
        }
        $i++;
    }
    $api_contrato_dnit .= '</table>';
    $api_contrato_dnit .= '</div>';
    $api_contrato_dnit .= '</div>';
    return $api_contrato_dnit;
}

?>
<!-- <span class="badge bg-primary rounded-pill">14</span> -->
<div class="row">
<div class="col-12">
    <?php $i = 0; ?>
    <?php $content_1 = '<div class="col-md-5"><ul class="list-group list-group-horizontal row">'; ?>
        <?php foreach ($model->attributes as $k => $row): ?>
            <?php //if(!in_array($k, ['id', 'icone', 'obs', 'titulo'])): ?>
            <?php if(in_array($k, ['datacadastro', 'dataupdate', 'lote', 'objeto'])): ?>
            <?php 
                $sizex = '4';
                switch ($k) {
                    case 'dataupdate': $sizex = '8';
                    case 'objeto': $sizex = '8';
                }
                $content_1 .= '<li class="list-group-item col-'.$sizex.'" style="border: none !important;">';
                $content_1 .= '<div class="ms-2 me-auto">';
                $content_1 .= "<div class=\"fw-bold\">{$model->attributeLabels()[$k]}</div>";
                $content_1 .= formatar_campo($k, $row);
                $content_1 .= '</div>';
                $content_1 .= '</li>';
            ?>
            <?php $i++; ?>
            <?php if ($i%2 == 0) {
                $content_1 .=  '</ul><ul class="list-group list-group-horizontal row">';
            } ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php $content_1 .= '</ul></div>'; ?>
    <?php
        $i = 1;

        $f_1 = array_slice($dados, 0, 15);
        $f_2 = array_slice($dados, 15, 15);
        $f_3 = array_slice($dados, 30, 15);
        $f_4 = array_slice($dados, 45, 15);
        
        // echo '<pre>'; print_r($f_2); echo '</pre>';

        $items =[
            [
                'label' => '<center><strong>Resumo</strong></center>',
                'content' => '<div class="row">'.$content_1.'<div class="col-md-7">'.
                $this->render('resumomodulos', [
                    'model' => $model
                ])
                .'</div></div>',
                'options' => ['id' => 'aba_inicio_'.$model->id],
                'active' => true,
            ],
            [
                'label' => '<center>Contrato e Datas</center>',
                'content' => retorna_uma_sequencia($f_1),
                'options' => ['id' => 'aba_1_'.$model->id],
                'active' => false,
            ],
            [
                'label' => '<center>Empresa</center>',
                'content' => retorna_uma_sequencia($f_2),
                'options' => ['id' => 'aba_2_'.$model->id],
                'active' => false,
            ],
            [
                'label' => '<center>Fase</center>',
                'content' => retorna_uma_sequencia($f_3),
                'options' => ['id' => 'aba_3_'.$model->id],
                'active' => false,
            ],
            [
                'label' => '<center>Valores e Medidas</center>',
                'content' => retorna_uma_sequencia($f_4),
                'options' => ['id' => 'aba_4_'.$model->id],
                'active' => false,
            ],
        ]; 
        echo Tabs::widget([
            'items' => $items,
            'position'=>Tabs::POS_ABOVE,
            'align'=>Tabs::ALIGN_CENTER,
            'bordered'=>true,
            'encodeLabels'=>false
        ]);
    ?>

</div>
<div class="col-6">
    
</div>
</div>