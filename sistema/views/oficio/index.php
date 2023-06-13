<?php

use app\models\Oficio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\OficioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Oficios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oficio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Oficio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'contrato_id',
            'emprrendimento_id',
            'tipo',
            'emprrendimento_desc',
            //'datacadastro',
            //'data',
            //'fluxo',
            //'emissor',
            //'receptor',
            //'num_processo',
            //'num_protocolo',
            //'Num_sei',
            //'assunto:ntext',
            //'diretorio',
            //'status',
            [
                'attribute' => 'id',
                'header' => 'Ver +',
                'format' => 'raw',
                'value' => function($data) {
                    
                    return $this->render('detalhes', [
                        'id' => $data->id
                    ]);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Oficio $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
