<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Tabs;
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
use dosamigos\google\maps\layers\BicyclingLayer;
// MAPA fim

/** @var yii\web\View $this */
/** @var app\models\Contrato $model */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    #gmap0-map-canvas {
        width: 100% !important;
    }
    .tab-content {
        border: 1px solid lightgray;
        border-top: 0 !important;
    }
</style>
<div class="contrato-view">

    <h3 class="text-uppercase"><img src="/logo/contract-icon.png" class="icone-modulo" width="25" /> <?= Html::encode($this->title) ?></h3>
    <hr>
    
    
    <?php $detalhamento = '<br><div class="row"><div class="col-md-6">'.DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titulo',
            'datacadastro',
            'dataupdate',
            'icone:ntext',
            'obs:ntext',
            'lote:ntext',
            'objeto',
            'num_edital',
            'empresa_executora',
            'data_assinatura',
            'data_final',
            'saldo_prazo',
            'valor_total',
            'valor_faturado',
            'saldo_contrato',
            'valor_empenhado',
            'saldo_empenho',
            'data_base',
            'vigencia',
        ],
    ]).'</div></div><br>';  
    
    // Opções do Mapa

    $coord = new LatLng(['lat' => 39.720089311812094, 'lng' => 2.91165944519042]);
    $map = new Map([
        'center' => $coord,
        'zoom' => 14,
    ]);

    // lets use the directions renderer
    $home = new LatLng(['lat' => 39.720991014764536, 'lng' => 2.911801719665541]);
    $school = new LatLng(['lat' => 39.719456079114956, 'lng' => 2.8979293346405166]);
    $santo_domingo = new LatLng(['lat' => 39.72118906848983, 'lng' => 2.907628202438368]);

    // setup just one waypoint (Google allows a max of 8)
    $waypoints = [
        new DirectionsWayPoint(['location' => $santo_domingo])
    ];

    $directionsRequest = new DirectionsRequest([
        'origin' => $home,
        'destination' => $school,
        'waypoints' => $waypoints,
        'travelMode' => TravelMode::DRIVING
    ]);

    // Lets configure the polyline that renders the direction
    $polylineOptions = new PolylineOptions([
        'strokeColor' => '#FFAA00',
        'draggable' => true
    ]);

    // Now the renderer
    $directionsRenderer = new DirectionsRenderer([
        'map' => $map->getName(),
        'polylineOptions' => $polylineOptions
    ]);

    // Finally the directions service
    $directionsService = new DirectionsService([
        'directionsRenderer' => $directionsRenderer,
        'directionsRequest' => $directionsRequest
    ]);

    // Thats it, append the resulting script to the map
    $map->appendScript($directionsService->getJs());

    // Lets add a marker now
    $marker = new Marker([
        'position' => $coord,
        'title' => 'My Home Town',
    ]);

    // Provide a shared InfoWindow to the marker
    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => '<p>This is my super cool content</p>'
        ])
    );

    // Add marker to the map
    $map->addOverlay($marker);

    // Now lets write a polygon
    $coords = [
        new LatLng(['lat' => 25.774252, 'lng' => -80.190262]),
        new LatLng(['lat' => 18.466465, 'lng' => -66.118292]),
        new LatLng(['lat' => 32.321384, 'lng' => -64.75737]),
        new LatLng(['lat' => 25.774252, 'lng' => -80.190262])
    ];

    $polygon = new Polygon([
        'paths' => $coords
    ]);

    // Add a shared info window
    $polygon->attachInfoWindow(new InfoWindow([
            'content' => '<p>This is my super cool Polygon</p>'
        ]));

    // Add it now to the map
    $map->addOverlay($polygon);


    // Lets show the BicyclingLayer :)
    $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);

    // Append its resulting script
    $map->appendScript($bikeLayer->getJs());

    // Display the map -finally :)
    // echo $map->display();
    
    ?>
    <div class="row">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                30%
            </div>
        </div>
        <br>
        <?= $map->display(); ?>
    </div>
    <div class="row">
        <div class="clearfix"></div>
        <br>
        <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                    10%
                </div>
            </div>
        <br>
        <br>
    </div>
    <div class="row">
        <?php 
            ########################## GESTÃO DE OFÍCIOS #############################
            $searchModelOficio = new \app\models\OficioSearch();
            $dataProviderOficio = $searchModelOficio->search(['contrato_id'=>$model->id]);
            $gestaooficios = '<div class="row">';
            $gestaooficios .= '<div class="col-md-12">';
            $gestaooficios .= '<br>';
            $gestaooficios .= $this->render(Yii::$app->homeUrl.'oficio/indexcontrato', [
                'searchModel' => $searchModelOficio,
                'dataProvider' => $dataProviderOficio
            ]);
            $gestaooficios .= '</div>';
            $gestaooficios .= '</div>';
            ########################## GESTÃO DE OFÍCIOS #############################


            echo Tabs::widget([
                'items' => [
                    [
                        'label' => '📄 Dados Contratuais',
                        'content' => $detalhamento,
                        'options' => ['id' => 'aba_dados'],
                        // 'active' => true
                    ],
                    [
                        'label' => '📄 Gestão de Ofícios',
                        'content' => $gestaooficios,
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_oficios'],
                        'active' => true
                    ],
                    [
                        'label' => '📋 Ordens de Serviço',
                        'content' => 'Anim pariatur cliche...',
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_ordens'],
                        // 'active' => true
                    ],
                    [
                        'label' => '✅ Licenciamentos',
                        'content' => 'Anim pariatur cliche...',
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_licensas'],
                        // 'active' => true
                    ],
                    [
                        'label' => '📦 Produtos',
                        'content' => 'Anim pariatur cliche...',
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_produtos'],
                        // 'active' => true
                    ],
                    // [
                    //     'label' => 'Dropdown',
                    //     'items' => [
                    //          [
                    //              'label' => 'DropdownA',
                    //              'content' => 'DropdownA, Anim pariatur cliche...',
                    //          ],
                    //          [
                    //              'label' => 'DropdownB',
                    //              'content' => 'DropdownB, Anim pariatur cliche...',
                    //          ],
                    //     ],
                    // ],
                ],
            ]);
        ?>
    </div>
        
</div>
