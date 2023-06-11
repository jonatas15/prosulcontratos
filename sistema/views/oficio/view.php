<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Oficios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="oficio-view">

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
            'contrato_id',
            'emprrendimento_id',
            'tipo',
            'emprrendimento_desc',
            'datacadastro',
            'data',
            'fluxo',
            'emissor',
            'receptor',
            'num_processo',
            'num_protocolo',
            'Num_sei',
            'assunto:ntext',
            'diretorio',
            'status',
        ],
    ]) ?>

</div>
