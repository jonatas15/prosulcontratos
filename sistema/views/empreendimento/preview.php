<?php

use app\models\Empreendimento;
use app\models\Licenciamento;
use app\models\Fase;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap5\Accordion;
/** @var yii\web\View $this */
/** @var app\models\EmpreendimentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

// MAPA início
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\overlays\Polyline;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\layers\BicyclingLayer;

use dosamigos\google\maps\layers\KmlLayer;

use kartik\tabs\TabsX as Tabs;
use yii\helpers\ArrayHelper;

// MAPA fim

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => $model->contrato->titulo, 'url' => ['/contrato/view?id='.$model->contrato->id]];
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['/empreendimento?contrato='.$model->contrato->id]];
$this->params['breadcrumbs'][] = $this->title;

$templategeral_grid = '';
switch (Yii::$app->user->identity->nivel) {
    case 'administrador': $templategeral_grid = '<div style="white-space: nowrap;">{view} {subitens} {update} {delete}</div>'; break;
    case 'gestor': $templategeral_grid = '{view} {subitens} {update}'; break;
    case 'fiscal': $templategeral_grid = '{view}{subitens}'; break;
}


// $json_br_080 = file_get_contents(Yii::$app->basePath.'/web/arquivos/Trecho_SNV.geojson');
$json_br_080_1 = file_get_contents(Yii::$app->basePath.'/web/arquivos/br080dffdprojetada.geojson');
$json_br_080_2 = file_get_contents(Yii::$app->basePath.'/web/arquivos/eixoprojetado23s.geojson');
$json_br_080_3 = file_get_contents(Yii::$app->basePath.'/web/arquivos/hidrografiaibge250mil2021ae.geojson');
$json_br_080_4 = file_get_contents(Yii::$app->basePath.'/web/arquivos/travessiacursodagua.geojson');

// Decode the JSON file
$json_data_1 = json_decode($json_br_080_1,true);
$json_data_2 = json_decode($json_br_080_2,true);
$json_data_3 = json_decode($json_br_080_3,true);
$json_data_4 = json_decode($json_br_080_4,true);
  
// Display data
// echo '<pre>';
// print_r($json_data['features'][0]['geometry']['coordinates']);
// echo '</pre>';

?>
<style>
    #gmap0-map-canvas {
        width: 100% !important;
        min-height: 1000px !important;
    }
    .bg-prinfo {
        /* background-color: #0167A8 !important; */
        background-color: #0167A8 !important;
        color: white !important;
    }
    .list-group-item:hover {
        background-color: rgba(var(--bs-body-color-rgb), 0.03);
        font-weight: bolder;
    }
    .bg-gray {
        background-color: var(--bs-body-bg);
    }
</style>
<div class="empreendimento-index">

    <div class="row">
        <div class="row">
            <div class="col-md-12 pt-2 py-2">
                <?= Html::a('Voltar aos Empreendimentos <<', ['/empreendimento?contrato='.$model->contrato->id], ['class' => 'btn btn-info text-white float-right']) ?>
            </div>
        </div>
        <?php //Pjax::begin(); ?>
        <div class="row">
            <div class="col-md-4">
                <!-- <div class="row"> -->
                <div class="card mb-3">
                    <div class="card-header" style='color: gray'>Contrato <strong><?=$model->contrato->titulo?></strong></div>
                    <h3 class="my-3 mx-3"><i class="fa fa-road"></i> <strong><?=$model->titulo?></strong></h3>
                    <div class='card-footer'>
                        <?= '<b>Registro: </b>'. date('m/d/Y', strtotime($model->datacadastro)) ?>
                        <?php if (Yii::$app->user->identity->nivel == 'administrador'): ?>
                        <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-link p-1 px-0 mx-1 float-right text-danger',
                            'data' => [
                                'confirm' => 'Certeza que deseja excluir este registro "'.$model->titulo.'"?',
                                'method' => 'post',
                            ],
                            'options' => [
                                'disabled' => 'disabled'
                            ],
                        ]); ?>
                        <?php endif; ?>
                        <?php if(Yii::$app->user->identity->nivel != 'fiscal'): ?>
                        <?= Html::a('<i class="bi bi-pencil"></i> Editar', $url.'update?id='.$model->id.'&contrato='.$model->contrato->id, [
                            'class' => 'btn btn-link p-1 px-0 mx-1 float-right'
                        ]); ?>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="card my-3 py-3">
                    <div class="card-body">
                        <h3>Estágio do licenciamento</h3>
                        <?php $url = Yii::$app->homeUrl ?>
                        <?= Html::a('Acessar', $url.'empreendimento/empgerencial?id='.$model->id.'&contrato='.$model->contrato->id, [
                            'class' => 'btn btn-info text-white p-1 px-5 mx-1'
                        ]) ?>
                        <p class="card-text"><?php foreach ($model->licenciamentos as $lic): ?>
                            <div class="my-5">
                            <h3><strong><?= $lic->numero ?></strong></h3>
                            <p><descricao><?= $lic->descricao ?></descricao></p>
                            <?php 
                                $total_etapas = Fase::find()->where([
                                    'licenciamento_id' => $lic->id,
                                    'ativo' => 1,
                                ])->count();
                                // echo 'Etapas: '.$total_etapas;
                                $total_etapas_concluidas = Fase::find()->where([
                                    'licenciamento_id' => $lic->id,
                                    'ativo' => 1,
                                    'status' => 'Concluído'
                                ])->count();
                                // echo '<br>Etapas_concluidas: '.$total_etapas_concluidas;
                                $porcent_etapas_concluidas = 0;
                                $progressbaranimated = 'progress-bar-striped progress-bar-animated';
                                if ($total_etapas > 0) {
                                    // echo $porcent_etapas_concluidas;
                                    // echo $total_etapas;
                                    $porcent_etapas_concluidas = ($total_etapas_concluidas * 100)/$total_etapas;
                                    if ($porcent_etapas_concluidas == 100) {
                                        $progressbaranimated = '';
                                    }
                                    $porcent_etapas_concluidas = ceil($porcent_etapas_concluidas);
                                }
                            ?>
                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?=$porcent_etapas_concluidas?>" aria-valuemin="0" aria-valuemax="100" style="height: 25px">
                                <div class="progress-bar <?=$progressbaranimated?> bg-primary" style="width: <?=$porcent_etapas_concluidas?>%; font-size: 17px; font-weight: bolder">
                                    <?= $porcent_etapas_concluidas ==  100 ? 'Concluído' : $porcent_etapas_concluidas .'%'; ?>
                                </div>
                            </div>
                            </div>
                        <?php endforeach; ?></p>
                    </div>
                </div>
                <div class="card mb-3 py-3 px-3">
                    <p class="card-text">Segmento: <?=$model->segmento?></p>
                </div>
                <!-- </div> -->
            </div>
            <div class="col-md-8">
                <div class="card my-2 mx-1 bg-gray">
                    <!-- <h4 class="card-header bg-gray">🌐 Mapa e marcadores</h4> -->
                    <?php
                        $mapas = [];
                        foreach ($model->arquivos as $arquivo) {
                            if ($arquivo->pasta == 'Mapas') {
                                array_push($mapas, $arquivo);
                            }
                            // echo $arquivo->src . '<br>';
                        }
                    ?>
                    <?php //= $this->render('omapa', ['mapas' => $mapas]); ?>
                    <?php
                        $items = [];
                        array_push($items, [
                            'label' => '🌐 MAPA E MARCADORES',
                            'content' => '<div class="">'.$this->render('omapa', [
                                'mapas' => $mapas
                            ]).'</div>'.(Yii::$app->user->identity->nivel != 'fiscal' ? '
                                <center>
                                    <a href="'.Yii::$app->homeUrl.'empreendimento/update?id='.$model->id.'&abativa=aba_arquivos" class="btn btn-primary w-25 my-2 text-center">Mais arquivos: <i class="bi bi-upload"></i></a>
                                </center>
                            ' : ''),
                            'options' => ['id' => 'emp_mapas'],
                            'active' => true,
                
                        ]);
                        $produtos = \app\models\Produto::find()->where([
                            'empreendimento_id' => $model->id
                        ])->all();
                        $lista_servicos = ArrayHelper::map($produtos, 'servico', 'servico');
                        $prdos = "<div class='row'>";
                        foreach ($lista_servicos as $serv) {
                            // $prdos .= '<label value="'.$serv.'">'.$serv.'</label>';
                            $subprodutos = "";
                            foreach ($produtos as $pr) {
                                if ($pr->servico == $serv) {
                                    $subprodutos .= "<li class='list-group-item'>";
                                    
                                    $subprodutos .= $pr->subproduto;
                                    $subprodutos .= '<br>';
                                    $subprodutos .= '<div class="float-right">'.$this->render('/produto/detalhes', ['id' => $pr->id]).'</div>';
                                    
                                    $subprodutos .= "</li>";
                                }
                            }
                            $prdos .= '
                            <div class="col-md-4 my-2">
                                <div class="card" style="">
                                    <div class="card-header">
                                    '.$serv.'
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        '.$subprodutos.'
                                    </ul>
                                </div>
                            </div>
                            ';
                        }
                        $prdos .= '</div>';
                        array_push($items, [
                            'label' => '📦 PRODUTOS',
                            'content' => $prdos,
                            'options' => ['id' => 'emp_produtos'],
                            'active' => false,
                        ]);
                        echo '<div class="my-2">';
                        echo Tabs::widget([
                            'items' => $items,
                            'position'=>Tabs::POS_ABOVE,
                            'align'=>Tabs::ALIGN_CENTER,
                            'bordered'=>true,
                            'encodeLabels'=>false
                        ]);
                        echo '</div>';
                    
                    ?>
                    
                </div>
            </div>
        </div>
        <hr>
        <?php //Pjax::end(); ?>
    </div>
</div>
<?php
// Registro do código JavaScript
$js_dos_botoes = <<< JS
    $(".accordion-item").children(".collapse").removeClass("show");
JS;
$this->registerJs($js_dos_botoes);
?>
