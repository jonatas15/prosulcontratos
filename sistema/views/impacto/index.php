<?php

use app\models\Impacto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ImpactoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Impactos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="impacto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Impacto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'contrato_id',
            'produto:ntext',
            'servico:ntext',
            'numeroitem',
            //'produto_id',
            //'unidade',
            //'quantidade_a',
            //'quantidade_utilizada',
            //'qt_restante_real',
            //'qt_restante',
            //'preco_unitario',
            //'custos_diretos',
            //'custos_indiretos',
            //'custo_total',
            //'custo_utilizado',
            //'saldo_restante',
            //'custo_real',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Impacto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
