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

// MAPA fim

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => $model->contrato->titulo, 'url' => ['contrato/view?id=1']];
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['/empreendimento']];
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
</style>
<div class="empreendimento-index">

    <div class="row">
        <div class="row">
            <div class="col-md-12 pt-2 py-2">
                <?= Html::a('Voltar aos Empreendimentos <<', ['/empreendimento'], ['class' => 'btn btn-info text-white float-right']) ?>
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
                        <?= Html::a('<i class="bi bi-pencil"></i> Editar', $url.'update?id='.$model->id, [
                            'class' => 'btn btn-link p-1 px-0 mx-1 float-right'
                        ]); ?>

                    </div>
                </div>
                <div class="card my-3 py-3">
                    <div class="card-body">
                        <h3>Estágio do licenciamento</h3>
                        <?php $url = Yii::$app->homeUrl ?>
                        <?= Html::a('Acessar', $url.'empreendimento/empgerencial?id='.$model->id, [
                            'class' => 'btn btn-info text-white p-1 px-5 mx-1'
                        ]) ?>
                        <p class="card-text"><?php foreach ($model->licenciamentos as $lic): ?>
                            <div class="my-5">
                            <h3><strong><?= $lic->numero ?></strong></h3>
                            <p><descricao><?= $lic->descricao ?></descricao></p>
                            <?php 
                                $total_etapas = Fase::find()->where([
                                    'licenciamento_id' => $lic->id
                                ])->count();
                                // echo 'Etapas: '.$total_etapas;
                                $total_etapas_concluidas = Fase::find()->where([
                                    'licenciamento_id' => $lic->id,
                                    'status' => 'Concluído'
                                ])->count();
                                // echo '<br>Etapas_concluidas: '.$total_etapas_concluidas;
                                $porcent_etapas_concluidas = 0;
                                $progressbaranimated = 'progress-bar-striped progress-bar-animated';
                                if ($total_etapas > 0) {
                                    $porcent_etapas_concluidas = ($total_etapas_concluidas * 100)/$total_etapas;
                                    if ($porcent_etapas_concluidas == 100) {
                                        $progressbaranimated = '';
                                    }
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
                <div class="card">
                <h4 class="card-header bg-gray">🌐 Mapa e marcadores</h4>
                <?php 
                    // Opções do Mapa

                    // $coord = new LatLng(['lat' => -27.5969, 'lng' => -48.5495]);
                    // Manaus
                    $coord = new LatLng(['lat' => -15.7801, 'lng' => -47.9292]);
                    $map = new Map([
                        'center' => $coord,
                        'zoom' => 7,
                        'mapTypeId' => 'hybrid',
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
                    
                    echo '<pre>';
                    // print_r($json_data_1);
                    // print_r($json_data_1);
                    // print_r($json_data_2);
                    // print_r($json_data_3);
                    // print_r($json_data_4);
                    echo '</pre>';
                    
                    // FOREACHS que IMPRIMEM OS MAPAS ===================================================================
                    $vet_coord_grupo = $json_data_1['features'];
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
                        // $opcoes = new PolylineOptions([
                        //     'strokeColor' => '#FF0000',
                        //     'strokeOpacity' => 0.8,
                        //     'strokeWeight' => 2,
                        // ]);
                        $polyline = new Polyline([
                            'path' => $linha,
                            'options' => [
                                'strokeColor' => '#FF0000',
                                'strokeOpacity' => 0.8,
                                'strokeWeight' => 2
                            ],
                            // 'options' => $opcoes,
                            // 'strokeColor' => 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')',
                            // 'strokeOpacity' => 1,
                            // 'strokeWeight' => 5
                        ]);
                        $marker = new Marker([
                            'position' => $linha[0], // Posição do rótulo
                            'label' => ' '.$coor_grupo['properties']['Name'],
                            'icon' => 'flag'
                        ]);
                        // $polyline->attachEvent('mouseover', $marker);
                        // $polyline->options->label = 'Sua etiqueta aqui';
                        // $polyline->attachInfoWindow(new InfoWindow([
                        //     'content' => '<p>This is my super cool Polygon</p>'
                        // ]));
                        $map->addOverlay($polyline);
                        $map->addOverlay($marker);
                        
                    }
                    $vet_coord_grupo = $json_data_2['features'];
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
                        $marker = new Marker([
                            'position' => $linha[0], // Posição do rótulo
                            'title' => '<div style="color: white !important">'.$coor_grupo['properties']['Name'].'</div>',
                            'icon' => 'flag'
                                
                        ]);
                        // $marker->setLabelStyle(['color' => 'blue']);
                        $map->addOverlay($polyline);
                        $map->addOverlay($marker);
                        
                    }
                    $vet_coord_grupo = $json_data_3['features'];
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
                        $marker = new Marker([
                            'position' => $linha[0], // Posição do rótulo
                            'label' => ' '.$coor_grupo['properties']['Name'],
                            'icon' => 'flag'
                        ]);
                        $map->addOverlay($polyline);
                        $map->addOverlay($marker);
                        
                    }
                    $vet_coord_grupo = $json_data_4['features'];
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
                        // $marker = new Marker([
                        //     'position' => $linha[0], // Posição do rótulo
                        //     'label' => ' '.$coor_grupo['properties']['Name']
                        // ]);
                        $map->addOverlay($polyline);
                        // $map->addOverlay($marker);
                        
                    }
                    // FOREACHS que IMPRIMEM OS MAPAS ===================================================================

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
