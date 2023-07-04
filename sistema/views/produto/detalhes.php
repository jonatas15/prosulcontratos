<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\models\Produto;

$model = Produto::find()->where(['id' => $id])->one();

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
        'class' => 'btn btn-info text-white'
    ],
]);
?>
<div class="row">
    <div class="col">

        <?= DetailView::widget([
            'model' => $model,
    'attributes' => [
        'id',
        'produto_id',
        'empreendimento_id',
        'ordensdeservico_id',
        'subproduto',
        'numero',
        'datacadastro',
        'data_validade',
        'data_renovacao',
        'data_entrega',
        'fase',
        'entrega:ntext',
        'servico:ntext',
        'descricao:ntext',
        'aprov_data',
        'aprov_tempo_ultima_revisao',
        'aprov_tempo_total',
        'aprov_versao',
        'diretorio_texto',
        'diretorio_link:ntext',
    ],
    ]) ?>
    </div>
    <div class="col text-white">
        <div class="col-md-12">    
            <h3><strong>Revisões</strong></h3>
            <hr>
            <center>
                Lista todas as revisões já cadastradas<br>
                ***<br>
                < nenhuma revisão encontrada >
            </center>
        </div>
        <div class="col-md-12">
            <hr>   
        </div>
        <div class="col-md-12">    
            <h3><strong>Análises</strong></h3>
            <hr>
            tempo decorrido
            <br>tempo aguardando
            <br>etc
        </div>
    </div>
</div>
<div class="row"><hr></div>
<div class="row">
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
            10%
        </div>
    </div>
    <br>
    <br>
</div>
<?php Modal::end(); ?>
