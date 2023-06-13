<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\models\Oficio;

$model = Oficio::find()->where(['id' => $id])->one();

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
// \yii\web\YiiAsset::register($this);

// $model = \app\models\Oficio::find()->where(['id' => $id])->one();

?>
<?php
Modal::begin([
    'title' => $model->tipo .': '.$model->id,
    'options' => [
        'id' => 'mais-detalhes-'.$model->id,
        'tabindex' => false,
    ],
    'size' => 'modal-lg',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i>',
        'class' => 'btn btn-info text-white'
    ],
]);
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        // 'contrato_id',
        // 'emprrendimento_id',
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
<?php Modal::end(); ?>
