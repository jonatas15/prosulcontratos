<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\models\Produto;

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
use dosamigos\google\maps\layers\KmlLayer;
use dosamigos\google\maps\layers\KmlLayerOptions;

// $model = Produto::find()->where(['id' => $id])->one();

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */
// \yii\web\YiiAsset::register($this);

// $model = \app\models\Oficio::find()->where(['id' => $id])->one();

?>
<style>
    .list-group-item:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }
    #gmap0-map-canvas {
        width: 100% !important;
        height: 300px !important;
    }
</style>
<!-- <div id="mapax" style="width: 100%; height: 600px;"></div> -->
<?php
// Modal::begin([
//     'title' => $model->titulo,
//     'options' => [
//         'id' => 'empreendimento-mais-detalhes-'.$model->id,
//         'tabindex' => false,
//     ],
//     'size' => 'modal-xl',
//     'toggleButton' => [
//         'label' => '<i class="bi bi-card-list"></i>',
//         'class' => 'btn btn-info text-white p-1 px-2'
//     ],
//     'bodyOptions' => [
//         'class' => 'bg-white'
//     ]
// ]);
?>
<?php if (count($model->fases) > 0): ?>
<div class="row align-center pb-5">
    <?= $this->render('timeline', [
        'id' => $model->id,
        'model' => $model
    ]); ?>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12 my-4">
        <h3>🌐 Mapa e marcadores</h3>
        <?php 
            // Opções do Mapa

            $coord = new LatLng(['lat' => -2.9214318, 'lng' => -61.6436715]);
            $map = new Map([
                'center' => $coord,
                'zoom' => 8,
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
            // $coords = [
            //     new LatLng(['lng' => -61.6436715, 'lat' => -2.9214318]),
            //     new LatLng(['lng' => -61.943049,  'lat' => -3.0476032]),
            //     new LatLng(['lng' => -61.9375558, 'lat' => -3.5603586]),
            //     new LatLng(['lng' => -61.8661447, 'lat' => -3.8454065]),
            //     new LatLng(['lng' => -61.4788766, 'lat' => -4.2755365]),
            //     new LatLng(['lng' => -60.536799,  'lat' => -3.5822886]),
            //     new LatLng(['lng' => -60.3582711, 'lat' => -3.4123177]),
            //     new LatLng(['lng' => -59.9627633, 'lat' => -3.8618488]),
            //     new LatLng(['lng' => -59.6359201, 'lat' => -3.3382887]),
            //     new LatLng(['lng' => -60.1550241, 'lat' => -2.9049736]),
            //     new LatLng(['lng' => -60.72082,   'lat' => -2.5757612]),
            //     new LatLng(['lng' => -61.6436715, 'lat' => -2.9214318])
            // ];
            // $polygon = new Polygon([
            //     'paths' => $coords
            // ]);

            // Add a shared info window
            // $polygon->attachInfoWindow(new InfoWindow([
            //         'content' => '<p>This is my super cool Polygon</p>'
            //     ]));

            // Add it now to the map
            // $map->addOverlay($polygon);

            // Lets show the BicyclingLayer :)
            // $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);
            // $kmlLayer = new KmlLayer([
            //     'map' => $map->getName(),
            //     'url' => Yii::$app->homeUrl.'arquivos/testecomconrdenadas.kml'
            // ]);

            // Append its resulting script
            // $map->appendScript($bikeLayer->getJs());
            // $map->appendScript($kmlLayer->getJs());

            // Display the map -finally :)
            echo $map->display();
        
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-7" style="border-radius: 10px">
        <h3 class="bg-info p-0 m-0 py-2 text-white text-center table-bordered">Detalhes</h3>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'titulo',
                'prazo',
                // 'datacadastro',
                [
                    'attribute'=> 'datacadastro',
                    'value' => function($data) {
                        return date('d/m/Y H:i:s', strtotime($data->datacadastro));
                    }
                ],
                // 'dataupdate',
                'status',
                'uf',
                'segmento',
                'extensao_km',
                'tipo_obra',
                'municipios_interceptados:ntext',
                'orgao_licenciador',
                'ordensdeservico_id',
                'oficio.Num_sei',
            ],
        ]) ?>
    </div>
    <div class="col-md-5">
        <div class="card mb-2" style="width: 100%;">
            <div class="card-header bg-info text-white">
                <strong>Produtos</strong>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach($model->produtos as $produto):?>
                    <?php 
                    $bg_class = ""; 
                    switch ($produto->fase) {
                        case 'Aprovado': $bg_class = "success"; break;
                        case 'Em andamento': $bg_class = "warning"; break;
                        case 'Reprovado': $bg_class = "danger"; break;
                    } 
                    ?>
                    <li class="list-group-item">
                        <exp class="badge bg-info float-right"><?=$produto->data_entrega != '' ? date('d/m/Y', strtotime($produto->data_entrega)) : '' ?></exp>
                        <!-- <a href="<?=Yii::$app->homeUrl."produto/view?id=$produto->id"?>" target="_blank"> -->
                        <p style="white-space: break-spaces;"><?=$produto->subproduto?></p>
                        <!-- </a> -->
                        <div class="badge bg-<?=$bg_class?>"><?=$produto->fase?></div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<?php //Modal::end(); ?>
<?php
// Registro do código JavaScript
// $js_dos_mapas = <<< JS
//     // Crie o mapa
//     var map = new google.maps.Map(document.getElementById('mapax'), {
//         center: { lat: -2, lng: -61 }, // Defina o centro do mapa
//         zoom: 8 // Defina o nível de zoom
//     });

//     // Carregue o arquivo KML
//     var kmlLayer = new google.maps.KmlLayer({
//         url: 'http://localhost:8080/arquivos/testecomconrdenadas.kml',
//         map: map
//     });
// JS;
// $this->registerJs($js_dos_mapas);
?>

