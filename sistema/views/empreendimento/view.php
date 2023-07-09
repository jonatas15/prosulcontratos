<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\models\Produto;

// $model = Produto::find()->where(['id' => $id])->one();

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
// \yii\web\YiiAsset::register($this);

// $model = \app\models\Oficio::find()->where(['id' => $id])->one();

?>
<style>
    .list-group-item:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }
</style>
<?php
Modal::begin([
    'title' => $model->titulo,
    'options' => [
        'id' => 'empreendimento-mais-detalhes-'.$model->id,
        'tabindex' => false,
    ],
    'size' => 'modal-xl',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i>',
        'class' => 'btn btn-info text-white p-1 px-2'
    ],
    'bodyOptions' => [
        'class' => 'bg-white'
    ]
]);
?>
<?php if (count($model->fases) > 0): ?>
<div class="row align-center pb-5">
    <?= $this->render('timeline', [
        'id' => $model->id,
        'model' => $model
    ]); ?>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-7">
        <h3 class="bg-info p-0 m-0 py-2 text-white text-center table-bordered">Detalhes</h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'titulo',
                'prazo',
                // 'datacadastro',
                [
                    'attribute'=> 'datacadastro',
                    'value' => function($data) {
                        return date('d/m/Y H:i:s', strtotime($data->datacadastro));
                    }
                ],
                // 'dataupdate',
                'status',
                'uf',
                'segmento',
                'extensao_km',
                'tipo_obra',
                'municipios_interceptados:ntext',
                'orgao_licenciador',
                'ordensdeservico_id',
                'oficio.Num_sei',
            ],
        ]) ?>
    </div>
    <div class="col-5">
        <div class="card mb-2" style="width: 100%;">
            <div class="card-header bg-info text-white">
                <strong>Produtos</strong>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach($model->produtos as $produto):?>
                    <?php 
                    $bg_class = "";
                    switch ($produto->fase) {
                        case 'Aprovado': $bg_class = "success"; break;
                        case 'Em andamento': $bg_class = "warning"; break;
                        case 'Reprovado': $bg_class = "danger"; break;
                    } 
                    ?>
                    <li class="list-group-item">
                        <exp class="badge bg-info float-right"><?=$produto->data_entrega != '' ? date('d/m/Y', strtotime($produto->data_entrega)) : '' ?></exp>
                        <!-- <a href="<?=Yii::$app->homeUrl."produto/view?id=$produto->id"?>" target="_blank"> -->
                        <p style="white-space: break-spaces;"><?=$produto->subproduto?></p>
                        <!-- </a> -->
                        <div class="badge bg-<?=$bg_class?>"><?=$produto->fase?></div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<?php Modal::end(); ?>
