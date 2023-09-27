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

// MAPA fim

$this->title = 'Empreendimentos';
$this->params['breadcrumbs'][] = ['label' => 'Contrato 1', 'url' => ['contrato/view?id=1']];
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
        <div class="row">
            <div class="col-md-6">
                <!-- <div class="row"> -->
                    <div class="card">
                        <h4 class="card-header bg-prinfo text-grey">
                            <strong><?=$model->titulo?></strong>
                        </h4>
                        <div class="card-body">
                            <p class="card-text">Segmento: <?=$model->segmento?></p>
                            <p class="card-text"><?php
                                foreach ($model->licenciamentos as $lic) {
                                    echo $lic->numero.'<br>';
                                }
                            ?></p>
                        </div>
                        <div class='card-footer'>
                            <?= date('m/d/Y', strtotime($model->datacadastro)) ?>
                            <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-link p-1 px-0 mx-1 float-right',
                                'data' => [
                                    'confirm' => 'Certeza que deseja excluir este registro "'.$model->titulo.'"?',
                                    'method' => 'post',
                                ],
                                'options' => [
                                    'disabled' => 'disabled'
                                ],
                            ]); ?>
                            <?= Html::a('<i class="bi bi-pencil"></i>', $url.'update?id='.$model->id, [
                                'class' => 'btn btn-link p-1 px-0 mx-1 float-right'
                            ]); ?>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-md-6">
                <div class="card">
                <h4 class="card-header bg-gray">🌐 Mapa e marcadores</h4>
                <?php 
                    // Opções do Mapa

                    // $coord = new LatLng(['lat' => -27.5969, 'lng' => -48.5495]);
                    // Manaus
                    $coord = new LatLng(['lat' => -3.119027, 'lng' => -60.021731]);
                    $map = new Map([
                        'center' => $coord,
                        'zoom' => 7,
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
                    $coords = [];
                    $coords = [
                        new LatLng(['lng' => -61.6436715,   'lat' => -2.9214318]),
                        new LatLng(['lng' => -61.943049,    'lat' => -3.0476032]),
                        new LatLng(['lng' => -61.9375558,   'lat' => -3.5603586]),
                        new LatLng(['lng' => -61.8661447,   'lat' => -3.8454065]),
                        new LatLng(['lng' => -61.4788766,   'lat' => -4.2755365]),
                        new LatLng(['lng' => -60.536799,    'lat' => -3.5822886]),
                        new LatLng(['lng' => -60.3582711,   'lat' => -3.4123177]),
                        new LatLng(['lng' => -59.9627633,   'lat' => -3.8618488]),
                        new LatLng(['lng' => -59.6359201,   'lat' => -3.3382887]),
                        new LatLng(['lng' => -60.1550241,   'lat' => -2.9049736]),
                        new LatLng(['lng' => -60.72082,     'lat' => -2.5757612]),
                        new LatLng(['lng' => -61.6436715,   'lat' => -2.9214318])
                    ];
                    
                    
                    $vet_coord_grupo = $json_data['features'];
                    // echo '<pre>';
                    // print_r($vet_coord_grupo);
                    // echo '</pre>';
                    
                    foreach($vet_coord_grupo as $coor_grupo) {
                        $linha = [];
                        // echo '<pre>';
                        // print_r($coor_grupo);
                        // echo '</pre>';
                        // echo '<br><<<< - separador - >>>><br><hr><br>';
                        $vet_coord = $coor_grupo['geometry']['coordinates'][0];
                        foreach($vet_coord as $coor) {
                            array_push($linha, new LatLng(['lat' => $coor[1],   'lng' => $coor[0]]));
                        }
                        $polyline = new Polyline([
                            'path' => $linha,
                            'strokeColor' => 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')',
                            'strokeOpacity' => 1,
                            'strokeWeight' => 3,
                        ]);
                        $map->addOverlay($polyline);

                    }

                    $polygon = new Polygon([
                        'paths' => $coords
                    ]);

                    // Add a shared info window
                    $polygon->attachInfoWindow(new InfoWindow([
                        'content' => '<p>This is my super cool Polygon</p>'
                    ]));

                    // Add it now to the map
                    $map->addOverlay($polygon);
                    // $map->addOverlay($polyline);


                    // Lets show the BicyclingLayer :)
                    $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);

                    // Append its resulting script
                    $map->appendScript($bikeLayer->getJs());

                    // Display the map -finally :)
                    echo $map->display();
                
                ?>
                </div>
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
