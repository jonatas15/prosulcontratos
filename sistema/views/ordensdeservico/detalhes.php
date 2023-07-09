<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\models\Ordensdeservico;

$model = Ordensdeservico::find()->where(['id' => $id])->one();

/** @var yii\web\View $this */
/** @var app\models\Ordensdeservico $model */
// \yii\web\YiiAsset::register($this);

// $model = \app\models\Ordensdeservico::find()->where(['id' => $id])->one();

?>
<style>
    /* Chat container-chats */
.container-chat {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

/* Darker chat container-chat */
.darker {
  border-color: #ccc;
  background-color: #ddd;
}

/* Clear floats */
.container-chat::after {
  content: "";
  clear: both;
  display: table;
}

/* Style images */
.container-chat img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

/* Style the right image */
.container-chat img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

/* Style time text */
.time-right {
  float: right;
  color: #aaa;
}

/* Style time text */
.time-left {
  float: left;
  color: #999;
}
.avataruser {
    border-radius: 50% !important;
    width: 70px;
    border: 1px solid;
    background-color: black;
    float: left;
}
.nomegestor {
    float: left;

}
</style>
<?php
Modal::begin([
    'title' => $model->id .': '.$model->titulo,
    'options' => [
        'id' => 'mais-detalhes-os-'.$model->id,
        'tabindex' => false,
    ],
    'size' => 'modal-lg',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i>',
        'class' => 'btn btn-info text-white'
    ],
    'bodyOptions' => [
        'class' => 'bg-white'
    ]
]);
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'titulo',
        'fase',
        'plano',
        [
            'attribute'=> 'datacadastro',
            'value' => function($data) {
                return date('d/m/Y H:i:s', strtotime($data->datacadastro));
            }
        ],
    ],
]) ?>
<?php Modal::end(); ?>
