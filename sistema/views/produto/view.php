<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Produto $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'produto_id',
            'empreendimento_id',
            'ordensdeservico_id',
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
