<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsuarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
$templategeral_grid = '';
switch (Yii::$app->user->identity->nivel) {
    case 'administrador': $templategeral_grid = '{update}{delete}'; break;
    case 'gestor': $templategeral_grid = '{update}'; break;
}
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="float-right">
        <?= in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor']) ? Html::a('Novo Usuário', ['create'], ['class' => 'btn btn-success']) : '' ?>
        <?php //= Html::a('Create Usuario', ['create'], ['class' => 'btn btn-success', 'visible' => false], ['visible' => false]) ?>
    </div>
    <div class="row"><br><br></div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'foto',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::img(Yii::$app->homeUrl.'usuarios/'.$data->foto, [
                        'width' => '60',
                        'height' => '60',
                        'style' => [
                            'object-fit' => 'cover',
                            'border-radius' => '30px'
                        ]
                    ]);
                }
            ],
            'nome',
            // 'telefone',
            [
                'attribute' => 'telefone',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->telefone ? "<a href='tel:+$data->telefone'>".$this->context->format_telefone($data->telefone)."</a>" : "";
                }
            ],
            'email:email',
            // 'cpf',
            'nivel',
            'login',
            // 'senha',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Usuario $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template' => $templategeral_grid
            ],
        ],
    ]); ?>


</div>
