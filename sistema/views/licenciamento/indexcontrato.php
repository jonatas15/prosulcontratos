<?php

use app\models\Licenciamento;
use app\models\Empreendimento;
use app\models\Ordensdeservico;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\LicenciamentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
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

    <h3><img src="<?=Yii::$app->homeUrl?>logo/upload-files-icon.png" class="icone-modulo" width="25" />  Contrato: Licenciamentos</h3>
    <div class="row">
        <div class="col-md-12">
            <?php $modelLicenciamentos = new Licenciamento(); ?>
            <?= $this->render('create', [
                'model' => $modelLicenciamentos,
                'contrato_id' => $contrato_id
            ]) ?>
        </div>
    </div>
    <div class="clearfix">
        <br />
    </div>
    <?php
        ########################################## EMPREENDIMENTOS ##########################################
        $search_empreendimentos = Empreendimento::find()->all();
        $lista_empreendimentos = ArrayHelper::map($search_empreendimentos, 'id', 'titulo');
        ######################################### ORDENS DE SERVIÇO #########################################
        $search_OS = Ordensdeservico::find()->all();
        $lista_OS = ArrayHelper::map($search_OS, 'id', 'titulo');
    ?>
    <?php 
    
    
    Pjax::begin([
        'id' => 'admin-crud-id-licenciamentos', 
        'timeout' => false,
        'enablePushState' => false
    ]); ?>
    
    <?php 
        $empreendimento_id = $_REQUEST['LicenciamentoSearch']['empreendimento_id'] ? $_REQUEST['LicenciamentoSearch']['empreendimento_id'] : '';
        $ordensdeservico_id = $_REQUEST['LicenciamentoSearch']['ordensdeservico_id'] ? $_REQUEST['LicenciamentoSearch']['ordensdeservico_id'] : '';
        $numero = $_REQUEST['LicenciamentoSearch']['numero'] ? $_REQUEST['LicenciamentoSearch']['numero'] : '';
        $ano_listagem = $_REQUEST['LicenciamentoSearch']['ano_listagem'] ? $_REQUEST['LicenciamentoSearch']['ano_listagem'] : '';
        # Intervalo de data #######################################################################
        $data_ini = $_REQUEST['from_date'];
        $data_fim = $_REQUEST['to_date'];
        $datainicial = $data_ini;
        $datafinial = $data_fim;
        $intervalo_data = $_REQUEST['LicenciamentoSearch']['intervalo_data'];
        
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
            'numero' => $numero,
            'from_date'=> $data_ini,
            'to_date'=> $data_fim,
            'ano_listagem' => $ano_listagem,
            'empreendimento_id' => $empreendimento_id,
            'ordensdeservico_id' => $ordensdeservico_id,
        ]);
    ?>
    <div class="row" style="background-color: ghostwhite; padding: 10px 5px">
        <!-- <h4 style="padding:5px">Pesquisa:</h4> -->
        <?php $form = ActiveForm::begin(['options' => [
            'data-pjax' => true,
            'autocomplete'=>"off"  
        ]]); ?>
        <div class="row">
            <div class="col-12">
                <h4>
                    <center>Pesquisa</center>
                </h4>
            </div>
            <div class="col-md-2">
                <label class="control-label summary" for="pagina-roa_programa">Número</label>
                <?= $form->field($searchModel, 'numero')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'ano_listagem')->dropDownList([
                    '2023'=>'Ano 2023',
                    '2022'=>'Ano 2022',
                    '2021'=>'Ano 2021',
                    '2020'=>'Ano 2020',
                    'all'=>'Todos os registros',
                ])->label('Ano'); ?>
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
                    <input type="radio" name="LicenciamentoSearch[intervalo_data]" value="check-hoje" id="check-hoje-<?=$tipodepagina?>" style="" <?=$radiohoje?>>
                    Hoje
                </label>
                <label for="check-ultimos-dias-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="LicenciamentoSearch[intervalo_data]" value="check-ultimos-dias" id="check-ultimos-dias-<?=$tipodepagina?>" style="" <?=$radiosete?>>
                    Últimos 7 dias
                </label>
                <label for="check-ultimo-mes-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="LicenciamentoSearch[intervalo_data]" value="check-ultimo-mes" id="check-ultimo-mes-<?=$tipodepagina?>" style="" <?=$radiotrinta?>>
                    Últimos 30 dias
                </label>
                <label for="check-todos-<?=$tipodepagina?>" style="padding:1%">
                    <input type="radio" name="LicenciamentoSearch[intervalo_data]" value="0" id="check-todos-<?=$tipodepagina?>" style="">
                    Todos
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <?= $form->field($searchModel, 'empreendimento_id')->dropDownList($lista_empreendimentos, [
                        'prompt' => 'Empreendimentos'
                ])->label(false) ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($searchModel, 'ordensdeservico_id')->dropDownList($lista_OS, [
                        'prompt' => 'Ordens de Serviço'
                ])->label(false) ?>
            </div>
            <div class="col-md-2 form-group">
                <img id="loading1-licenciamentos" src="<?=Yii::$app->homeUrl?>arquivos/loading_blue.gif" width="40" style="float:right;margin-left: 12px;margin-top: -3px;display:none">
                <?php             
                    echo Html::submitButton('Pesquisar', [
                        'class' => 'btn btn-primary',
                        'style'=>'float:right;margin:1%',
                        'id'=>'botao-envia-pesquisa-ajax-licenciamentos'
                        // 'onclick'=>'$(this).addClass("disabled");$("#loading1-licenciamentos").show();this.form.submit();this.disabled=true;',
                        // 'onmouseup'=>'$(this).addClass("disabled");$("#loading1-licenciamentos").show();this.disabled=true;',
                    ]);
                    $this->registerJs(<<<JS
                        $(document).on('pjax:send', function() {
                            $("#loading1-licenciamentos").show();
                            $("#botao-envia-pesquisa-ajax-licenciamentos").addClass("disabled");
                        });
                        $(document).on('pjax:complete', function() {
                            $('#loading1-licenciamentos').hide();
                            $("#botao-envia-pesquisa-ajax-licenciamentos").removeClass("disabled");
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
            'numero',
            [
                'attribute' => 'datacadastro',
                'value' => function($data) {
                    return date('d/m/Y', strtotime($data->datacadastro));
                }
            ],
            [
                'attribute' => 'data_validade',
                'value' => function($data) {
                    return date('d/m/Y', strtotime($data->data_validade));
                }
            ],
            [
                'attribute' => 'data_renovacao',
                'value' => function($data) {
                    return date('d/m/Y', strtotime($data->data_renovacao));
                }
            ],
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
            // ordensdeservico_id
            
            // empreendimento_id
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
                    "<a class='btn btn-primary' href='".Yii::$app->homeUrl."licenciamento/update?id=$data->id&abativa=arquivos' target=''>
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
                    return '<a href="'.Yii::$app->homeUrl.'licenciamento/update?id='.$data->id.'" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                },
                'visible' => in_array(Yii::$app->user->identity->nivel, ['administrador', 'gestor']) ? true : false
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
