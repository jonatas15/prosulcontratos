<?php

use app\models\Oficio;
use app\models\Empreendimento;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
// use dosamigos\datepicker\DatePicker;
use miloschuman\highcharts\Highcharts;

$anovigente = '2024';

use yii\bootstrap5\Accordion;
use app\models\UsuarioHasContrato as UHC;
use app\models\UsuarioHasEmpreendimento as UHE;
$empreendimentos_permitidos = UHE::findAll(['usuario_id' => Yii::$app->user->identity->id]);
$ids_permitidos = [];
$nomes_permitidos = [];
foreach ($empreendimentos_permitidos as $k) {
    array_push ($ids_permitidos, $k->empreendimento_id);
    array_push ($nomes_permitidos, $k->empreendimento->titulo);
    // echo $k->empreendimento_id;
}
//->andWhere(['IN', 'id', $ids_permitidos])

// use yii\bootstrap5\Modal;
// Modal::begin([
//         'title' => '<h2>Hello world</h2>',
//         'toggleButton' => ['label' => 'click me'],
//         'options' => [
//             'tabindex' => "false"
//         ]
//     ]);
    
//     echo 'Say hello...';
    
//     Modal::end();
// use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OficioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

// $this->title = 'Oficios';
// $dataProvider->pagination->pageSize=4;
// $this->params['breadcrumbs'][] = $this->title;

// GLOBAIS !!! 
Yii::$app->params['contratoidGlobal'] = $contrato_id;


?>
<style>
    [type="checkbox"] {
        /* width: 20px;
        height: 20px; */
    }
    [type="radio"] {
        /* width: 15px;
        height: 15px; */
    }
    .pesquisa-roa {
        background-color: ghostwhite;
        /* padding: 1%; */
        border-radius: 10px;
        /* margin-top: 1%; */
        margin-bottom: 1%;
        padding-top:1%
    }
    .btn-success-green {
        background-color: green !important;
        border-color: green !important;
    }
    .expoente-zoom {
        background-color: white;
        color: black;
        padding: 4px;
        position: absolute;
        border-radius: 20px;
        width: 25px;
        height: 25px;
        text-align: center;
        font-size: 14px;
        font-weight: normal;
    }
    .input-group-addon {
        padding: 0 10px !important;
        padding-top: 5px !important;
    }
    .datepicker {
        z-index: 1151 !important;
    }
    .text-status {
        color: red !important;
        text-transform: capitalize !important;
    }
    .input-group-addon {
        background-color: gainsboro;
    }
</style>
<div class="oficio-index mt-5">

    <h3>
        <img src="<?=Yii::$app->homeUrl?>logo/upload-files-icon.png" class="icone-modulo" width="25" /> <span class="text-primary text-opacity-50 fs-5">Contrato: <?=$contrato->titulo?></span><br><b>Gestão de Ofícios</b>
    </h3>
    <div class="row">
        <div class="col-md-12">
            <?php if(Yii::$app->user->identity->nivel != 'fiscal'): ?>
            <?php $modelnovooficio = new Oficio(); ?>
            <?= $this->render('create', [
                'model' => $modelnovooficio,
                'contrato_id' => $contrato_id
            ]) ?>
            <?php endif; ?>
        </div>
    </div>
    <?php /**
    <p>
        <?= Html::a('Create Oficio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    */?>
    <?php /*  // echo $this->render('_search', ['model' => $searchModel]);
        use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

        $path = Yii::$app->basePath.'/web/arquivos/loteA.xlsx';
        # open the file
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($path);
        # read each cell of each row of each sheet
        echo '<table border="2">';
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                echo '<tr>';
                // foreach ($row->getCells() as $cell) {
                //     echo '<td>'.$cell->getValue().'</td>';
                // }
                // echo $row->getCells()[0];
                echo '<td>'.$row->getCells()[0].'</td>'; # ID
                echo '<td>'.$row->getCells()[1].'</td>'; # Tipo
                echo '<td>'.$row->getCells()[2].'</td>'; # Empreendimento
                echo '<td>'.$row->getCells()[3].'</td>'; # Data
                echo '<td>'.$row->getCells()[4].'</td>'; # Fluxo
                echo '<td>'.$row->getCells()[5].'</td>'; # Emissor
                echo '<td>'.$row->getCells()[6].'</td>'; # Receptor	
                echo '<td>'.$row->getCells()[7].'</td>'; # Nº do Processo	
                // echo '<td>'.$row->getCells()[8].'</td>'; # Nº do Protocolo	
                echo '<td>'.$row->getCells()[9].'</td>'; # Nº do SEI	
                // echo '<td>'.$row->getCells()[10].'</td>'; # Assunto
                echo '<td>'.$row->getCells()[11].'</td>'; # Diretório
                echo '<td>'.$row->getCells()[12].'</td>'; # Status
                echo '<td>'.$id.'</td>'; # Status
                
                 $novooficio = new Oficio();
                 //Campos importados
                 
                 // Ajeitando a data
                 $datacerta = explode("/", (string)$row->getCells()[3]);

                 $novooficio->tipo = (string)$row->getCells()[1];
                 $novooficio->emprrendimento_desc = (string)$row->getCells()[2];
                 $novooficio->data = $datacerta[2].'-'.$datacerta[1].'-'.$datacerta[0];
                 $novooficio->fluxo = (string)$row->getCells()[4];
                 $novooficio->emissor = (string)$row->getCells()[5];
                 $novooficio->receptor = (string)$row->getCells()[6];
                $novooficio->num_processo = (string)$row->getCells()[7];
                $novooficio->num_protocolo = (string)$row->getCells()[8];
                $novooficio->Num_sei = (string)$row->getCells()[9];
                $novooficio->assunto = (string)$row->getCells()[10];
                $novooficio->diretorio = (string)$row->getCells()[11];
                $novooficio->status = (string)$row->getCells()[12];
                //Definições
                $novooficio->link_diretorio = 'definir';
                $novooficio->contrato_id = 2;
                $novooficio->datacadastro = date('Y-m-d H:i:s');
                //Definições
                // echo '<td>';
                // if ($novooficio->save()) {
                //     echo "deu certo";
                // } else {
                //     echo "não deu certo";
                // }
                // echo '</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
        $reader->close();
         */
    ?>
    <div class="clearfix">
        <br />
    </div>
    <?php
        ########################################## TIPO ##########################################
        // $search_empreendimentos = Oficio::find()->select('emprrendimento_desc, count(emprrendimento_desc) as contagem_emp')->groupBy('emprrendimento_desc')->all();
        // $lista_empreendimentos = [];
        // foreach ($search_empreendimentos as $value):
        //     $lista_empreendimentos[$value->emprrendimento_desc] = $value->emprrendimento_desc;
        //     $lista_empreendimentos[$value->emprrendimento_desc.'(count)'] = $value->contagem_emp;
        // endforeach;
        ######################################### STATUS #########################################
        // $search_status = Oficio::find()->select('status')->groupBy('status')->all();
        // $lista_status = [];
        // foreach ($search_status as $value):
        //     $lista_status[$value->status] = $value->status;
        // endforeach;
        ########################################## AVAL ##########################################
        // echo '<pre>';
        // print_r($lista_empreendimentos);
        // echo '</pre>';
    ?>
    <?php 
    
    
    Pjax::begin([
        'id' => 'admin-crud-id-roa', 
        'timeout' => false,
        'enablePushState' => false
    ]); ?>
    
    <?php 
        $req = Yii::$app->request;
        $request = $req->get('OficioSearch');
        $pesquisou = $req->getBodyParam('OficioSearch');
        // echo 'O pre';
        // echo '<pre>';
        // print_r($pesquisou);
        // echo '</pre>';
        // echo "vai ".$pesquisou->Num_sei;
        // echo '<br>';
        // if ($req->isAjax) {
        //     echo "the request is AJAX";
        //  }
        // exit;

        $s_nsei = $pesquisou['Num_sei'] ? $pesquisou['Num_sei'] : '';
        $s_tipo = $pesquisou['tipo'] ? $pesquisou['tipo'] : '';
        $ano_listagem = $_REQUEST['OficioSearch']['ano_listagem'] ? $_REQUEST['OficioSearch']['ano_listagem'] : '';
        $status = $_REQUEST['OficioSearch']['status'] ? $_REQUEST['OficioSearch']['status'] : '';
        # Intervalo de data #######################################################################
        $data_ini = $_REQUEST['from_date'];
        $data_fim = $_REQUEST['to_date'];
        $datainicial = $data_ini;
        $datafinial = $data_fim;
        $intervalo_data = $_REQUEST['OficioSearch']['intervalo_data'];
        $emprrendimento_desc = $_REQUEST['OficioSearch']['emprrendimento_desc'];
        
        // echo Yii::$app->formatter->asDate($data_ini, 'yyyy-MM-dd');
        if (!empty($data_ini) AND !empty($data_fim)) :
            $ar = explode('/', $data_ini);
            $data_ini = $ar[2].'-'.$ar[1].'-'.$ar[0];
            $ar2 = explode('/', $data_fim);
            $data_fim = $ar2[2].'-'.$ar2[1].'-'.$ar2[0];
            $dataProvider = $searchModel->search([
                'from_date'=> $data_ini,
                'to_date'=> $data_fim,
            ]);
        endif;
        $campo_status_1 = "";
        $campo_status_2 = "";
        $campo_status_3 = "";
        $campo_status_4 = "";
        if (!empty($status)) :
            echo $status[4];
            if($status[1]) { $campo_status_1 = 'checked="checked"'; }
            if($status[2]) { $campo_status_2 = 'checked="checked"'; }
            if($status[3]) { $campo_status_3 = 'checked="checked"'; }
            if($status[4]) { $campo_status_4 = 'checked="checked"'; }
            // $st = 1;
            // for ($i=1; $i < 4; $i++) { 
            //     if($status[$i] !== "") { $campo_status = 'checked="checked"'; }
            // }
        endif;
        if (empty($data_ini) AND empty($data_fim)) :
            if (!empty($intervalo_data)) :
                switch ($intervalo_data) {
                    case 'check-ultimos-dias':
                        $date = new DateTime('7 days ago');
                        
                        $data_ini = $date->format('Y-m-d');
                        $data_fim = date('Y-m-d');
                        
                        $radiosete = 'checked="checked"';
                    break;
                    case 'check-ultimo-mes':
                        $date = new DateTime('30 days ago');
                        
                        $data_ini = $date->format('Y-m-d');
                        $data_fim = date('Y-m-d');
                        
                        $radiotrinta = 'checked="checked"';
                        break;
                        case 'check-hoje':
                        $data_ini = date('Y-m-d');
                        $data_fim = date('Y-m-d');
                        
                        $radiohoje = 'checked="checked"';
                    break;
                }        
            endif;
        endif;
        $dataProvider = $searchModel->search([
            'tipo' => $s_tipo,
            'Num_sei' => $s_nsei,
            'from_date'=> $data_ini,
            'to_date'=> $data_fim,
            'ano_listagem' => $ano_listagem,
            'status' => $status,
            'emprrendimento_desc' => $emprrendimento_desc,
        ]);
    ?>
    <div class="row">
        <?php /** 
        <div class="col">
            <?php
                $NT = Oficio::find()->where([
                    'tipo' => 'NT'
                ])->count();
                $OfíciosDNIT = Oficio::find()->where([
                    'tipo' => 'Ofícios DNIT'
                ])->count();
                $OfíciosProsul = Oficio::find()->where([
                    'tipo' => 'Ofícios Prosul'
                ])->count();
                $OS = Oficio::find()->where([
                    'tipo' => 'OS'
                ])->count();
                $OSE = Oficio::find()->where([
                    'tipo' => 'OSE'
                ])->count();
                echo Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'bar'
                        ],
                        'title' => ['text' => 'Tipos de Registro'],
                        'xAxis' => [
                            'categories' => [
                                'NT',
                                'Ofícios DNIT',
                                'Ofícios Prosul',
                                'OS',
                                'OSE',
                            ]
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'Tipos']
                        ],
                        // 'legend' => [
                        //     'layout' => 'vertical',
                        //     'align' => 'right',
                        // ],
                        'series' =>  [
                            [
                                'name' => 'Tipo',
                                'data' => [
                                    [
                                        'name' => 'NT',
                                        'y' => $NT,
                                        'color' => 'cyan',
                                    ],
                                    [
                                        'name' => 'Ofícios DNIT',
                                        'y' => $OfíciosDNIT,
                                        'color' => '#40E0D0',
                                    ],
                                    [
                                        'name' => 'Ofícios Prosul',
                                        'y' => $OfíciosProsul,
                                        'color' => 'blue',
                                    ],
                                    [
                                        'name' => 'OS',
                                        'y' => $OS,
                                        'color' => 'orange',
                                    ],
                                    [
                                        'name' => 'OSE',
                                        'y' => $OSE,
                                        'color' => 'red',
                                    ],
                                ],
                                'showInLegend' => false,
                                'dataLabels' => [
                                    'enabled' => true,
                                ],
                            ],
                        ],
                    ]
                ]);
            ?>
        </div>
        */?>
        <div class="col">
            <?php
                function retornaserie ($campo, $status, $ano, $mes) {
                    global $contratoidGlobal;
                    $contagem = Oficio::find()->where([
                        $campo => $status,
                        'YEAR(data)' => $ano,
                        'MONTH(data)' => $mes,
                        'contrato_id' => Yii::$app->params['contratoidGlobal']
                    ])->count();
                    return $contagem;
                }
                function retornatipo ($campo, $status, $tipo, $dataProvider) {
                    // $contagem = Oficio::find()->where([
                    //     $campo => $status,
                    //     'tipo' => $tipo
                    // ])->count();
                    // Talvez pelo Provider Aqui
                    $contagem = 0;
                    foreach($dataProvider->getModels() as $item) {
                        if ( $item->$campo == $status && $item->tipo == $tipo) {
                            $contagem++;
                        }
                    }
                    return $contagem;
                }

                $graf_temporal = Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column'
                        ],
                        'title' => ['text' => 'Todos os Registros ('.$anovigente.')'],
                        'xAxis' => [
                            'categories' => [
                                'Janeiro',
                                'Fevereiro',
                                'Março',
                                'Abril',
                                'Maio',
                                'Junho',
                                'Julho',
                                'Agosto',
                                'Setembro',
                                'Outubro',
                                'Novembro',
                                'Dezembro',
                            ]
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'Status']
                        ],
                        'series' => [
                            [
                                'name' => 'Não Resolvido',
                                'cursor' => 'pointer',
                                "point" => [
                                    "events" => [
                                        "click" => new JsExpression('function(){
                                            // console.log(this);
                                            $(":checkbox[value=\'Não Resolvido\']").prop("checked","true");
                                            $("#form-pesquisa-oficios").submit();
                                        }')
                                    ],
                                ],
                                'data' => [
                                    retornaserie('status', 'Não Resolvido', $anovigente, '01'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '02'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '03'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '04'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '05'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '06'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '07'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '08'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '09'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '10'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '11'),
                                    retornaserie('status', 'Não Resolvido', $anovigente, '12'),
                                ], 
                                'color' => 'red'
                            ],
                            [
                                'name' => 'Resolvido',
                                'cursor' => 'pointer',
                                "point" => [
                                    "events" => [
                                        "click" => new JsExpression('function(){
                                            // console.log(this);
                                            $(":checkbox[value=\'Resolvido\']").prop("checked","true");
                                            $("#form-pesquisa-oficios").submit();
                                        }')
                                    ],
                                ],
                                'data' => [
                                    retornaserie('status', 'Resolvido', $anovigente, '01'),
                                    retornaserie('status', 'Resolvido', $anovigente, '02'),
                                    retornaserie('status', 'Resolvido', $anovigente, '03'),
                                    retornaserie('status', 'Resolvido', $anovigente, '04'),
                                    retornaserie('status', 'Resolvido', $anovigente, '05'),
                                    retornaserie('status', 'Resolvido', $anovigente, '06'),
                                    retornaserie('status', 'Resolvido', $anovigente, '07'),
                                    retornaserie('status', 'Resolvido', $anovigente, '08'),
                                    retornaserie('status', 'Resolvido', $anovigente, '09'),
                                    retornaserie('status', 'Resolvido', $anovigente, '10'),
                                    retornaserie('status', 'Resolvido', $anovigente, '11'),
                                    retornaserie('status', 'Resolvido', $anovigente, '12'),
                                ], 
                                'color' => 'lightgreen'
                            ],
                            [
                                'name' => 'Informativo', 
                                'cursor' => 'pointer',
                                "point" => [
                                    "events" => [
                                        "click" => new JsExpression('function(){
                                            // console.log(this);
                                            $(":checkbox[value=\'Informativo\']").prop("checked","true");
                                            $("#form-pesquisa-oficios").submit();
                                        }')
                                    ],
                                ],
                                'data' => [
                                    retornaserie('status', 'Informativo', $anovigente, '01'),
                                    retornaserie('status', 'Informativo', $anovigente, '02'),
                                    retornaserie('status', 'Informativo', $anovigente, '03'),
                                    retornaserie('status', 'Informativo', $anovigente, '04'),
                                    retornaserie('status', 'Informativo', $anovigente, '05'),
                                    retornaserie('status', 'Informativo', $anovigente, '06'),
                                    retornaserie('status', 'Informativo', $anovigente, '07'),
                                    retornaserie('status', 'Informativo', $anovigente, '08'),
                                    retornaserie('status', 'Informativo', $anovigente, '09'),
                                    retornaserie('status', 'Informativo', $anovigente, '10'),
                                    retornaserie('status', 'Informativo', $anovigente, '11'),
                                    retornaserie('status', 'Informativo', $anovigente, '12'),
                                ], 
                                'color' => 'lightgray'
                            ],
                            [
                                'name' => 'Em Andamento',
                                'cursor' => 'pointer',
                                "point" => [
                                    "events" => [
                                        "click" => new JsExpression('function(){
                                            // console.log(this);
                                            $(":checkbox[value=\'Em Andamento\']").prop("checked","true");
                                            $("#form-pesquisa-oficios").submit();
                                        }')
                                    ],
                                ],
                                'data' => [
                                    retornaserie('status', 'Em Andamento', $anovigente, '01'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '02'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '03'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '04'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '05'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '06'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '07'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '08'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '09'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '10'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '11'),
                                    retornaserie('status', 'Em Andamento', $anovigente, '12'),
                                ], 
                                'color' => '#f3f0c6'
                            ],
                            [
                                'type' => 'spline',
                                'name' => 'Emissor: CGMAB',
                                'data' => [
                                    retornaserie('emissor', 'CGMAB', $anovigente, '01'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '02'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '03'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '04'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '05'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '06'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '07'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '08'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '09'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '10'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '11'),
                                    retornaserie('emissor', 'CGMAB', $anovigente, '12'),
                                ],
                                'marker' => [
                                    'lineWidth' => 2
                                ],
                            ],
                            [
                                'type' => 'spline',
                                'name' => 'Emissor: PROSUL',
                                'data' => [
                                    retornaserie('emissor', 'PROSUL', $anovigente, '01'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '02'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '03'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '04'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '05'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '06'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '07'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '08'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '09'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '10'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '11'),
                                    retornaserie('emissor', 'PROSUL', $anovigente, '12'),
                                ],
                                'marker' => [
                                    'lineWidth' => 2
                                ],
                            ],
                            [
                                'type' => 'spline',
                                'name' => 'Empreendimento: Administrativo',
                                'data' => [
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '01'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '02'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '03'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '04'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '05'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '06'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '07'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '08'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '09'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '10'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '11'),
                                    retornaserie('emprrendimento_desc', 'Administrativo', $anovigente, '12'),
                                ],
                                'marker' => [
                                    'lineWidth' => 2
                                ],
                            ],      
                        ]
                    ]
                ]);
            
            ?>
        </div>
    </div>
    <div class="row">
        <hr>
    </div>
    <div class="row">
        <div class="col">
            <?php
                $graf_tipos_status = "";
                $graf_tipos_status .= '<div class="row"><div class="col">';

                $resolvidos = Oficio::find()->where([
                    'status' => 'Resolvido',
                    'contrato_id' => Yii::$app->params['contratoidGlobal']
                ])->count();
                $nao_resolvidos = Oficio::find()->where([
                    'status' => 'Não resolvido',
                    'contrato_id' => Yii::$app->params['contratoidGlobal']
                ])->count();
                $informativos = Oficio::find()->where([
                    'status' => 'Informativo',
                    'contrato_id' => Yii::$app->params['contratoidGlobal']
                ])->count();
                $em_andamento = Oficio::find()->where([
                    'status' => 'Em Andamento',
                    'contrato_id' => Yii::$app->params['contratoidGlobal']
                ])->count();
                $graf_tipos_status .= Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'pie'
                        ],
                        'title' => ['text' => 'Status (Todos os registros)'],
                        'yAxis' => [
                            'title' => ['text' => 'Status']
                        ],
                        // 'legend' => [
                        //     'layout' => 'vertical',
                        //     'align' => 'right',
                        // ],
                        'series' =>  [
                            [
                                'name' => 'Status',
                                "cursor" => "pointer",
                                "point" => [
                                    "events" => [
                                        "click" => new JsExpression('function(){
                                            $(":checkbox[value=\'" + this.options.name + "\']").prop("checked","true");
                                            $("#form-pesquisa-oficios").submit();
                                        }')
                                    ],
                                ],
                                'data' => [
                                    [
                                        'name' => 'Informativo',
                                        'y' => $informativos,
                                        'color' => 'lightgray'
                                    ],
                                    [
                                        'name' => 'Em Andamento',
                                        'y' => $em_andamento,
                                        'color' => '#f3f0c6',
                                    ],
                                    [
                                        'name' => 'Resolvido',
                                        'y' => $resolvidos,
                                        'color' => 'lightgreen',
                                    ],
                                    [
                                        'name' => 'Não Resolvido',
                                        'y' => $nao_resolvidos,
                                        'color' => 'red',
                                    ],
                                ],
                                'showInLegend' => true,
                                'dataLabels' => [
                                    'enabled' => false,
                                ],
                            ],
                        ],
                    ]
                ]);
                $graf_tipos_status .= "</div>";
            ?>
        </div>
        <?php $tipos = ['NT', 'Ofícios DNIT', 'Ofícios Prosul', 'OS', 'OSE']; ?>
        <?php foreach ($tipos as $tipo): ?>
            <div class="col">
                <?php
                    $tipo_titulo = $tipo;
                    switch ($tipo) {
                        case 'NT': $tipo_titulo = "Notas Técnicas"; break;
                        case 'OS': $tipo_titulo = "Ordens de Serviço"; break;
                        case 'OSE': $tipo_titulo = "Ordens de Serviço Específicas"; break;
                    }
                    $graf_tipos_status .= "<div class='col'>";
                    $graf_tipos_status .= Highcharts::widget([
                        'scripts' => [
                            'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'pie'
                            ],
                            'title' => ['text' => $tipo_titulo],
                            'yAxis' => [
                                'title' => ['text' => 'Status']
                            ],
                            'series' =>  [
                                [
                                    'name' => 'Status',
                                    "cursor" => "pointer",
                                    "point" => [
                                        "events" => [
                                            "click" => new JsExpression('function(){
                                                // console.log(this.options.url)
                                                $(":checkbox[value=\'" + this.options.name + "\']").prop("checked","true");
                                                $("#form-pesquisa-oficios").submit();
                                            }')
                                        ],
                                    ],
                                    'data' => [
                                        [
                                            'name' => 'Informativo',
                                            'y' => retornatipo ('status', 'Informativo', $tipo, $dataProvider),
                                            'color' => 'lightgray',
                                            'url' => 'google.com.br'
                                        ],
                                        [
                                            'name' => 'Em Andamento',
                                            'y' => retornatipo ('status', 'Em Andamento', $tipo, $dataProvider),
                                            'color' => '#f3f0c6',
                                            'url' => 'yahoo.com.br'
                                        ],
                                        [
                                            'name' => 'Resolvido',
                                            'y' => retornatipo ('status', 'Resolvido', $tipo, $dataProvider),
                                            'color' => 'lightgreen',
                                        ],
                                        [
                                            'name' => 'Não Resolvido',
                                            'y' => retornatipo ('status', 'Não Resolvido', $tipo, $dataProvider),
                                            'color' => 'red',
                                        ],
                                    ],
                                    'showInLegend' => true,
                                    'dataLabels' => [
                                        'enabled' => false,
                                    ],
                                ],
                            ],
                        ]
                    ]);
                    $graf_tipos_status .= "</div>";
                    ?>
            </div>
            <?php endforeach; ?>
            <?php $graf_tipos_status .= "</div>"; ?>
    </div>
    <div class="row">
        <?php
            echo Accordion::widget([
                'items' => [
                    [
                        'label' => '⏳ Gráfico: Linha do Tempo',
                        'content' => $graf_temporal,
                        'clientOptions' => ['active' => 0]
                    ],
                    [
                        'label' => '📊 Gráfico: Tipos de Ofício',
                        'content' => $graf_tipos_status,
                        'clientOptions' => ['active' => 0]
                    ]
                ]
            ]);
        ?>
    </div>
    <div class="row">
        <br />
    </div>
    <div class="row mt-0 mb-0 pb-1   pt-1 " style="background-color: white;">
        <h3>
            <center>
                <a class="btn btn-link fs-3" href="#collapsePesquisaOficios"  data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapsePesquisaOficios">
                    Pesquisa <i class="bi bi-arrow-down"></i>
                </a> 
                <a
                    href="<?=Yii::$app->homeUrl."contrato/go?id=$contrato_id&abativa=aba_oficios"?>" 
                    class="btn btn-primary text-white fs-5" 
                    tolltip="" 
                    title="Limpar/Reiniciar"
                >
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </center>
        </h3>
        <!-- <hr> -->
    </div>
    <div id="collapsePesquisaOficios" class="row collapse mb-2" style="background-color: ghostwhite; padding: 10px 5px">
        <!-- <h4 style="padding:5px">Pesquisa:</h4> -->
        <?php $form = ActiveForm::begin(['options' => [
            'data-pjax' => true,
            'autocomplete'=>"off",
            'id' => 'form-pesquisa-oficios'
        ]]); ?>
        <div class="row">
            <div class="col-md-2">
                <label class="control-label summary" for="pagina-roa_programa"><b>SEI</b></label>
                <!-- <br /> -->
                <?= $form->field($searchModel, 'Num_sei')->textInput(['maxlength' => true, 'placeholder' => 'Nº ou trecho'])->label(false) ?>
            </div>
            <div class="col-md-2">
                <?php 
                    $arr_empreendimentos_oficios = [
                        'Administrativo' => 'Administrativo'
                    ];
                    if (\Yii::$app->user->identity->nivel == 'administrador'):
                        $empreendimentos = Oficio::find()->where([
                            'contrato_id' => $contrato_id
                        ])->all();
                    else:
                        $empreendimentos = Oficio::find()->where([
                            'contrato_id' => $contrato_id
                        ])->andFilterWhere([
                            'IN', 'emprrendimento_desc', $nomes_permitidos
                        ])->all();
                    endif;
                    $emp_ref = Empreendimento::find()->where(['IN', 'id', $ids_permitidos])->all();
                    $titulos_empreendimentos_no_sistema = [];
                    foreach ($emp_ref as $emp2) {
                        array_push($titulos_empreendimentos_no_sistema, $emp2->titulo);
                    }
                    foreach ($empreendimentos as $emp) {
                        // if (in_array($emp->emprrendimento_desc, $titulos_empreendimentos_no_sistema))
                        $arr_empreendimentos_oficios[$emp->emprrendimento_desc] = $emp->emprrendimento_desc;
                    }
                    // $lista_emp = ArrayHelper::map($empreendimentos, 'id', 'titulo');
                ?>
                <label class="control-label summary" for="oficio_emprrendimento_desc">Empreendimento</label>
                <?php $lista_emp = $arr_empreendimentos_oficios; ?>
                <?= $form->field($searchModel, 'emprrendimento_desc')->dropDownList($lista_emp, [
                    'prompt' => 'Selecione'
                ])->label(false) ?>
                <!-- Campos de pesquisa ocultos pros gráficos -->
                <input type="hidden" name="por_rv" id="por_rv" value="<?=$_REQUEST['por_rv']?>">
            </div>
            <div class="col-md-4">
                <label class="control-label summary" for="from_date"><b>Por data</b></label>
                <!-- <br /> -->
                <?php
                    $layout3 = '<span class="input-group-addon">De</span>
                    {input1}
                    <span class="input-group-addon">Até</span>
                    {input2}';
                    echo DatePicker::widget([
                        'language' => 'pt-BR',
                        'name' => 'from_date',
                        'value' => ($datainicial?$datainicial:''),
                        'type' => DatePicker::TYPE_RANGE,
                        'name2' => 'to_date',
                        'value2' => ($datafinial?$datafinial:''),
                        'options' => [
                            'placeholder' => 'data inicial',
                            'tabindex' => false
                        ],
                        'options2' => [
                            'placeholder' => 'data final',
                            'tabindex' => false
                        ],
                        'layout' => $layout3, 
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'dd/mm/yyyy',
                            'tabindex' => false
                        ]
                    ]);
                ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'ano_listagem')->dropDownList([
                    'all'=>'Todos os registros',
                    '2024'=>'Ano 2024',
                    '2023'=>'Ano 2023',
                    '2022'=>'Ano 2022',
                ])->label('Ano') ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'tipo')->dropDownList([
                    'all'=>'Selecione o Tipo',
                    'NT' => 'NT',
                    'Ofícios DNIT' => 'Ofícios DNIT',
                    'Ofícios Prosul' => 'Ofícios Prosul',
                    'OS' => 'OS',
                    'OSE' => 'OSE',
                ]) ?>
            </div>
            <div class="col-md-6 card py-1 my-2" style="background-color: transparent; border-radius: 0px !important;">
                <div class="row">
                    <label class="control-label summary"><b>Últimos dias</b></label>
                    <br>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="check-hoje-<?=$tipodepagina?>" style="padding:1%">
                            <input type="radio" name="OficioSearch[intervalo_data]" value="check-hoje" id="check-hoje-<?=$tipodepagina?>" style="" <?=$radiohoje?>>
                            Hoje
                        </label>
                    </div>
                    <div class="col">
                        <label for="check-ultimos-dias-<?=$tipodepagina?>" style="padding:1%">
                            <input type="radio" name="OficioSearch[intervalo_data]" value="check-ultimos-dias" id="check-ultimos-dias-<?=$tipodepagina?>" style="" <?=$radiosete?>>
                            Últimos 7 dias
                        </label>
                    </div>
                    <div class="col">
                        <label for="check-ultimo-mes-<?=$tipodepagina?>" style="padding:1%">
                            <input type="radio" name="OficioSearch[intervalo_data]" value="check-ultimo-mes" id="check-ultimo-mes-<?=$tipodepagina?>" style="" <?=$radiotrinta?>>
                            Últimos 30 dias
                        </label>
                    </div>
                    <div class="col">
                        <label for="check-todos-<?=$tipodepagina?>" style="padding:1%">
                            <input type="radio" name="OficioSearch[intervalo_data]" value="0" id="check-todos-<?=$tipodepagina?>" style="">
                            Todos
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 card py-1 my-2" style="background-color: transparent; border-radius: 0px !important;">
                <div class="row">
                    <label class="control-label summary"><b>Status</b></label>
                    <br>
                </div>
                <div class="row">
                    <?php // = $form->field($searchModel, 'status')->dropDownList([ 'Não Resolvido' => 'Não Resolvido', 'Parcialmente Resolvido' => 'Parcialmente Resolvido', 'Em andamento' => 'Em andamento', 'Resolvido' => 'Resolvido', ], ['prompt' => '']);?>
                    <div class="col"><label for="nao-resolvido-<?=$tipodepagina?>" style="padding:1%">
                        <input type="checkbox" name="OficioSearch[status][1]" value="Informativo" id="nao-resolvido-<?=$id?>" style="" <?=$campo_status_1?>>
                        Informativo
                    </label></div>
                    <div class="col"><label for="parcialmente-resolvido-<?=$tipodepagina?>" style="padding:1%">
                        <input type="checkbox" name="OficioSearch[status][2]" value="Em Andamento" id="parcialmente-resolvido-<?=$id?>" style="" <?=$campo_status_2?>>
                        Em Andamento
                    </label></div>
                    <div class="col"><label for="em-andamento-<?=$tipodepagina?>" style="padding:1%">
                        <input type="checkbox" name="OficioSearch[status][3]" value="Resolvido" id="em-andamento-<?=$id?>" style="" <?=$campo_status_3?>>
                        Resolvido
                    </label></div>
                    <div class="col"><label for="resolvido-<?=$tipodepagina?>" style="padding:1%">
                        <input type="checkbox" name="OficioSearch[status][4]" value="Não Resolvido" id="resolvido-<?=$id?>" style="" <?=$campo_status_4?>>
                        Não Resolvido
                    </label></div>
                    <!-- <label for="forcomunicados" style="padding:1%">
                        <input type="checkbox" name="OficioSearch[comunicados]" value="1" style="" id="forcomunicados" >
                        Com CNC
                    </label> -->
                </div>
            </div>
            <div class="col-md-12 form-group float-right">
                <img id="loading1" src="<?=Yii::$app->homeUrl?>arquivos/loading_blue.gif" width="40" style="float:right;margin-left: 12px;margin-top: -3px;display:none">
                <?php             
                    echo Html::submitButton('Pesquisar', [
                        'class' => 'btn btn-primary',
                        'style'=>'float:right;margin:1%',
                        'id'=>'botao-envia-pesquisa-ajax'
                        // 'onclick'=>'$(this).addClass("disabled");$("#loading1").show();this.form.submit();this.disabled=true;',
                        // 'onmouseup'=>'$(this).addClass("disabled");$("#loading1").show();this.disabled=true;',
                    ]);
                    $this->registerJs(<<<JS
                        $(document).on('pjax:send', function() {
                            $("#loading1").show();
                            $("#botao-envia-pesquisa-ajax").addClass("disabled");
                        });
                        $(document).on('pjax:complete', function() {
                            $('#loading1').hide();
                            $("#botao-envia-pesquisa-ajax").removeClass("disabled");
                        });
                    JS
                    );
                ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'Início',
            'lastPageLabel'  => 'Fim',
            'class' => 'yii\bootstrap5\LinkPager'
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            // 'contrato_id',
            // 'emprrendimento_id',
            // 'tipo',
            [
                'attribute' => 'emprrendimento_desc',
                'format' => 'raw',
                'value' => function($data) {
                    // return '<a class="btn btn-link" target="_blank" href="/empreendimento">'.$data->emprrendimento_desc.'</a>';
                    return $data->emprrendimento_desc;
                }
            ],
            // [
            //     'attribute' => 'id',
            //     'headerOptions' => [
            //         'width' => '3%'
            //     ]
            // ],
            'tipo',
            'fluxo',
            'emissor',
            'receptor',
            // 'emprrendimento_desc',
            //'datacadastro',
            // 'data',
            'Num_sei',
            [
                'attribute' => 'data',
                'value' => function($data) {
                    return date('d/m/Y', strtotime($data->data));
                }
            ],
            //'num_processo',
            //'num_protocolo',
            //'assunto:ntext',
            // 'diretorio',
            [
                'attribute' => 'diretorio',
                'format' => 'raw',
                'value' => function($data) {
                    // return '<a class="btn btn-link" target="_blank" href="'.$data->link_diretorio.'">'.$data->diretorio.'</a>';
                    return '<a class="btn btn-link" target="_blank" href="'.$data->link_diretorio.'" 
                        alt="'.$data->diretorio.'"
                        title="'.$data->diretorio.'"
                    >Acessar</a>';
                    // return $data->emprrendimento_desc;
                }
            ],
            // 'status',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {
                    $corstatus = str_replace(' ','-',$data->status);
                    $corstatus = str_replace('ã','a',$corstatus);
                    $corstatus = strtolower($corstatus);
                    return '<b class="cr-'.$corstatus.'-tx">'.$data->status.'</b>';
                }
            ],
            [
                'attribute' => 'id',
                'header' => 'Detalhes',
                'headerOptions' => [
                    'width' => '5%',
                    'color' => 'red'
                ],
                'format' => 'raw',
                'value' => function($data) {        
                    return '<center>'.$this->render('detalhes', [
                        'id' => $data->id
                    ]).'</center>';
                }
            ],
            [
                'attribute' => 'id',
                'header' => 'Docs',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'format' => 'raw',
                'value' => function($data) {
                    return '<center>'.
                    // $this->render('_docs', [
                    //     'oficio_id' => $data->id
                    //     ])
                    // }
                    "<a class='btn btn-primary' href='".Yii::$app->homeUrl."oficio/update?id=$data->id&abativa=arquivos' target=''>
                        <i class='bi bi-filetype-doc'></i>
                    </a>".
                    '</center>';
                },
                'visible' => in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor']) ? true : false
            ],
            [
                'header' => 'Editar',
                'format' => 'raw',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'value' => function($data) {
                    return '<a href="'.Yii::$app->homeUrl.'oficio/update?id='.$data->id.'" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                },
                'visible' => in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor']) ? true : false
            ],
            [
                'attribute' => 'id',
                'header' => 'MSG',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'format' => 'raw',
                'value' => function($data) {
                    return '<center>'.
                    $this->render('mensagens', [
                        'id' => $data->id
                    ])
                    .'</center>';
                }
            ],
            
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Oficio $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php 
$this->registerJs(<<<JS
    $('#w8-collapse0').collapse("hide");
    $('.accordion').collapse("hide");
JS);
?>