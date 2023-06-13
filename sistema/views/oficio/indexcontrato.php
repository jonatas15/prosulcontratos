<?php

use app\models\Oficio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
// use dosamigos\datepicker\DatePicker;
use miloschuman\highcharts\Highcharts;

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
</style>
<div class="oficio-index">

    <h3><img src="/logo/upload-files-icon.png" class="icone-modulo" width="25" />  Contrato: Gestão de Ofícios</h3>
    <?php /**
    <p>
        <?= Html::a('Create Oficio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    */?>
    <?php /*  // echo $this->render('_search', ['model' => $searchModel]); 
        use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

        $path = Yii::$app->basePath.'/web/arquivo/exportar.xlsx';
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
                $novooficio->contrato_id = $id;
                $novooficio->datacadastro = date('Y-m-d H:i:s');
                //Definições
                echo '<td>';
                if ($novooficio->save()) {
                    echo "loucuuura papai";
                } else {
                    echo "deu m";
                }
                echo '</td>';
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
        $search_tipos = Oficio::find()->select('tipo')->groupBy('tipo')->all();
        $lista_tipos = [];
        foreach ($search_tipos as $value):
            $lista_tipos[$value->tipo] = $value->tipo;
        endforeach;
        ######################################### STATUS #########################################
        // $search_status = Oficio::find()->select('status')->groupBy('status')->all();
        // $lista_status = [];
        // foreach ($search_status as $value):
        //     $lista_status[$value->status] = $value->status;
        // endforeach;
        ########################################## AVAL ##########################################
        // echo '<pre>';
        // print_r($lista_status);
        // echo '</pre>';
    ?>
    <?php 
    
    
    Pjax::begin([
        'id' => 'admin-crud-id-roa', 
        'timeout' => false,
        'enablePushState' => false
    ]); ?>
    
    <?php 



        $s_tipo = $_REQUEST['OficioSearch']['tipo'] ? $_REQUEST['OficioSearch']['tipo'] : '';
        $s_nsei = $_REQUEST['OficioSearch']['Num_sei'] ? $_REQUEST['OficioSearch']['Num_sei'] : '';
        $ano_listagem = $_REQUEST['OficioSearch']['ano_listagem'] ? $_REQUEST['OficioSearch']['ano_listagem'] : '';
        $status = $_REQUEST['OficioSearch']['status'] ? $_REQUEST['OficioSearch']['status'] : '';
        # Intervalo de data #######################################################################
        $data_ini = $_REQUEST['from_date'];
        $data_fim = $_REQUEST['to_date'];
        $datainicial = $data_ini;
        $datafinial = $data_fim;
        $intervalo_data = $_REQUEST['OficioSearch']['intervalo_data'];
        
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
        ]);
    ?>
    <div class="row">
        <div class="col">
        <?php
            $resolvidos = Oficio::find()->where([
                'status' => 'Resolvido'
            ])->count();
            $nao_resolvidos = Oficio::find()->where([
                'status' => 'Não resolvido'
            ])->count();
            $informativos = Oficio::find()->where([
                'status' => 'Informativo'
            ])->count();
            $em_andamento = Oficio::find()->where([
                'status' => 'Em Andamento'
            ])->count();
            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'pie'
                    ],
                    'title' => ['text' => 'Status de Registro'],
                    'xAxis' => [
                        'categories' => 'Status de Registro'
                    ],
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
                            'data' => [
                                [
                                    'name' => 'Informativo',
                                    'y' => $informativos,
                                    'color' => 'lightgray'
                                ],
                                [
                                    'name' => 'Em andamento',
                                    'y' => $em_andamento,
                                    'color' => '#f3f0c6',
                                ],
                                [
                                    'name' => 'Resolvido',
                                    'y' => $resolvidos,
                                    'color' => 'lightgreen',
                                ],
                                [
                                    'name' => 'Não resolvido',
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
        ?>
        </div>
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
        <div class="col-md-8">
            <?php
                function retornaserie ($campo, $status, $ano) {
                    $contagem = Oficio::find()->where([
                        $campo => $status,
                        'YEAR(data)' => $ano,
                    ])->count();
                    return $contagem;
                }

                echo Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column'
                        ],
                        'title' => ['text' => 'Todos os Registros'],
                        'xAxis' => [
                            'categories' => [
                                '2023',
                                '2022',
                            ]
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'Status']
                        ],
                        'series' => [
                            ['name' => 'Não Resolvido', 'data' => [
                                retornaserie('status', 'Não Resolvido', '2023'),
                                retornaserie('status', 'Não Resolvido', '2022'),
                            ], 'color' => 'red'],
                            ['name' => 'Resolvido', 'data' => [
                                retornaserie('status', 'Resolvido', '2023'),
                                retornaserie('status', 'Resolvido', '2022'),
                            ], 'color' => 'blue'],
                            ['name' => 'Informativo', 'data' =>[
                                retornaserie('status', 'Informativo', '2023'),
                                retornaserie('status', 'Informativo', '2022'),
                            ], 'color' => 'cyan'],
                            ['name' => 'Em Andamento', 'data' => [
                                retornaserie('status', 'Em Andamento', '2023'),
                                retornaserie('status', 'Em Andamento', '2022'),
                            ], 'color' => 'green'],
                            [
                                'type' => 'spline',
                                'name' => 'Emissor: CGMAB',
                                'data' => [
                                    retornaserie('emissor', 'CGMAB', '2023'),
                                    retornaserie('emissor', 'CGMAB', '2022'),
                                ],
                                'marker' => [
                                    'lineWidth' => 2
                                ],
                            ],
                            [
                                'type' => 'spline',
                                'name' => 'Emissor: PROSUL',
                                'data' => [
                                    retornaserie('emissor', 'PROSUL', '2023'),
                                    retornaserie('emissor', 'PROSUL', '2022'),
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
    <div class="row" style="background-color: ghostwhite; padding: 10px 5px">
        <!-- <h4 style="padding:5px">Pesquisa:</h4> -->
        <?php $form = ActiveForm::begin(['options' => [
            'data-pjax' => true,
            'autocomplete'=>"off"  
        ]]); ?>
        <div class="row">
            <div class="col-md-3">
                <label class="control-label summary" for="pagina-roa_programa">SEI</label>
                <?= $form->field($searchModel, 'Num_sei')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-md-4">
                <label class="control-label summary" for="from_date">Por data</label>
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
            <div class="col-md-5">
                <label class="control-label summary">Últimos dias</label><br>
                <label for="check-hoje-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OficioSearch[intervalo_data]" value="check-hoje" id="check-hoje-<?=$tipodepagina?>" style="" <?=$radiohoje?>>
                    Hoje
                </label>
                <label for="check-ultimos-dias-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OficioSearch[intervalo_data]" value="check-ultimos-dias" id="check-ultimos-dias-<?=$tipodepagina?>" style="" <?=$radiosete?>>
                    Últimos 7 dias
                </label>
                <label for="check-ultimo-mes-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OficioSearch[intervalo_data]" value="check-ultimo-mes" id="check-ultimo-mes-<?=$tipodepagina?>" style="" <?=$radiotrinta?>>
                    Últimos 30 dias
                </label>
                <label for="check-todos-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OficioSearch[intervalo_data]" value="0" id="check-todos-<?=$tipodepagina?>" style="">
                    Todos
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($searchModel, 'ano_listagem')->dropDownList([
                    '2023'=>'Ano 2023',
                    '2022'=>'Ano 2022',
                    '2021'=>'Ano 2021',
                    '2020'=>'Ano 2020',
                    'all'=>'Todos os registros',
                ])->label(false) ?>
            </div>    
            <div class="col-md-8 form-group">
                <?php // = $form->field($searchModel, 'status')->dropDownList([ 'Não Resolvido' => 'Não Resolvido', 'Parcialmente Resolvido' => 'Parcialmente Resolvido', 'Em andamento' => 'Em andamento', 'Resolvido' => 'Resolvido', ], ['prompt' => '']);?>
                <label for="nao-resolvido-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OficioSearch[status][1]" value="Informativo" id="nao-resolvido-<?=$id?>" style="" <?=$campo_status_1?>>
                    Informativo
                </label>
                <label for="parcialmente-resolvido-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OficioSearch[status][2]" value="Em Andamento" id="parcialmente-resolvido-<?=$id?>" style="" <?=$campo_status_2?>>
                    Em Andamento
                </label>
                <label for="em-andamento-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OficioSearch[status][3]" value="Resolvido" id="em-andamento-<?=$id?>" style="" <?=$campo_status_3?>>
                    Resolvido
                </label>
                <label for="resolvido-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OficioSearch[status][4]" value="Não Resolvido" id="resolvido-<?=$id?>" style="" <?=$campo_status_4?>>
                    Não Resolvido
                </label>
                <!-- <label for="forcomunicados" style="padding:1%">
                    <input type="checkbox" name="OficioSearch[comunicados]" value="1" style="" id="forcomunicados" >
                    Com CNC
                </label> -->
            </div>
            <div class="col-md-2 form-group">
                <img id="loading1" src="<?=Yii::$app->homeUrl?>arquivo/loading_blue.gif" width="40" style="float:right;margin-left: 12px;margin-top: -3px;display:none">
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
                'attribute' => 'id',
                'headerOptions' => [
                    'width' => '3%'
                ]
            ],
            'tipo',
            'emissor',
            // 'emprrendimento_desc',
            [
                'attribute' => 'emprrendimento_desc',
                'format' => 'raw',
                'value' => function($data) {
                    // return '<a class="btn btn-link" target="_blank" href="/empreendimento">'.$data->emprrendimento_desc.'</a>';
                    return $data->emprrendimento_desc;
                }
            ],
            //'datacadastro',
            // 'data',
            'Num_sei',
            [
                'attribute' => 'data',
                'value' => function($data) {
                    return date('d/m/Y', strtotime($data->data));
                }
            ],
            // 'fluxo',
            //'receptor',
            //'num_processo',
            //'num_protocolo',
            //'assunto:ntext',
            // 'diretorio',
            [
                'attribute' => 'diretorio',
                'format' => 'raw',
                'value' => function($data) {
                    return '<a class="btn btn-link" target="_blank" href="'.$linklink.'">'.$data->diretorio.'</a>';
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
                    $this->render('_docs', [
                        'id' => $data->id
                    ])
                    .'</center>';
                }
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
            [
                'header' => 'Oper.',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'value' => function($data) {
                    return 'Em @Dev';
                }
            ]
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
