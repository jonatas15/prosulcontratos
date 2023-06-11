<?php

use app\models\Contrato;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ContratoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Contratos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contrato-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Contrato', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'datacadastro',
            'dataupdate',
            'icone:ntext',
            //'obs:ntext',
            //'lote:ntext',
            //'objeto',
            //'num_edital',
            //'empresa_executora',
            //'data_assinatura',
            //'data_final',
            //'saldo_prazo',
            //'valor_total',
            //'valor_faturado',
            //'saldo_contrato',
            //'valor_empenhado',
            //'saldo_empenho',
            //'data_base',
            //'vigencia',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Contrato $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
