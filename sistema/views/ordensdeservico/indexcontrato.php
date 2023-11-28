<?php

use app\models\Ordensdeservico as OS;
use app\models\Empreendimento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

$empreendimentos = Empreendimento::find()->where([
    'contrato_id' => $contrato_id
])->all();


/** @var yii\web\View $this */
/** @var app\models\OrdensdeservicoSearch $searchModel */
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
<div class="ordensdeservico-index">

    <h3><img src="<?=Yii::$app->homeUrl?>logo/upload-files-icon.png" class="icone-modulo" width="25" />  Contrato: Ordens de Serviço</h3>
    <div class="row">
        <div class="col-md-12">
            <?php $modelOrdensdeservico = new OS(); ?>
            <?= $this->render('create', [
                'model' => $modelOrdensdeservico,
                'contrato_id' => $contrato_id
            ]) ?>
        </div>
    </div>
    <div class="clearfix">
        <br />
    </div>
    <?php
        ########################################## TIPO ##########################################
        // $search_tipos = OS::find()->select('tipo')->groupBy('tipo')->all();
        // $lista_tipos = [];
        // foreach ($search_tipos as $value):
        //     $lista_tipos[$value->tipo] = $value->tipo;
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
        'id' => 'admin-crud-id-roa-oservicos', 
        'timeout' => false,
        'enablePushState' => false
    ]); ?>
    
    <?php 



        $titulo = $_REQUEST['OrdensdeservicoSearch']['titulo'] ? $_REQUEST['OrdensdeservicoSearch']['titulo'] : '';
        $fase = $_REQUEST['OrdensdeservicoSearch']['fase'] ? $_REQUEST['OrdensdeservicoSearch']['fase'] : '';
        $plano = $_REQUEST['OrdensdeservicoSearch']['plano'] ? $_REQUEST['OrdensdeservicoSearch']['plano'] : '';
        $numero_sei = $_REQUEST['OrdensdeservicoSearch']['numero_sei'] ? $_REQUEST['OrdensdeservicoSearch']['numero_sei'] : '';
        $empreendimento_id = $_REQUEST['OrdensdeservicoSearch']['empreendimento_id'] ? $_REQUEST['OrdensdeservicoSearch']['empreendimento_id'] : '';
        # Intervalo de data #######################################################################
        $ano_listagem = $_REQUEST['OrdensdeservicoSearch']['ano_listagem'] ? $_REQUEST['OrdensdeservicoSearch']['ano_listagem'] : '';
        $data_ini = $_REQUEST['from_date'];
        $data_fim = $_REQUEST['to_date'];
        $datainicial = $data_ini;
        $datafinial = $data_fim;
        $intervalo_data = $_REQUEST['OrdensdeservicoSearch']['intervalo_data'];
        
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
                        $date = new DateTime('1 days ago');
                        $data_ini = $date->format('Y-m-d');
                        $data_fim = date('Y-m-d');
                        
                        $radiohoje = 'checked="checked"';
                    break;
                }
            endif;
        endif;
        $dataProvider = $searchModel->search([
            'titulo' => $titulo,
            'numero_sei' => $numero_sei,
            'empreendimento_id' =>$empreendimento_id,
            'fase' => $fase,
            'plano' => $plano,
            'from_date'=> $data_ini,
            'to_date'=> $data_fim,
            'ano_listagem' => $ano_listagem,
            'status' => $status,
        ]);
    ?>
    <div class="row mt-0 mb-0 pb-1   pt-1 " style="background-color: white;">
        <h3>
            <center>
                <a class="btn btn-link fs-3" href="#collapsePesquisaOS"  data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapsePesquisaOS">
                    Pesquisa <i class="bi bi-arrow-down"></i>
                </a> 
                <a
                    href="<?=Yii::$app->homeUrl."contrato/view?id=$contrato_id&abativa=aba_ordens"?>" 
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
    <div id="collapsePesquisaOS" class="row collapse mb-2" style="background-color: ghostwhite; padding: 10px 5px">
        <!-- <h4 style="padding:5px">Pesquisa:</h4> -->
        <?php $form = ActiveForm::begin(['options' => [
            'data-pjax' => true,
            'autocomplete'=>"off"  
        ]]); ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($searchModel, 'titulo')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'numero_sei')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <label class="control-label summary" for="ordemdeservico_empreendimento_id">Empreendimento</label>
                <?php $lista_emp = ArrayHelper::map($empreendimentos, 'id', 'titulo'); ?>
                <?= $form->field($searchModel, 'empreendimento_id')->dropDownList($lista_emp, [
                    'prompt' => ''
                ])->label(false) ?>
            </div>
            <div class="col-md-2"><?= $form->field($searchModel, 'fase')->dropDownList([ 'Manifestação de Interesse em Análise' => 'Manifestação de Interesse em Análise', 'OS Emitida' => 'OS Emitida', 'OS em Andamento' => 'OS em Andamento', 'OS Paralisada' => 'OS Paralisada', 'OS Finalizada' => 'OS Finalizada', ], ['prompt' => '']) ?></div>
            <div class="col-md-3"><?= $form->field($searchModel, 'plano')->dropDownList([ 'Plano de Trabalho Solicitado' => 'Plano de Trabalho Solicitado', 'Plano de Trabalho em Andamento' => 'Plano de Trabalho em Andamento', 'Plano de Trabalho  Entregue DNIT' => 'Plano de Trabalho  Entregue DNIT', 'Plano de Trabalho em Análise DNIT' => 'Plano de Trabalho em Análise DNIT', 'Plano de Trabalho em Revisão' => 'Plano de Trabalho em Revisão', 'Plano de Trabalho Aprovado DNIT' => 'Plano de Trabalho Aprovado DNIT', ], ['prompt' => '']) ?></div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'ano_listagem')->dropDownList([
                    'all'=>'Todos os registros',
                    '2023'=>'Ano 2023',
                    '2022'=>'Ano 2022',
                    '2021'=>'Ano 2021',
                    '2020'=>'Ano 2020',
                ])->label('Ano de vigência') ?>
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
            <div class="col-md-4">
                <label class="control-label summary">Últimos dias</label><br>
                <label for="check-hoje-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OrdensdeservicoSearch[intervalo_data]" value="check-hoje" id="check-hoje-<?=$tipodepagina?>" style="" <?=$radiohoje?>>
                    Hoje
                </label>
                <label for="check-ultimos-dias-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OrdensdeservicoSearch[intervalo_data]" value="check-ultimos-dias" id="check-ultimos-dias-<?=$tipodepagina?>" style="" <?=$radiosete?>>
                    Últimos 7 dias
                </label>
                <label for="check-ultimo-mes-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OrdensdeservicoSearch[intervalo_data]" value="check-ultimo-mes" id="check-ultimo-mes-<?=$tipodepagina?>" style="" <?=$radiotrinta?>>
                    Últimos 30 dias
                </label>
                <label for="check-todos-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="OrdensdeservicoSearch[intervalo_data]" value="0" id="check-todos-<?=$tipodepagina?>" style="">
                    Todos
                </label>
            </div>
        <!-- </div>
        <div class="row"> -->
            
            <?php /*
            <div class="col-md-6 form-group">
                <?php // = $form->field($searchModel, 'status')->dropDownList([ 'Não Resolvido' => 'Não Resolvido', 'Parcialmente Resolvido' => 'Parcialmente Resolvido', 'Em andamento' => 'Em andamento', 'Resolvido' => 'Resolvido', ], ['prompt' => '']);?>
                <label for="nao-resolvido-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OrdensdeservicoSearch[status][1]" value="Informativo" id="nao-resolvido-<?=$id?>" style="" <?=$campo_status_1?>>
                    Informativo
                </label>
                <label for="parcialmente-resolvido-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OrdensdeservicoSearch[status][2]" value="Em Andamento" id="parcialmente-resolvido-<?=$id?>" style="" <?=$campo_status_2?>>
                    Em Andamento
                </label>
                <label for="em-andamento-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OrdensdeservicoSearch[status][3]" value="Resolvido" id="em-andamento-<?=$id?>" style="" <?=$campo_status_3?>>
                    Resolvido
                </label>
                <label for="resolvido-<?=$tipodepagina?>" style="padding:1%">
                    <input type="checkbox" name="OrdensdeservicoSearch[status][4]" value="Não Resolvido" id="resolvido-<?=$id?>" style="" <?=$campo_status_4?>>
                    Não Resolvido
                </label>
            </div>
            */ ?>
            <div class="col-md-2 form-group">
                <br />
                <img id="loading1-os" src="<?=Yii::$app->homeUrl?>arquivos/loading_blue.gif" width="40" style="float:right;margin-left: 12px;margin-top: -3px;display:none">
                <?php             
                    echo Html::submitButton('Pesquisar', [
                        'class' => 'btn btn-primary',
                        'style'=>'float:right;margin:1%',
                        'id'=>'botao-envia-pesquisa-ajax-os'
                        // 'onclick'=>'$(this).addClass("disabled");$("#loading1-os").show();this.form.submit();this.disabled=true;',
                        // 'onmouseup'=>'$(this).addClass("disabled");$("#loading1-os").show();this.disabled=true;',
                    ]);
                    $this->registerJs(<<<JS
                        $(document).on('pjax:send', function() {
                            $("#loading1-os").show();
                            $("#botao-envia-pesquisa-ajax-os").addClass("disabled");
                        });
                        $(document).on('pjax:complete', function() {
                            $('#loading1-os').hide();
                            $("#botao-envia-pesquisa-ajax-os").removeClass("disabled");
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
            // [
            //     'attribute' => 'id',
            //     'headerOptions' => [
            //         'width' => '3%'
            //     ]
            // ],
            [
                'attribute' => 'empreendimento_id',
                'value' => function($data) {
                    return $data->empreendimento->titulo;
                }
            ],
            'titulo',
            'numero_sei',
            // 'empreendimento_id',
            // 'tipo',
            // 'emissor',
            // 'emprrendimento_desc',
            //'datacadastro',
            // 'data',
            // 'Num_sei',
            // 'oficio.tipo',
            'fase',
            // 'plano',
            [
                'attribute' => 'dataemissao',
                'value' => function($data) {
                    return date('d/m/Y', strtotime($data->dataemissao));
                }
            ],
            [
                'attribute' => 'dataemissao',
                'header' => 'Período transcorrido',
                'value' => function($data) {
                    $fdias = $this->context->diasentre($data->dataemissao, date('Y-m-d'));
                    return $fdias !== 1 ? $fdias.' dias' : $fdias.' dia';
                }
            ],
            // 'fluxo',
            //'receptor',
            //'num_processo',
            //'num_protocolo',
            //'assunto:ntext',
            //'diretorio',
            // 'status',
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
                'header' => 'Docs',
                'headerOptions' => [
                    'width' => '5%'
                ],
                'format' => 'raw',
                'value' => function($data) {
                    return '<center>'.
                    "<a class='btn btn-primary' href='".Yii::$app->homeUrl."ordensdeservico/update?id=$data->id&abativa=arquivos' target=''>
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
                    return '<a href="'.Yii::$app->homeUrl.'ordensdeservico/update?id='.$data->id.'" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
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
