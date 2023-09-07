<?php

use app\models\Fase;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\FaseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Fases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fase-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Fase', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'empreendimento_id',
            'licenciamento_id',
            'fase',
            'datacadastro',
            //'data',
            //'exigencias',
            //'ambito',
            //'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fase $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
