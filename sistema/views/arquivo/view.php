<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Arquivo $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Arquivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="arquivo-view">

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
            'tipo',
            'datacadastro',
            'src:ntext',
            'contrato_id',
            'oficio_id',
            'ordensdeservico_id',
            'empreendimento_id',
            'produto_id',
            'licenciamento_id',
            'pasta',
            'ref',
        ],
    ]) ?>

</div>
