<?php

use app\models\Empreendimento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\EmpreendimentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Empreendimentos';
$this->params['breadcrumbs'][] = ['label' => 'Contrato 1', 'url' => ['contrato/view?id=1']];
$this->params['breadcrumbs'][] = $this->title;

$templategeral_grid = '';
switch (Yii::$app->user->identity->nivel) {
    case 'administrador': $templategeral_grid = '<div style="white-space: nowrap;">{view} {update} {delete}</div>'; break;
    case 'gestor': $templategeral_grid = '{view} {update}'; break;
    case 'fiscal': $templategeral_grid = '{view}'; break;
}

?>
<div class="empreendimento-index">

    <div class="row">
        <div class="col-md-12">
            <h3><img src="/logo/contract-icon.png" class="icone-modulo" width="70" /> <?= Html::encode($this->title) ?></h3>
        </div>

        <div class="col-md-6 pt-2">
            <?= Html::a('Voltar <<', ['/'], ['class' => 'btn btn-warning text-white']) ?>
        </div>
        <div class="col-md-6 pt-2">
            <?php //= //Html::a('Novo Empreendimento', ['create'], ['class' => 'btn btn-success', 'style'=>"float: right !important"]) ?>
            <?php $nEmpModel = new Empreendimento(); ?>
            <?= $this->render('create', [
                'model' => $nEmpModel
            ]) ?>
        </div>
        <div class="col-md-12">
            <br>
            <br>
        </div>
        
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                'titulo',
                // 'prazo',
                // 'datacadastro',
                [
                    'attribute' => 'datacadastro',
                    'value' => function($data) {
                        return date ('m/d/Y', strtotime($data->datacadastro));
                    }
                ],
                [
                    'attribute' => 'prazo',
                    'value' => function($data) {
                        return $data->prazo.' dias';
                    }
                ],
                // 'dataupdate',
                // 'uf',
                'segmento',
                'status',
                'extensao_km',
                //'tipo_obra',
                //'municipios_interceptados:ntext',
                //'orgao_licenciador',
                //'ordensdeservico_id',
                //'oficio_id',
                // [
                //     'attribute' => 'oficio_id',
                //     'value' => function($data) {
                //         return $data->oficio->Num_sei;
                //     }
                // ],
                [
                    'class' => ActionColumn::className(),
                    'header' => '<center><strong><i class="bi bi-filter"></i></strong></center>',
                    'urlCreator' => function ($action, Empreendimento $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => $templategeral_grid,
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return $this->render('view', [
                                'id' => $model->id,
                                'model' => $model
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            return  Html::a('<i class="bi bi-gear"></i>', $url, ['class' => 'btn btn-primary text-white p-1 px-2']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return  Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger p-1 px-2',
                                'data' => [
                                    'confirm' => 'Certeza que deseja excluir este registro "'.$model->titulo.'"?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    ],
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
