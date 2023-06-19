<?php

use app\models\Arquivo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\ArquivoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Arquivos';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="arquivo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Arquivo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tipo',
            'datacadastro',
            'src:ntext',
            'contrato_id',
            'oficio_id',
            //'ordensdeservico_id',
            //'empreendimento_id',
            //'produto_id',
            //'licenciamento_id',
            //'pasta',
            //'ref',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Arquivo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
