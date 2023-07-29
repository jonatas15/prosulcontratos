<?php
#########################################################################
##########  Fazer 5 gráficos PIZZA pra relação tipos - status ###########
#########################################################################

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Accordion;

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
// $this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
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
    .nav-link.active {
        background-color: gray !important;
        color: white !important;
    }
</style>
<div class="contrato-view">

    <h3 class="text-uppercase"><img src="<?=Yii::$app->homeUrl?>logo/contract-icon.png" class="icone-modulo" width="25" /> <?= Html::encode($this->title) ?></h3>
    <hr>
    
    
    <?php $detalhamento = '<div class="col-md-6">'.DetailView::widget([
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
    ]).'</div>';  
    
    // Opções do Mapa

    $coord = new LatLng(['lat' => -27.5969, 'lng' => -48.5495]);
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
        
        <?php 
            echo Accordion::widget([
                'items' => [
                    [
                        'label' => '🌐 Ver o Mapa',
                        'content' => '<div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                30%
                            </div>
                        </div>'.$map->display(),
                        // 'contentOptions' => ['class' => 'in']
                        // 'clientOptions' => ['collapsible' => true, 'active' => false],
                        'clientOptions' => ['active' => 0]
                    ]
                ]
            ]);
        ?>
        <?php //= $map->display(); ?>
    </div>
    <div class="row">
        <div class="clearfix"></div>
        <br>
    </div>
    <div class="row">
        <!-- <div class="col"></div> -->
        <div class="col">
            <a target="_blank" class="btn btn-primary text-white" style="width:100%;font-weight:bolder" href="http://prosul.bmt.eng.br/#/empreendimentos?contrato_id=1">
                Empreendimentos
            </a>
        </div>
        <div class="col">
            <a target="_blank" class="btn btn-primary text-white" style="width:100%;font-weight:bolder" href="https://drive.google.com/drive/u/0/folders/17tibbErWqOxvXvrIPxtuIeiaVP1ta4vQ">
                Equipe
            </a>
        </div>
        <div class="col">
            <a target="_blank" class="btn btn-primary text-white" style="width:100%;font-weight:bolder" href="https://drive.google.com/drive/u/0/folders/1h9QY9ybCKnFm6uh3P9FAKbReBGlSX3aM">
                Cronograma
            </a>
        </div>
        <div class="col">
            <a target="_blank" class="btn btn-primary text-white" style="width:100%;font-weight:bolder" href="https://drive.google.com/drive/u/0/folders/1rTVS4XHhvJFJTRP5fmWe_WkEFdP4dwhS">
                Impacto Contratual
            </a>
        </div>
        <div class="col">
            <a target="_blank" class="btn btn-primary text-white" style="width:100%;font-weight:bolder" href="https://docs.google.com/spreadsheets/d/1ykXt_3lxOgUdw0l9SLUMDacd-ym1pHmR/edit#gid=574077694">
                Monitoramento Contratual
            </a>
        </div>
    </div>
    <div class="row">
        <div class="clearfix"></div>
        <br>
    </div>
    <div class="row">
        <?php 
            ############################ GESTÃO DE OFÍCIOS ###############################
            $searchModelOficio = new \app\models\OficioSearch();
            $dataProviderOficio = $searchModelOficio->search(['contrato_id'=>$model->id]);
            $gestaooficios = '<div class="row">';
            $gestaooficios .= '<div class="col-md-12">';
            $gestaooficios .= '<br>';
            $gestaooficios .= $this->render('/oficio/indexcontrato', [
                'searchModel' => $searchModelOficio,
                'dataProvider' => $dataProviderOficio,
                'contrato_id' => $model->id
            ]);
            $gestaooficios .= '</div>';
            $gestaooficios .= '</div>';
            ############################# ORDENS DE SERVIÇO #############################
            $searchModelOrdens = new \app\models\OrdensdeservicoSearch();
            $dataProviderOrdens = $searchModelOrdens->search(['contrato_id'=>$model->id]);
            $gestaoordens = '<div class="row">';
            $gestaoordens .= '<div class="col-md-12">';
            $gestaoordens .= '<br>';
            $gestaoordens .= $this->render('/ordensdeservico/indexcontrato', [
                'searchModel' => $searchModelOrdens,
                'dataProvider' => $dataProviderOrdens,
                'contrato_id' => $model->id
            ]);
            $gestaoordens .= '</div>';
            $gestaoordens .= '</div>';
            ############################# LICENCIAMENTOS ################################
            $searchModelLicenciamento = new \app\models\LicenciamentoSearch();
            $dataProviderLicenciamento = $searchModelLicenciamento->search(['contrato_id'=>$model->id]);
            $gestaolicenciamento = '<div class="row">';
            $gestaolicenciamento .= '<div class="col-md-12">';
            $gestaolicenciamento .= '<br>';
            $gestaolicenciamento .= $this->render('/licenciamento/indexcontrato', [
                'searchModel' => $searchModelLicenciamento,
                'dataProvider' => $dataProviderLicenciamento,
                'contrato_id' => $model->id
            ]);
            $gestaolicenciamento .= '</div>';
            $gestaolicenciamento .= '</div>';
            ################################ PRODUTOS ###################################
            $searchModelProduto = new \app\models\ProdutoSearch();
            $dataProviderProduto = $searchModelProduto->search(['contrato_id'=>$model->id]);
            $gestaoprodutos = '<div class="row">';
            $gestaoprodutos .= '<div class="col-md-12">';
            $gestaoprodutos .= '<br>';
            $gestaoprodutos .= $this->render('/produto/indexcontrato', [
                'searchModel' => $searchModelProduto,
                'dataProvider' => $dataProviderProduto,
                'contrato_id' => $model->id
            ]);
            $gestaoprodutos .= '</div>';
            $gestaoprodutos .= '</div>';
            ################################ IMPACTOS ###################################
            $searchModelImpacto = new \app\models\ImpactoSearch();
            $dataProviderImpacto = $searchModelImpacto->search(['contrato_id'=>$model->id]);
            $gestaoimpactos = '<div class="row">';
            $gestaoimpactos .= '<div class="col-md-12">';
            $gestaoimpactos .= '<br>';
            $gestaoimpactos .= $this->render('impactoscontratuais', [
                'searchModel' => $searchModelImpacto,
                'dataProvider' => $dataProviderImpacto,
                'contrato_id' => $model->id
            ]);
            $gestaoimpactos .= '</div>';
            $gestaoimpactos .= '</div>';
            #############################################################################
            $ativo = $_REQUEST['abativa'];
            switch ($ativo) {
                case 'aba_dados':
                    $aba_dados = true;
                    $aba_oficios = false;
                    $aba_ordens = false;
                    $aba_licensas = false;
                    $aba_produtos = false;
                    $aba_imactos = false;
                    break;
                case 'aba_oficios':
                    $aba_dados = false;
                    $aba_oficios = true;
                    $aba_ordens = false;
                    $aba_licensas = false;
                    $aba_produtos = false;
                    $aba_imactos = false;
                    break;
                case 'aba_ordens':
                    $aba_dados = false;
                    $aba_oficios = false;
                    $aba_ordens = true;
                    $aba_licensas = false;
                    $aba_produtos = false;
                    $aba_imactos = false;
                    break;
                case 'aba_licensas':
                    $aba_dados = false;
                    $aba_oficios = false;
                    $aba_ordens = false;
                    $aba_licensas = true;
                    $aba_produtos = false;
                    $aba_imactos = false;
                    break;
                case 'aba_produtos':
                    $aba_dados = false;
                    $aba_oficios = false;
                    $aba_ordens = false;
                    $aba_licensas = false;
                    $aba_produtos = true;
                    $aba_imactos = false;
                    break;
                case 'aba_impactos':
                    $aba_dados = false;
                    $aba_oficios = false;
                    $aba_ordens = false;
                    $aba_licensas = false;
                    $aba_produtos = false;
                    $aba_imactos = true;
                    break;
                
                default:
                    
                    break;
            }
            echo Tabs::widget([
                'items' => [
                    [
                        'label' => '📄 Dados Contratuais',
                        'content' => '<div class="row">'.$this->render('update', [
                            'model' => $model
                        ]).'</div>',
                        'options' => ['id' => 'aba_dados'],
                        'active' => $aba_dados
                    ],
                    [
                        'label' => '📋 Impactos Contratuais',
                        'content' => $gestaoimpactos,
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_impactos'],
                        'active' => $aba_impactos
                    ],
                    [
                        'label' => '📋 Gestão de Ofícios',
                        'content' => $gestaooficios,
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_oficios'],
                        'active' => $aba_oficios
                    ],
                    [
                        'label' => '📋 Ordens de Serviço',
                        'content' => $gestaoordens,
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_ordens'],
                        'active' => $aba_ordens
                    ],
                    [
                        'label' => '📋 Licenciamentos',
                        'content' => $gestaolicenciamento,
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_licensas'],
                        'active' => $aba_licensas
                    ],
                    [
                        'label' => '📋 Produtos',
                        'content' => $gestaoprodutos,
                        'headerOptions' => ['...'],
                        'options' => ['id' => 'aba_produtos'],
                        'active' => $aba_produtos
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
<?php 
$this->registerJs(<<<JS
    $('#w1-collapse0').collapse("hide");
JS);
?>


