<?php

use app\models\Produto;
use app\models\Empreendimento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use miloschuman\highcharts\Highcharts;

    /**
    
        use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

        $path = Yii::$app->basePath.'/web/arquivos/produtos.xlsx';
        # open the file
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($path);
        # read each cell of each row of each sheet
        echo '<table border="2" class="table table-striped table-bordered">';
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                echo '<tr>';
                // foreach ($row->getCells() as $cell) {
                //     echo '<td>'.$cell->getValue().'</td>';
                // }
                // echo $row->getCells()[0];
                echo '<td>'.$row->getCells()[0].'</td>'; # ID
                echo '<td>'.$row->getCells()[1].'</td>'; # Empreendimento
                echo '<td>'.$row->getCells()[2].'</td>'; # OS
                echo '<td>'.$row->getCells()[3].'</td>'; # Subproduto
                echo '<td>'.$row->getCells()[4].'</td>'; # Serviço
                echo '<td>'.$row->getCells()[5].'</td>'; # Entrega
                echo '<td>'.$row->getCells()[6].'</td>'; # Data de entrega
                // REVISÕES
                // echo '<td>'.$row->getCells()[7].'</td>'; # Revisão 1 -Data
                // echo '<td>'.$row->getCells()[8].'</td>'; # Revisão 1 -Tempo Decorrido blá blá
                // echo '<td>'.$row->getCells()[9].'</td>'; # # Revisão 1 -Responsável
                // echo '<td>'.$row->getCells()[10].'</td>'; # # Revisão 1 -Versão Aprovada
                // Continuando
                echo '<td>'.$this->context->dataprobanco($row->getCells()[27]).'</td>'; # Data de aprovação
                echo '<td>'.$row->getCells()[28].'</td>'; # Tempo decorrido 
                echo '<td>'.$row->getCells()[29].'</td>'; # Versão Aprovada
                echo '<td>'.$row->getCells()[30].'</td>'; # Diretório
                echo '<td>'.$contrato_id.'</td>'; # ID DO CONTRATO
                
                $novoproduto = new Produto();
                //Campos importados
                

                $novoproduto->contrato_id = $contrato_id;
                $novoproduto->datacadastro = date('Y-m-d H:i:s');
                $novoproduto->subproduto = (string)$row->getCells()[3];
                $novoproduto->servico = (string)$row->getCells()[4];
                $novoproduto->entrega = (string)$row->getCells()[5];
                $novoproduto->data_entrega = $row->getCells()[6] != '' ? $this->context->dataprobanco($row->getCells()[6]): null;
                $novoproduto->aprov_data = $row->getCells()[27] != '' ? $this->context->dataprobanco($row->getCells()[27]): null;
                $novoproduto->aprov_tempo_ultima_revisao = (string)$row->getCells()[28];
                $novoproduto->aprov_versao = (string)$row->getCells()[29];
                $novoproduto->diretorio_texto = (string)$row->getCells()[30];
                // Definições
                echo '<td>';
                if ($novoproduto->save()) {
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

// use dosamigos\datepicker\DatePicker;

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
/** @var app\models\ProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

// $this->title = $model->titulo.' Oficios';
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
<div class="produto-index">

    <h3><img src="<?=Yii::$app->homeUrl?>logo/upload-files-icon.png" class="icone-modulo" width="25" /> Contrato: Produtos</h3>
    <div class="row">
        <div class="col-md-12">
            <?php $modelProduto = new Produto(); ?>
            <?= $this->render('create', [
                'model' => $modelProduto,
                'contrato_id' => $contrato_id
            ]) ?>
        </div>
    </div>
    <div class="clearfix">
        <br />
    </div>
    <?php
        ########################################## TIPO ##########################################
        $search_tipos = Produto::find()->select('empreendimento_id')->groupBy('empreendimento_id')->all();
        $lista_tipos = [];
        // foreach ($search_tipos as $campo):
        //     $lista_tipos[$campo->empreendimento] = $campo->empreendimento;
        // endforeach;
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
        'id' => 'admin-crud-id-produtos', 
        'timeout' => false,
        'enablePushState' => false
    ]); ?>
    
    <?php 



        $empreendimento_id = $_REQUEST['ProdutoSearch']['empreendimento_id'] ? $_REQUEST['ProdutoSearch']['empreendimento_id'] : '';
        $ordensdeservico_id = $_REQUEST['ProdutoSearch']['ordensdeservico_id'] ? $_REQUEST['ProdutoSearch']['ordensdeservico_id'] : '';
        $ano_listagem = $_REQUEST['ProdutoSearch']['ano_listagem'] ? $_REQUEST['ProdutoSearch']['ano_listagem'] : '';
        $fase = $_REQUEST['ProdutoSearch']['fase'] ? $_REQUEST['ProdutoSearch']['fase'] : '';
        # Intervalo de data #######################################################################
        $data_ini = $_REQUEST['from_date'];
        $data_fim = $_REQUEST['to_date'];
        $datainicial = $data_ini;
        $datafinial = $data_fim;
        $intervalo_data = $_REQUEST['ProdutoSearch']['intervalo_data'];
        
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
        if (!empty($fase)) :
            echo $fase[4];
            if($fase[1]) { $campo_status_1 = 'checked="checked"'; }
            if($fase[2]) { $campo_status_2 = 'checked="checked"'; }
            if($fase[3]) { $campo_status_3 = 'checked="checked"'; }
            if($fase[4]) { $campo_status_4 = 'checked="checked"'; }
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
            'from_date'=> $data_ini,
            'to_date'=> $data_fim,
            'ano_listagem' => $ano_listagem,
            'empreendimento_id' => $empreendimento_id,
            'ordensdeservico_id' => $ordensdeservico_id,
            'fase' => $fase,
        ]);
    ?>
    <div class="row" style="background-color: ghostwhite; padding: 10px 5px">
        <!-- <h4 style="padding:5px">Pesquisa:</h4> -->
        <?php $form = ActiveForm::begin(['options' => [
            'data-pjax' => true,
            'autocomplete'=>"off"  
        ]]); ?>
        <div class="row">
            <?php 
                $aprovado = 0;
                $aguardando = 0;
                $reprovado = 0;
                $RV0 = $RV1 = $RV2 = $RV3 = $RV4 = $RV5 = 0;
                $RV0_t = $RV1_t = $RV2_t = $RV3_t = $RV4_t = $RV5_t = 0;
                $tempo_medio_dnit = 0;
                $tempo_medio_prosul = 0;

                $empreendimentos = Empreendimento::find()->all();
                $graph_empreendimentos = [];
                $os = \app\models\OrdensdeServico::find()->all();
                $graph_os = [];
                $i = 0;
                $dnit_t = $prosul_t = $cgmab = 0;
                foreach($dataProvider->getModels() as $item) {
                    switch ($item->fase) {
                        case 'Em andamento': $aguardando += 1; break;
                        case 'Aprovado': $aprovado += 1; break;
                        case 'Reprovado': $reprovado += 1; break;
                    }
                    switch ($item->aprov_versao) {
                        case 'RV0': $RV0 += 1; break;
                        case 'RV1': $RV1 += 1; break;
                        case 'RV2': $RV2 += 1; break;
                        case 'RV3': $RV3 += 1; break;
                        case 'RV4': $RV4 += 1; break;
                        case 'RV5': $RV5 += 1; break;
                    }
                    
                    // tempo médio em revisões dnit
                    $data_comparada = $item->data_entrega;
                    foreach ($item->revisaos as $rv) {
                       if(in_array($rv->titulo, ["Revisão 01 (DNIT)", "Revisão 03 (DNIT)", "Revisão 05 (DNIT)"])) {
                            $dnit_t += $this->context->diasentre($data_comparada, $rv->data);
                       }
                       if(in_array($rv->titulo, ["Revisão 02 (Prosul)", "Revisão 04 (Prosul)", "Revisão 06 (Prosul)"])) {
                            $prosul_t += $this->context->diasentre($data_comparada, $rv->data);
                       }
                       $data_comparada = $rv->data;
                    }

                    // Incrementa =====================================
                    $i++;
                }
                if ($i == 0) {
                    $i = 1;
                }
                $media_t_dnit = $dnit_t/$i;
                $media_t_prosul = $prosul_t/$i;
                $media_t_dnit = (int)number_format($media_t_dnit, 0);
                $media_t_prosul = (int)number_format($media_t_prosul, 0);
                // echo 'Produtos: '.$i;
                // echo '<pre>';
                // echo "Tempo médio de Revisão(DNIT): ".$dnit_t/$i." dias";
                // echo '</pre>';
                // echo '<pre>';
                // echo "Tempo médio de Revisão(PROSUL): ".$prosul_t/$i." dias";
                // echo '</pre>';
                // echo $RV0.'<br>';
                // echo $RV1.'<br>';
                // echo $RV2.'<br>';
                // echo $RV3.'<br>';
                // echo $RV4.'<br>';
                // echo $RV5.'<br>';
                // echo $aprovado.'<br>';
                // echo $aguardando.'<br>';
                foreach ($empreendimentos as $emp) {
                    $countaprodutos = 0;
                    foreach($dataProvider->getModels() as $item) {
                        if ($item->empreendimento_id == $emp->id) {
                            $countaprodutos += 1;
                        }
                    }
                    array_push($graph_empreendimentos, [
                        'name' => $emp->titulo, 'y' => $countaprodutos, 'url' => 'RV0'
                    ]);
                }
                foreach ($os as $emp) {
                    $countaprodutos = 0;
                    foreach($dataProvider->getModels() as $item) {
                        if ($item->ordensdeservico_id == $emp->id) {
                            $countaprodutos += 1;
                        }
                    }
                    array_push($graph_os, [
                        'name' => $emp->titulo, 'y' => $countaprodutos, 'url' => 'RV0'
                    ]);
                }
                $reviews_aprov = [
                    [ 'name' => 'RV 0', 'y' => $RV0, 'url' => 'RV0', 'color' => '#006400' ],
                    [ 'name' => 'RV 1', 'y' => $RV1, 'url' => 'RV1', 'color' => '#2e8b57' ],
                    [ 'name' => 'RV 2', 'y' => $RV2, 'url' => 'RV2', 'color' => '#6b8e23' ],
                    [ 'name' => 'RV 3', 'y' => $RV3, 'url' => 'RV3', 'color' => '#007b80' ],
                    // [ 'name' => 'RV4', 'y' => $RV4, 'url' => 'RV4' ],
                    // [ 'name' => 'RV5', 'y' => $RV5, 'url' => 'RV5' ],
                ];
            ?>
            <div class="col">
                <div class="card">
                <?= Highcharts::widget([
                        'scripts' => [
                            'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'pie'
                            ],
                            'title' => ['text' => 'Situação'],
                            'yAxis' => [
                                'title' => ['text' => 'Status']
                            ],
                            'series' =>  [
                                [
                                    'name' => 'Produtos',
                                    "cursor" => "pointer",
                                    "point" => [
                                        "events" => [
                                            "click" => new JsExpression('function(){
                                                console.log(this.options.url)
                                            }')
                                        ],
                                    ],
                                    'data' => [
                                        [
                                            'name' => 'Aprovado',
                                            'y' => $aprovado,
                                            'color' => 'green',
                                            'url' => 'google.com.br'
                                        ],
                                        [
                                            'name' => 'Em análise',
                                            'y' => $aguardando,
                                            'color' => 'orange',
                                            'url' => 'yahoo.com.br'
                                        ],
                                        [
                                            'name' => 'Reprovado',
                                            'y' => $reprovado,
                                            'color' => 'red',
                                            'url' => 'yahoo.com.br'
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
            </div>
            <div class="col">
                <div class="card">
                <?= Highcharts::widget([
                        'scripts' => [
                            'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'pie'
                            ],
                            'title' => ['text' => 'Por versão aprovada'],
                            'yAxis' => [
                                'title' => ['text' => 'Versão']
                            ],
                            'series' =>  [
                                [
                                    'name' => 'Produtos',
                                    "cursor" => "pointer",
                                    "point" => [
                                        "events" => [
                                            "click" => new JsExpression('function(){
                                                console.log(this.options.url)
                                            }')
                                        ],
                                    ],
                                    'data' => $reviews_aprov,
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
            </div>
            <div class="col">
                <div class="card">
                <?= Highcharts::widget([
                        'scripts' => [
                            'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'column'
                            ],
                            'title' => ['text' => 'Por Empreendimento'],
                            'yAxis' => [
                                'title' => ['text' => 'Produtos']
                            ],
                            'xAxis' => [
                                'type' => 'category'
                            ],
                            'series' =>  [
                                [
                                    'name' => 'Produtos',
                                    "cursor" => "pointer",
                                    'colorByPoint' => true,
                                    "point" => [
                                        "events" => [
                                            "click" => new JsExpression('function(){
                                                console.log(this.options.url)
                                            }')
                                        ],
                                    ],
                                    'data' => $graph_empreendimentos,
                                    'showInLegend' => false,
                                    'dataLabels' => [
                                        'enabled' => false,
                                    ],
                                ],
                            ],
                        ]
                    ]);
                ?>
                </div>
            </div>
            <div class="col">
                <div class="card">
                <?= Highcharts::widget([
                        'scripts' => [
                            'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'column',
                                'innerSize' => '50%',
                            ],
                            'title' => ['text' => 'Por Ordem de Serviço'],
                            'yAxis' => [
                                'title' => ['text' => 'Produtos']
                            ],
                            'xAxis' => [
                                'type' => 'category'
                            ],
                            // 'tooltip' => [
                            //     'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>'
                            // ],
                            'series' =>  [
                                [
                                    'name' => 'Produtos',
                                    "cursor" => "pointer",
                                    'colorByPoint' => true,
                                    "point" => [
                                        "events" => [
                                            "click" => new JsExpression('function(){
                                                console.log(this.options.url)
                                            }')
                                        ],
                                    ],
                                    'data' => $graph_os,
                                    'showInLegend' => false,
                                    'dataLabels' => [
                                        'enabled' => false,
                                    ],
                                ],
                            ],
                        ]
                    ]);
                ?>
                </div>
            </div>
            <div class="col">
                <div class="card">
                <?= Highcharts::widget([
                        'scripts' => [
                            'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'pie'
                            ],
                            'title' => ['text' => 'Tempo médio para Revisão'],
                            'yAxis' => [
                                'title' => ['text' => 'Dias']
                            ],
                            'series' =>  [
                                [
                                    'name' => 'Dias',
                                    "cursor" => "pointer",
                                    "point" => [
                                        "events" => [
                                            "click" => new JsExpression('function(){
                                                console.log(this.options.url)
                                            }')
                                        ],
                                    ],
                                    'data' => [
                                        [
                                            'name' => 'DNIT',
                                            'y' => $media_t_dnit,
                                            'color' => 'green',
                                            'url' => 'google.com.br'
                                        ],
                                        [
                                            'name' => 'Prosul',
                                            'y' => $media_t_prosul,
                                            'color' => 'blue',
                                            'url' => 'yahoo.com.br'
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
            </div>
        </div>
        <div class="clearfix"><br></div>
        <div class="row">
            <h3><center>Pesquisa</center></h3>
            <!-- <hr> -->
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="control-label summary" for="pagina-roa_programa">Empreendimento</label>
                <?php $lista_emp = ArrayHelper::map($empreendimentos, 'id', 'titulo'); ?>
                <?= $form->field($searchModel, 'empreendimento_id')->dropDownList($lista_emp, [
                    'prompt' => 'Selecione'
                ])->label(false) ?>
            </div>
            <div class="col-md-4">
                <label class="control-label summary" for="pagina-roa_programa">Ordem de Serviço</label>
                <?php $lista_os = ArrayHelper::map($os, 'id', 'titulo'); ?>
                <?= $form->field($searchModel, 'ordensdeservico_id')->dropDownList($lista_os, [
                    'prompt' => 'Selecione'
                ])->label(false) ?>
            </div>
            <div class="col-md-4">
                <label class="control-label summary" for="from_date">Por data de Entrada</label>
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
        </div>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($searchModel, 'ano_listagem')->dropDownList([
                    '2023'=>'Ano 2023',
                    '2022'=>'Ano 2022',
                    'all'=>'Todos os registros',
                ])->label('Ano') ?>
            </div> 
            <div class="col-md-4">
                <label class="control-label summary">Últimos dias</label><br>
                <label for="check-hoje-produto" style="padding:1%">
                    <input type="radio" name="ProdutoSearch[intervalo_data]" value="check-hoje" id="check-hoje-produto" style="" <?=$radiohoje?>>
                    Hoje
                </label>
                <label for="check-ultimos-dias-produto" style="padding:1%">
                    <input type="radio" name="ProdutoSearch[intervalo_data]" value="check-ultimos-dias" id="check-ultimos-dias-produto" style="" <?=$radiosete?>>
                    Últimos 7 dias
                </label>
                <label for="check-ultimo-mes-produto" style="padding:1%">
                    <input type="radio" name="ProdutoSearch[intervalo_data]" value="check-ultimo-mes" id="check-ultimo-mes-produto" style="" <?=$radiotrinta?>>
                    Últimos 30 dias
                </label>
                <label for="check-todos-produto" style="padding:1%">
                    <input type="radio" name="ProdutoSearch[intervalo_data]" value="0" id="check-todos-produto" style="">
                    Todos
                </label>
            </div>
            <div class="col-md-4 form-group">
            <label class="control-label summary">Situação</label><br>
                <?php // = $form->field($searchModel, 'status')->dropDownList([ 'Não Resolvido' => 'Não Resolvido', 'Parcialmente Resolvido' => 'Parcialmente Resolvido', 'Em andamento' => 'Em andamento', 'Resolvido' => 'Resolvido', ], ['prompt' => '']);?>
                <label for="em_andamento_produto" style="padding:1%">
                    <input type="checkbox" name="ProdutoSearch[fase][1]" value="Em andamento" id="em_andamento_produto" style="" <?=$campo_status_1?>>
                    Em Andamento
                </label>
                <label for="aprovado_produto" style="padding:1%">
                    <input type="checkbox" name="ProdutoSearch[fase][2]" value="Aprovado" id="aprovado_produto" style="" <?=$campo_status_2?>>
                    Aprovado
                </label>
                <label for="reprovado_produto" style="padding:1%">
                    <input type="checkbox" name="ProdutoSearch[fase][3]" value="Reprovado" id="reprovado_produto" style="" <?=$campo_status_3?>>
                    Reprovado
                </label>
                <!-- <label for="forcomunicados" style="padding:1%">
                    <input type="checkbox" name="ProdutoSearch[comunicados]" value="1" style="" id="forcomunicados" >
                    Com CNC
                </label> -->
            </div>
            <div class="col-md-2 form-group">
                <br>
                <img id="loading1-produtos" src="<?=Yii::$app->homeUrl?>arquivos/loading_blue.gif" width="40" style="float:right;margin-left: 12px;margin-top: -3px;display:none">
                <?php             
                    echo Html::submitButton('Pesquisar', [
                        'class' => 'btn btn-primary',
                        'style'=>'float:right;margin:1%',
                        'id'=>'botao-envia-pesquisa-ajax-produto'
                        // 'onclick'=>'$(this).addClass("disabled");$("#loading1-produtos").show();this.form.submit();this.disabled=true;',
                        // 'onmouseup'=>'$(this).addClass("disabled");$("#loading1-produtos").show();this.disabled=true;',
                    ]);
                    $this->registerJs(<<<JS
                        $(document).on('pjax:send', function() {
                            $("#loading1-produtos").show();
                            $("#botao-envia-pesquisa-ajax-produto").addClass("disabled");
                        });
                        $(document).on('pjax:complete', function() {
                            $('#loading1-produtos').hide();
                            $("#botao-envia-pesquisa-ajax-produto").removeClass("disabled");
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
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'width' => '3%'
                ]
            ],
            'subproduto',
            [
                'attribute' => 'empreendimento_id',
                'format' => 'raw',
                'value' => function($data) {
                    return $this->render('_empreendimento', [
                        'id' => $data->empreendimento_id
                    ]);
                },
                'headerOptions' => [
                    'width' => '5%'
                ]
            ],
            [
                'attribute' => 'ordensdeservico_id',
                'format' => 'raw',
                'value' => function($data) {
                    return $this->render('_os', [
                        'id' => $data->ordensdeservico_id
                    ]);
                },
                'headerOptions' => [
                    'width' => '5%'
                ]
            ],
            // [
                //     'attribute' => 'datacadastro',
            //     'value' => function($data) {
            //         return date('d/m/Y', strtotime($data->datacadastro));
            //     }
            // ],
            [
                'attribute' => 'data_entrega',
                'value' => function($data) {
                    return $data->data_entrega ? date('d/m/Y', strtotime($data->data_entrega)) : '';
                }
            ],
            [
                'attribute' => 'aprov_data',
                'value' => function($data) {
                    return $data->aprov_data ? date('d/m/Y', strtotime($data->aprov_data)) : '';
                }
            ],
            // 'fase',
            [
                'attribute' => 'fase',
                'format' => 'raw',
                'value' => function($data) {
                    switch ($data->fase) {
                        case 'Em andamento': $faseada = "<b class='text-warning'>$data->fase</b>"; break;
                        case 'Aprovado': $faseada = "<b class='text-success'>$data->fase</b>"; break;
                        case 'Reprovado': $faseada = "<b class='text-danger'>$data->fase</b>"; break;
                    }        
                    return "<center>$faseada</center>";
                }
            ],
            [
                'attribute' => 'id',
                'header' => 'Detalhes',
                'headerOptions' => [
                    'width' => '5%'
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
                'header' => 'Revisões',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'format' => 'raw',
                'value' => function($data) { 
                    $count_revisoes = \app\models\Revisao::find()->where([
                        'produto_id' => $data->id
                    ])->count();       
                    return '<center>'.
                    "<a class='btn btn-primary' href='".Yii::$app->homeUrl."produto/update?id=$data->id&abativa=reviews' target=''>
                    📋 $count_revisoes)
                    </a>".
                    '</center>';
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
                    "<a class='btn btn-primary' href='".Yii::$app->homeUrl."produto/update?id=$data->id&abativa=arquivos' target=''>
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
                    return '<a href="'.Yii::$app->homeUrl.'produto/update?id='.$data->id.'" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                },
                'visible' => in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor']) ? true : false
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
