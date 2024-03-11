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
                    /**
                     * 
                        Processo Administrativo SEI DNIT: 50600.010067/2018-07
                        https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=301535&infra_hash=df716deb6343918b9beb608cd380a543

                        Processo Administrativo SEI DNIT: 50600.009812/2021-62
                        https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=351607&infra_hash=78806fcc71fcc23cdff1a8c61f578486

                        Processo Administrativo SEI DNIT: 50600.018910/2020-18
                        https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=381782&infra_hash=5970b83627d2e5937d4b80cad44daaf7
                     */
                    foreach ($dataProvider->models as $row) {
                        # code...
                        $links_externos = "";

                        switch ($row->id) {
                            case 4:
                                $links_externos .= "<a class='btn btn-link' href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=301535&infra_hash=df716deb6343918b9beb608cd380a543' target='_blank'>Processo Administrativo SEI DNIT: 50600.010067/2018-07</a>";
                                $links_externos .= "<a class='btn btn-link' href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=351607&infra_hash=78806fcc71fcc23cdff1a8c61f578486' target='_blank'>Processo Administrativo SEI DNIT: 50600.009812/2021-62</a>";
                                $links_externos .= "<a class='btn btn-link' href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=381782&infra_hash=5970b83627d2e5937d4b80cad44daaf7' target='_blank'>Processo Administrativo SEI DNIT: 50600.018910/2020-18</a>";
                                break;
                            case 5:
                                $links_externos .= "<a class='btn btn-link' href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=481005&infra_hash=c659a7225da9aaee3e53c53ddb6fc2d8' target='_blank'>Processo Administrativo SEI DNIT: 50600.018471/2010-63</a>";
                                break;
                            case 6:
                                $links_externos .= "<a 
                                    class='btn btn-link' 
                                    href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=490748&infra_hash=fc7dcb4930e7d50ef53d2e4af424b00f' 
                                    target='_blank'>
                                        Processo Administrativo SEI DNIT: 50600.502439/2017-38
                                    </a>";
                                break;
                            case 10:
                                $links_externos .= "<a 
                                    class='btn btn-link' 
                                    href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=301565&infra_hash=b89346c2cfb4b588ecd3bc54a6d3cdde' 
                                    target='_blank'>
                                        Processo Administrativo SEI DNIT: 50600.010055/2018-74
                                    </a>";
                                break;
                            case 12:
                                $links_externos .= "<a 
                                    class='btn btn-link' 
                                    href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=681365&infra_hash=46d028c13286d2f1dc04ee82ec68b2cc' 
                                    target='_blank'>
                                        Processo Administrativo SEI DNIT: 50600.028403/2022-46
                                    </a>";
                                $links_externos .= "<a 
                                    class='btn btn-link' 
                                    href='https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=464174&infra_hash=29cd1bbfcf586c8c86aec2bd41479bd2' 
                                    target='_blank'>
                                        Processo Administrativo SEI DNIT: 50600.001843/2020-94
                                    </a>";
                                break;
                            
                            default: $links_externos .= ""; break;
                        }
                        
                        if (Yii::$app->user->identity->nivel == 'administrador') {
                            echo '<div class="col-6 my-3">';
                                echo "<div class='card'>
                                    <a class='text-white' href='".Yii::$app->homeUrl."empreendimento/preview?id=$row->id&contrato={$row->contrato->id}' style='text-decoration: none !important'>
                                    <div class='card-header bg-prinfo text-grey'>
                                            <strong><i class='fa fa-road'></i> $row->titulo</strong>".
                                    "</div></a>
                                    <div class='card-body'>".
                                        "<p class='card-text'>$links_externos</p>".
                                        "<p class='card-text'>Segmento: $row->segmento</p>".
                                        "</div>
                                        <div class='card-footer'>Registro: ".date('m/d/Y', strtotime($row->datacadastro)).
                                    "</div>
                                    </div>";
                                echo '</div>';
                        } else {
                            $emps_permitidos = UhE::findAll(['usuario_id' => Yii::$app->user->identity->id]);
                            $ids_permitidos = [];
                            foreach ($emps_permitidos as $k) {
                                array_push ($ids_permitidos, $k->empreendimento_id);
                            }
                            if (in_array($row->id, $ids_permitidos)) {
                                echo '<div class="col-6 my-3">';
                                echo "<div class='card'>
                                    <div class='card-header bg-prinfo text-grey'>
                                        <a href='".Yii::$app->homeUrl."empreendimento/preview?id=$row->id&contrato={$row->contrato->id}' style='text-decoration: none !important'>
                                            <strong><i class='fa fa-road'></i> $row->titulo</strong>".
                                    "</a></div>
                                    <div class='card-body'>
                                        <p class='card-text'>Segmento: $row->segmento</p>".
                                        "</div>
                                        <div class='card-footer'>Registro: ".date('m/d/Y', strtotime($row->datacadastro)).
                                    "</div>
                                    </div>";
                                echo '</div>';
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
