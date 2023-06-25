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
$this->params['breadcrumbs'][] = ['label' => 'Ofício: 154', 'url' => ['contrato/view?id=1&abativa=aba_oficios']];
$this->params['breadcrumbs'][] = $this->title;

$templategeral_grid = '';
switch (Yii::$app->user->identity->nivel) {
    case 'administrador': $templategeral_grid = '{view}{update}{delete}'; break;
    case 'gestor': $templategeral_grid = '{view}{update}'; break;
    case 'fiscal': $templategeral_grid = '{view}'; break;
}

?>
<div class="empreendimento-index">

    <div class="row">

        <div class="col-md-12">
            <h3><img src="/logo/contract-icon.png" class="icone-modulo" width="70" /> <?= Html::encode($this->title) ?></h3>
        </div>

        <div class="col-md-12">
            <br>
        </div>
        <div class="col-md-6">
            <?= Html::a('Voltar <<', ['/contrato/view?id=1'], ['class' => 'btn btn-warning text-white']) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a('Novo Empreendimento', ['create'], ['class' => 'btn btn-success', 'style'=>"float: right !important"]) ?>
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
                'prazo',
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
                'status',
                'uf',
                'segmento',
                'extensao_km',
                //'tipo_obra',
                //'municipios_interceptados:ntext',
                //'orgao_licenciador',
                //'ordensdeservico_id',
                //'oficio_id',
                [
                    'attribute' => 'oficio_id',
                    'value' => function($data) {
                        return $data->oficio->Num_sei;
                    }
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Empreendimento $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => $templategeral_grid
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
