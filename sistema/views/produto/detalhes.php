<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\models\Produto;

$model = Produto::findOne(['id' => $id]);

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
// \yii\web\YiiAsset::register($this);

// $model = \app\models\Oficio::find()->where(['id' => $id])->one();

?>
<?php
Modal::begin([
    'title' => $model->subproduto,
    'options' => [
        'id' => 'produto-mais-detalhes-'.$model->id,
        'tabindex' => false,
    ],
    'size' => 'modal-xl',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i>',
        'class' => 'btn btn-info text-white',
        'tittle' => $model->subproduto,
        'alt' => $model->subproduto,
    ],
    'bodyOptions' => [
        'class' => 'bg-white'
    ]
]);
?>
<div class="row">
    <div class="col">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                // 'produto_id',
                'servico:ntext',
                'subproduto',
                'empreendimento.titulo',
                'ordensdeservico.titulo',
                'numero',
                // 'datacadastro',
                [
                    'attribute'=> 'datacadastro',
                    'value' => function($data) {
                        return date('d/m/Y H:i:s', strtotime($data->datacadastro));
                    }
                ],
                [
                    'attribute'=> 'data_validade',
                    'value' => function($data) {
                        return $data->data_validade ? date('d/m/Y', strtotime($data->data_validade)) : "";
                    }
                ],
                [
                    'attribute'=> 'data_renovacao',
                    'value' => function($data) {
                        return $data->data_renovacao ? date('d/m/Y', strtotime($data->data_renovacao)) : "";
                    }
                ],
                [
                    'attribute'=> 'data_entrega',
                    'value' => function($data) {
                        return $data->data_entrega ? date('d/m/Y', strtotime($data->data_entrega)) : "";
                    }
                ],
                'fase',
                'entrega:ntext',
                'descricao:ntext',
                [
                    'attribute'=> 'aprov_data',
                    'value' => function($data) {
                        return $data->aprov_data ? date('d/m/Y', strtotime($data->aprov_data)) : "";
                    }
                ],
                'aprov_tempo_ultima_revisao',
                'aprov_tempo_total',
                'aprov_versao',
                // 'diretorio_texto',
                [
                    'attribute'=> 'diretorio_texto',
                    'format' => 'raw',
                    'value' => function($data) {
                        return "<a href='$data->diretorio_link' target='_blank'>$data->diretorio_texto</a>";
                    }
                ]
                // 'diretorio_link:ntext',
            ],
        ]) ?>
    </div>
    <div class="col">
        <div class="col-md-12">    
            <h3><strong>Revisões</strong></h3>
            <sub>Lista todas as revisões já cadastradas</sub>
            <hr>
            <center>
                <!-- *** -->
                <br>
                <?php if (count($model->revisaos) > 0): ?>
                    <div class="row">
                    <?php
                        foreach ($model->revisaos as $review) {
                            echo "
                            <div class='col-6  mb-2'><div class='card'>
                                <div class='card-header ".(strpos($review->status, 'Aprovado') > -1 ? 'bg-success' : 'bg-danger')." text-white'>
                                $review->titulo
                                </div>
                                <ul class='list-group list-group-flush'>
                                <li class='list-group-item'>".date('d/m/Y', strtotime($review->data))."</li>
                                <li class='list-group-item'>$review->tempo_ultima_etapa dias</li>
                                <li class='list-group-item'>Responsável: $review->responsavel</li>
                                <li class='list-group-item text-uppercase ".(strpos($review->status, 'Aprovado') > -1 ? 'text-success' : 'text-danger')."'><strong>$review->status</strong></li>
                                </ul>
                            </div></div>";
                        }
                    ?>
                    </div>
                <?php else: ?>
                    < nenhuma revisão encontrada >
                <?php endif; ?>
            </center>
        </div>
        <div class="col-md-12">
            <hr>   
        </div>
        <div class="col-md-12">    
            <h3><strong>Análises</strong></h3>
            <hr>
            <!-- tempo decorrido
            <br>tempo aguardando
            <br>etc -->
            <table class="table table-striped table-bordered detail-view">
                <?php if (count($model->revisaos) > 0): ?>
                    <?php
                        $total = 0;
                        foreach ($model->revisaos as $review) {
                            $total += (int)$review->tempo_ultima_etapa;    
                        } 
                    ?>
                    <tr>
                        <td>Tempo total (<?=$total?> dias)</td>
                    </tr>
                    <tr>
                        <td>
                        <div 
                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary text-white" 
                            role="progressbar" 
                            aria-valuenow="100" 
                            aria-valuemin="0" 
                            aria-valuemax="100" 
                            style="width: 100%"
                        >
                            <?=$total?>
                        </div>
                        </td>
                    </tr>
                    <tr>
                    <?php foreach ($model->revisaos as $review): ?>
                        <?php
                            $classegrafica = 'bg-info';
                            switch ($review->status) {
                                case 'Aprovado': $classegrafica = 'bg-success text-white'; break;
                                case 'Aprovado com ajustes': $classegrafica = 'bg-info text-black'; break;
                                case 'Reprovado': $classegrafica = 'bg-danger text-white'; break;
                            }    
                        ?>
                        <tr>
                            <td><?=$review->titulo?> (<?=$review->tempo_ultima_etapa?> dias)</td>
                        </tr><tr>
                            <td>
                                <div 
                                    class="progress-bar progress-bar-striped progress-bar-animated <?=$classegrafica?>" 
                                    role="progressbar" 
                                    aria-valuenow="<?=$review->tempo_ultima_etapa?>" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100" 
                                    style="width: <?=number_format(($review->tempo_ultima_etapa*100)/$total, 2)?>%"
                                >
                                    <?=number_format(($review->tempo_ultima_etapa*100)/$total, 2)?>%
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tr>
                <?php else: ?>
                    <tr><td>< nenhuma revisão encontrada ></td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<!-- <div class="row"><hr></div>
<div class="row">
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
            10%
        </div>
    </div>
    <br>
    <br>
</div> -->
<?php Modal::end(); ?>
