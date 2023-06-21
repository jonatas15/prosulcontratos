<?php

use app\models\Arquivo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Accordion;
/** @var yii\web\View $this */
/** @var app\models\ArquivoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

// $this->params['breadcrumbs'][] = $this->title;
/**
 * Time Line de registro e edição nas mensagens
 * Colocar relação com outros ofícios
 * Aviso por email () 
 * 
 * Sistema Ofícios puxar tabela do Drive - registrar a fonte (pelo sistema ou pelo drive)
 */
?>
<div class="arquivo-index">

    <!-- <h3><?php //= Html::encode('Arquivos') ?></h3> -->
    <div class="row">
        <div class="col-md-12">
            <?php
                if ($funcionalidades):
                    Modal::begin([
                        'title' => 'Upload de Docs',
                        'toggleButton' => [
                            'label' => '<i class="bi bi-upload"></i> Upload de Arquivos',
                            'class' => 'btn btn-primary float-right'
                        ],
                        'size' => 'modal-lg',
                        'options' => [
                            'tabindex' => "false"
                        ]
                    ]);
                    $novosfiles = new \app\models\Arquivo();
                    // echo 'Id Ofício: '.$oficio_id;
                    echo $this->render('create', [
                        'model' => $novosfiles,
                        'oficio_id' => $oficio_id
                    ]);
                    Modal::end();
                endif;
            ?>
        </div>
    </div>
    <div class="row">
        <div class="clearfix">
            <br />
        </div>
    </div>
    <div class="row">
        <?php
        $pastas = Arquivo::find()->select('pasta')->where(['oficio_id' => $oficio_id])->groupBy(['pasta'])->all();
        // echo '<pre>';
        // print_r($pastas);
        // echo '</pre>';
        $itens = [];
        foreach ($pastas as $p) {
            // echo $p->pasta;
            $arquivos_na_pasta = Arquivo::find()->where([
                'pasta' => $p->pasta,
                'oficio_id' => $oficio_id
            ])->all();
            $item_content = '<div class="row">';
            foreach ($arquivos_na_pasta as $arq) {
                if ($arq->tipo == 'imagem') {
                    $item_content .= "<div class='col-md-4'>";
                    $item_content .= "<a href='".Yii::$app->homeUrl."arquivos/$arq->src' target='_blank'>".Html::img(Yii::$app->homeUrl."arquivos/$arq->src", [
                        'style' => [
                            'width' => '100%',
                            'padding-bottom' => '5%'
                        ]
                    ]).'</a>';
                    $item_content .= "</div>";
                // } elseif ($arq->tipo == 'documento') {
                } else {
                    $item_content .= "<div class='col-md-4' style='text-align: center;padding: 3%'>";
                    $item_content .= Html::a("<h1><i class=\"bi bi-filetype-doc\"></i></h1>Ver documento:<br>".mb_strimwidth($arq->src, 0, 25, "..."), [
                        "arquivos/$arq->src"], 
                    [
                        'target' => '_blank',
                        'class' => 'btn btn-primary'
                    ]);
                    $item_content .= "</div>";
                }
                // $item_content .= $arq->src;
            }
            $item_content .= "</div>";
            array_push($itens, [
                'label' => '📂 '.($p->pasta ? $p->pasta : 'Geral'),
                'content' => $item_content,
            ]);
        }
        echo '<h4 style="">🗂️ Pastas</h4>';
        echo Accordion::widget([
            'items' => $itens
        ]);
        ?>
    </div>
    <?php /**
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
            // 'contrato_id',
            'oficio_id',
            //'ordensdeservico_id',
            //'empreendimento_id',
            //'produto_id',
            //'licenciamento_id',
            'pasta',
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
*/ ?>
