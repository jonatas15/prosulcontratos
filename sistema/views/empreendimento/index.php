<?php

use app\models\Empreendimento;
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
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\overlays\Polyline;
use dosamigos\google\maps\layers\BicyclingLayer;

use app\models\UsuarioHasContrato as UHC;
use app\models\UsuarioHasEmpreendimento as UHE;

// MAPA fim

$r_contrato = 1;
$contrato = 1;
$contratonome = 'Lote C';
if ($_REQUEST['contrato']) {
    $r_contrato = $_REQUEST['contrato'];
    $modelcontrato = \app\models\Contrato::findOne(['id' => $r_contrato]);
    $contrato = $modelcontrato->id;
    $contratonome = $modelcontrato->titulo;
} 

$this->title = $contratonome.': Empreendimentos';
$this->params['breadcrumbs'][] = ['label' => $contratonome, 'url' => ['contrato/view?id='.$contrato]];
$this->params['breadcrumbs'][] = $this->title;

$templategeral_grid = '';
switch (Yii::$app->user->identity->nivel) {
    case 'administrador': $templategeral_grid = '<div style="white-space: nowrap;">{view} {subitens} {update} {delete}</div>'; break;
    case 'gestor': $templategeral_grid = '{view} {subitens} {update}'; break;
    case 'fiscal': $templategeral_grid = '{view}{subitens}'; break;
}


$json = file_get_contents(Yii::$app->basePath.'/web/arquivos/Trecho_SNV.geojson');
  
// Decode the JSON file
$json_data = json_decode($json,true);
  
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
</style>
<div class="empreendimento-index">

    <div class="row">
        <div class="col-md-12">
            <h3><img src="/logo/contract-icon.png" class="icone-modulo" width="30" /> <?= Html::encode($this->title) ?></h3>
        </div>

        <div class="col-md-6 pt-2">
            <?= Html::a('Voltar <<', ['/'], ['class' => 'btn btn-warning text-white']) ?>
        </div>
        <div class="col-md-6 pt-2">
            <?php //= //Html::a('Novo Empreendimento', ['create'], ['class' => 'btn btn-success', 'style'=>"float: right !important"]) ?>
            <?php if (Yii::$app->user->identity->nivel == 'administrador'): ?>
            <?php $nEmpModel = new Empreendimento(); ?>
            <?= $this->render('create', [
                'model' => $nEmpModel,
                'contrato_id' => $contrato
            ]) ?>
            <?php endif; ?>
        </div>
        <div class="col-md-12">
            <br>
            <br>
        </div>
        <div class="my-3">
        <?php /*= Accordion::widget([
                'items' => [
                [
                    'label' => '🔍 Pesquisar',
                    'content' => $this->render('_search', ['model' => $searchModel]),
                ]
            ]
        ]); */ ?>
        </div>
        <?php Pjax::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                <?php
                    foreach ($dataProvider->models as $row) {
                        # code...
                        
                        if (Yii::$app->user->identity->nivel == 'administrador') {
                            echo '<div class="col-6 my-3">';
                            echo "<a class='card' href='".Yii::$app->homeUrl."empreendimento/preview?id=$row->id&contrato={$row->contrato->id}' style='text-decoration: none !important'>
                                <div class='card-header bg-prinfo text-grey'>
                                <strong><i class='fa fa-road'></i> $row->titulo</strong>".
                                "</div>
                                <div class='card-body'>
                                    <p class='card-text'>Segmento: $row->segmento</p>".
                                    "</div>
                                    <div class='card-footer'>Registro: ".date('m/d/Y', strtotime($row->datacadastro)).
                                "</div>
                                </div>";
                            echo '</a>';
                        } else {
                            $emps_permitidos = UhE::findAll(['usuario_id' => Yii::$app->user->identity->id]);
                            $ids_permitidos = [];
                            foreach ($emps_permitidos as $k) {
                                array_push ($ids_permitidos, $k->empreendimento_id);
                            }
                            if (in_array($row->id, $ids_permitidos)) {
                                echo '<div class="col-6 my-3">';
                                echo "<a class='card' href='".Yii::$app->homeUrl."empreendimento/preview?id=$row->id&contrato={$row->contrato->id}' style='text-decoration: none !important'>
                                    <div class='card-header bg-prinfo text-grey'>
                                    <strong><i class='fa fa-road'></i> $row->titulo</strong>".
                                    "</div>
                                    <div class='card-body'>
                                        <p class='card-text'>Segmento: $row->segmento</p>".
                                        "</div>
                                        <div class='card-footer'>Registro: ".date('m/d/Y', strtotime($row->datacadastro)).
                                    "</div>
                                    </div>";
                                echo '</a>';
                            }
                        }
                    }
                ?>
                </div>
            </div>
            <div class="col-md-6">
                <h3>🌐 Mapa e marcadores</h3>
                <?php
                    $mapas = [];
                    $arquivos = \app\models\Arquivo::find()->where([
                        'pasta' => 'Mapas'
                    ])->andWhere([
                        'not', ['empreendimento_id' => null]
                    ])->all();
                    foreach ($arquivos as $arquivo) {
                        if (Yii::$app->user->identity->nivel == 'administrador') {
                            if($arquivo->pasta == 'Mapas' && $arquivo->empreendimento->contrato_id == $contrato) {
                                array_push($mapas, $arquivo);
                            }
                        } else {
                            // echo $arquivo->src . '<br>';
                            $emps_permitidos = UhE::findAll(['usuario_id' => Yii::$app->user->identity->id]);
                            $ids_permitidos = [];
                            foreach ($emps_permitidos as $k) {
                                array_push ($ids_permitidos, $k->empreendimento_id);
                            }
                            if (in_array($arquivo->empreendimento_id, $ids_permitidos)) {
                                if($arquivo->pasta == 'Mapas' && $arquivo->empreendimento->contrato_id == $contrato) {
                                    array_push($mapas, $arquivo);
                                }
                            }
                        }
                    }
                ?>
                <?= $this->render('omapa', [
                    'mapas' => $mapas
                ]); ?>
            </div>
        </div>
        <hr>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
// Registro do código JavaScript
$js_dos_botoes = <<< JS
    $(".accordion-item").children(".collapse").removeClass("show");
JS;
$this->registerJs($js_dos_botoes);
?>
