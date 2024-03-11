<?php
#########################################################################
##########  Fazer 5 gráficos PIZZA pra relação tipos - status ###########
#########################################################################

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Accordion;
use yii\bootstrap5\Modal;

use yii\bootstrap5\Tabs;
use app\models\Oficio;
use app\models\Ordensdeservico as Ordens;
use app\models\Produto;

/** @var yii\web\View $this */
/** @var app\models\Contrato $model */

$this->title = $model->titulo;
// $this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

function formatar_campo($campo, $valor) {
    $retorno = $valor;
    if($valor != "") {
        switch ($campo) {
            case 'datacadastro': $retorno = date('d/m/Y', strtotime($valor)); break;
            case 'dataupdate': $retorno = date('d/m/Y', strtotime($valor)); break;
            case 'data_assinatura': $retorno = date('d/m/Y', strtotime($valor)); break;
            case 'data_final': $retorno = date('d/m/Y', strtotime($valor)); break;
            case 'data_base': $retorno = date('d/m/Y', strtotime($valor)); break;
            case 'vigencia': $retorno = date('d/m/Y', strtotime($valor)); break;
            case 'saldo_prazo': $retorno = $valor.'%'; break;
            case 'saldo_contrato': $retorno = $valor.'%'; break;
            case 'valor_total': $retorno = 'R$ '.number_format($valor, 2, ',', '.'); break;
            case 'valor_faturado': $retorno = 'R$ '.number_format($valor, 2, ',', '.'); break;
            case 'valor_contrato': $retorno = 'R$ '.number_format($valor, 2, ',', '.'); break;
            case 'valor_empenhado': $retorno = 'R$ '.number_format($valor, 2, ',', '.'); break;
            case 'saldo_empenho': $retorno = 'R$ '.number_format($valor, 2, ',', '.'); break;
            default: $retorno = $valor; break;
        }
    }
    return $retorno;
}
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
            // 'id',
            // 'titulo',
            'objeto',
            'lote:ntext',
            'num_edital',
            'vigencia',
            'datacadastro',
            // [
            //     ''
            // ],
            // 'icone:ntext',
            // 'dataupdate',
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
            'obs:ntext',
        ],
    ]).'</div>';  
    // foreach ($model->attributes as $k => $row) {
    //     // print_r($k);
    //     // print_r($row);
    // }
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
    // MODAL API
    // Modal::begin([
    //     'title' => "⚙️ Dados no DNIT (API)",
    //     'toggleButton' => [
    //         'label' => "⚙️ Dados no DNIT (API)",
    //         'class' => 'btn btn-primary'
    //     ],
    //     'size' => 'modal-xl',
    //     'options' => [
    //         'id' => 'ver-os-detalhes-do-contrato-'.$model->id,
    //         'tabindex' => false,
    //     ],
    //     'bodyOptions' => [
    //         'class' => 'bg-white'
    //     ]
    // ]);
    $num_contrato = $this->context->numeros_limpos($model->titulo);
    // echo $num_contrato;
    // $json = file_get_contents('https://servicos.dnit.gov.br/DPP/api/contrato/dnit/0000'.$num_contrato);
    $json_B = '{
        "status": 200,
        "error": null,
        "data": [
            {
                "NU_CNPJ_CPF": "80996861000100",
                "SK_CONTRATO": 14041,
                "NU_CON_FORMATADO": "00 00095/2022",
                "SK_CONTRATO_SUPERVISOR": 1,
                "NU_CON_FORMATADO_SUPERVISOR": "-1",
                "DT_BASE": "2021-01-01 00:00:00.000",
                "DT_CORRENTE": "2024-01-11",
                "DT_TERMINO_VIGENCIA": "2027-05-24 00:00:00.000",
                "DT_APROVACAO": "2022-03-07 00:00:00.000",
                "DT_ASSINATURA": "2022-03-22 00:00:00.000",
                "DT_PROPOSTA": "2022-01-07 00:00:00.000",
                "DT_PUBLICACAO": "2022-04-04",
                "SK_DT_APROVACAO": 33685,
                "DT_DIA": "2022-03-22 00:00:00.000",
                "DT_INICIO": "2022-06-01 00:00:00.000",
                "DT_TER_ATZ": "2027-05-06 00:00:00.000",
                "DT_TER_PRV": "2027-05-06 00:00:00.000",
                "SK_EMPRESA": 200,
                "NO_EMPRESA": "PROSUL - PROJETOS SUPER. PLANEJ. LTDA",
                "SK_EMPRESA_SUPERVISOR": -3,
                "SG_EMPRESA_SUPERVISOR": "NA",
                "SK_FISCAL": 39,
                "NM_FISCAL": "MARTONCHELES BORGES DE SOUZA",
                "DS_GRUPO_INTERVENCAO": "ESTUDOS E PROJETOS",
                "SK_MODAL": 2,
                "DS_MODAL": "RODOVIARIO",
                "MODALIDADE_LICITACAO": "Regime Diferenciado de Contratação",
                "SK_MUNICIPIO": 810,
                "NO_MUNICIPIO": "BRASILIA",
                "CO_MUNICIPIO": "3846",
                "NO_MUNICIPIO0": "FLORIANÓPOLIS",
                "NU_EDITAL": "000257/2021-00",
                "NU_LOTE_LICITACAO": "3",
                "NU_PROCESSO": "50600.012334/2022-59",
                "DS_OBJETO": "Consultoria ambiental especializada na elaboração de estudos ambientais necessários para obtenção de licença prévia (LP) licença de instalação (LI) autorização de supressão de vegetação (ASV) de empreendimentos prioritários para o DNIT",
                "SK_PROGRAMA": 5,
                "NM_PROGRAMA": "CONSULTORIA",
                "NU_DIA_PARALISACAO": 0,
                "NU_DIA_PRORROGACAO": "0",
                "SK_SITUACAO_CONTRATO": 3,
                "DS_FAS_CONTRATO": "ATIVO",
                "CO_TIP_CONTRATO": "4",
                "DS_TIP_CONTRATO": "CONSULTORIA/SERVIÇOS",
                "SK_TIPO_INTERVENCAO": 12,
                "ds_tip_intervencao": "MEIO AMBIENTE",
                "TIPO_LICITACAO": "TÉCNICA E PREÇO",
                "DESCRICAO_BR": "BR-080 BR-153 BR-251 BR-259 BR-265 BR-285 BR-364 BR-365 BR-381 BR-461 BR-470 BR-476",
                "SK_UF_UNIDADE_LOCAL": 9,
                "SG_UF_UNIDADE_LOCAL": "DF",
                "CO_UF": "24",
                "SG_UF": "SC",
                "SK_UNIDADE_FISCAL": 7,
                "NM_UND_FISCAL": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_FISCAL": "CGMAB",
                "SK_UNIDADE_GESTORA": 6,
                "NM_UND_GESTORA": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_GESTORA": "CGMAB",
                "SK_UNIDADE_LOCAL": 5,
                "NM_UND_LOCAL": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_LOCAL": "CGMAB",
                "SK_UNIDADE_PAGAMENTO": 11,
                "NM_UND_PAGAMENTO": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_PAGAMENTO": "CGMAB",
                "Extensao_Total": "1359.17",
                "Valor_Inicial": "33776980.00",
                "Valor_Total_de_Aditivos": ".00",
                "Valor_Total_de_Reajuste": "4146633.49",
                "Valor_Inicial_Adit_Reajustes": "37923613.49",
                "Valor_Empenhado": 12157391,
                "Valor_Saldo": 35821358.85,
                "Valor_Medicao_PI_R": 2273431.42,
                "Valor_PI_Medicao": 2071686.69,
                "Valor_Reajuste_Medicao": 201744.73,
                "Valor_Oficio_Pagamento": 12236553.31,
                "Ajuste_Contratual_Acumulado": -23769.37,
                "Valor_Medicao_PI_R_Ajuste_Acumulado": 2297200.79
            }
        ]
    }';
    $json_A = '{
        "status": 200,
        "error": null,
        "data": [
            {
                "NU_CNPJ_CPF": "80996861000100",
                "SK_CONTRATO": 14053,
                "NU_CON_FORMATADO": "00 00093/2022",
                "SK_CONTRATO_SUPERVISOR": 1,
                "NU_CON_FORMATADO_SUPERVISOR": "-1",
                "DT_BASE": "2021-01-01 00:00:00.000",
                "DT_CORRENTE": "2024-01-11",
                "DT_TERMINO_VIGENCIA": "2027-05-25 00:00:00.000",
                "DT_APROVACAO": "2022-03-11 00:00:00.000",
                "DT_ASSINATURA": "2022-03-22 00:00:00.000",
                "DT_PROPOSTA": "2022-01-07 00:00:00.000",
                "DT_PUBLICACAO": "2022-03-29",
                "SK_DT_APROVACAO": 33685,
                "DT_DIA": "2022-03-22 00:00:00.000",
                "DT_INICIO": "2022-03-22 00:00:00.000",
                "DT_TER_ATZ": "2027-02-24 00:00:00.000",
                "DT_TER_PRV": "2027-02-24 00:00:00.000",
                "SK_EMPRESA": 200,
                "NO_EMPRESA": "PROSUL - PROJETOS SUPER. PLANEJ. LTDA",
                "SK_EMPRESA_SUPERVISOR": -3,
                "SG_EMPRESA_SUPERVISOR": "NA",
                "SK_FISCAL": 49,
                "NM_FISCAL": "LEANDRO LIMA DE SOUSA",
                "DS_GRUPO_INTERVENCAO": "ESTUDOS E PROJETOS",
                "SK_MODAL": 2,
                "DS_MODAL": "RODOVIARIO",
                "MODALIDADE_LICITACAO": "Regime Diferenciado de Contratação",
                "SK_MUNICIPIO": 810,
                "NO_MUNICIPIO": "BRASILIA",
                "CO_MUNICIPIO": "3846",
                "NO_MUNICIPIO0": "FLORIANÓPOLIS",
                "NU_EDITAL": "000257/2021-00",
                "NU_LOTE_LICITACAO": "1",
                "NU_PROCESSO": "50600.000865/2021-18",
                "DS_OBJETO": "Consultoria Ambiental Especializada na Elaboração de Estudos Ambientais necessários para a Obtenção de\r\nLicença Prévia (LP), Licença de Instalação (LI), Autorização de Supressão De Vegetação (ASV), de\r\nEmpreendimentos Prioritários para DNIT, Lote A.",
                "SK_PROGRAMA": 5,
                "NM_PROGRAMA": "CONSULTORIA",
                "NU_DIA_PARALISACAO": 0,
                "NU_DIA_PRORROGACAO": "0",
                "SK_SITUACAO_CONTRATO": 3,
                "DS_FAS_CONTRATO": "ATIVO",
                "CO_TIP_CONTRATO": "4",
                "DS_TIP_CONTRATO": "CONSULTORIA/SERVIÇOS",
                "SK_TIPO_INTERVENCAO": 12,
                "ds_tip_intervencao": "MEIO AMBIENTE",
                "TIPO_LICITACAO": "TÉCNICA E PREÇO",
                "DESCRICAO_BR": "BR-010 BR-070 BR-155 BR-156 BR-163 BR-174 BR-222 BR-226 BR-230 BR-242 BR-262 BR-267 BR-307 BR-317 BR-364 BR-401 BR-409",
                "SK_UF_UNIDADE_LOCAL": 9,
                "SG_UF_UNIDADE_LOCAL": "DF",
                "CO_UF": "24",
                "SG_UF": "SC",
                "SK_UNIDADE_FISCAL": 7,
                "NM_UND_FISCAL": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_FISCAL": "CGMAB",
                "SK_UNIDADE_GESTORA": 6,
                "NM_UND_GESTORA": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_GESTORA": "CGMAB",
                "SK_UNIDADE_LOCAL": 5,
                "NM_UND_LOCAL": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_LOCAL": "CGMAB",
                "SK_UNIDADE_PAGAMENTO": 11,
                "NM_UND_PAGAMENTO": "COORDENAÇÃO-GERAL DE MEIO AMBIENTE",
                "SG_UND_PAGAMENTO": "CGMAB",
                "Extensao_Total": "3664.68",
                "Valor_Inicial": "47493500.00",
                "Valor_Total_de_Aditivos": ".00",
                "Valor_Total_de_Reajuste": "5841035.67",
                "Valor_Inicial_Adit_Reajustes": "53334535.67",
                "Valor_Empenhado": 16023373.08,
                "Valor_Saldo": 51349393.1,
                "Valor_Medicao_PI_R": 1985142.57,
                "Valor_PI_Medicao": 1838271.2,
                "Valor_Reajuste_Medicao": 146871.37,
                "Valor_Oficio_Pagamento": 22413179.56,
                "Ajuste_Contratual_Acumulado": -35565.17,
                "Valor_Medicao_PI_R_Ajuste_Acumulado": 2020707.74
            }
        ]
    }';
    $_nao_relevantes = [
        'SK_CONTRATO_SUPERVISOR',
        'NU_CON_FORMATADO_SUPERVISOR',
        'SK_EMPRESA_SUPERVISOR',
        'SK_FISCAL',
        'SK_MODAL',
        'NU_LOTE_LICITACAO',
        'SK_PROGRAMA',
        'NU_DIA_PARALISACAO',
        'NU_DIA_PRORROGACAO',
        'SK_SITUACAO_CONTRATO',
        'CO_TIP_CONTRATO',
        'SK_TIPO_INTERVENCAO',
        'SK_UF_UNIDADE_LOCAL',
        'CO_UF',
        'SK_UNIDADE_FISCAL',
        'SK_UNIDADE_GESTORA',
        'SK_UNIDADE_LOCAL',
        'SK_UNIDADE_PAGAMENTO',
        'Valor_Total_de_Aditivos',
    ];
    if ($model->id == 1) {
        $obj = json_decode($json_B);
    } elseif ($model->id == 2) {
        $obj = json_decode($json_A);
    }
    // print_r($obj->data);
    // echo "<hr>";
    $dataex = $obj->data[0];
    $api_contrato_dnit .= '<div class="row">';
    $api_contrato_dnit .= '<div class="col-md-6">';
    $api_contrato_dnit .= '<table class="table table-striped table-bordered">';
    $i = 1;
    $dados_api = [];
    foreach($dataex as $k => $v) {
        if (!in_array($k, $_nao_relevantes)):
            $api_contrato_dnit .= '<tr>';
            $api_contrato_dnit .= "<td>".$this->context->formatatituloscampos($k)."</td><td><b>".$this->context->formatacampos($k, $v)."</b></td>";
            $api_contrato_dnit .= '</tr>';
            if ($i%15==0) {
                $api_contrato_dnit .= '</table>';
                $api_contrato_dnit .= '</div>';
                $api_contrato_dnit .= '<div class="col-md-6">';
                $api_contrato_dnit .= '<table class="table table-striped table-bordered">';
            }
            $i++;
            array_push($dados_api, [
                'campo' => $this->context->formatatituloscampos($k),
                'valor' => $this->context->formatacampos($k, $v),
            ]);
        endif;
    }
    $api_contrato_dnit .= '</table>';
    $api_contrato_dnit .= '</div>';
    $api_contrato_dnit .= '</div>';
    // echo $api_contrato_dnit;
    // Modal::end();
    #############################################################################
    ?>
    <br>
    <div class="row">
            <!-- <div class="card-header bg-default"> -->
                <!-- <a class="btn fw-bolder" data-bs-toggle="collapse" href="#resumo-do-contrato" role="button" aria-expanded="false" aria-controls="collapseExample"> -->
                    <!-- 📌 Resumo do Contrato -->
                <!-- </a> -->
            <!-- </div> -->
            <div id="resumo-do-contrato" class="col-12 my-2">
                <div class="col-md-12">
                    <?php if ($model->id == 1): ?>
                        <a href="https://www.google.com/url?q=https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo%3D351620%26infra_hash%3D304eff0e7d4cf4734089b207085993e1&source=gmail-html&ust=1710258210132000&usg=AOvVaw2TtU8hLLo1_pEOOw5bQwy3" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            <i class="fa fa-link"></i> Processo Administrativo: 50600.012334/2022-59
                        </a>
                    <?php else: ?>
                        <a href="https://www.google.com/url?q=https://sei.dnit.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo%3D351609%26infra_hash%3D5ea388ed228eb172de7cee57ba8e36ca&source=gmail-html&ust=1710258210132000&usg=AOvVaw0-O1U5qe3j1dhrZbPL9UVE" target="_blank" rel="noopener noreferrer" class="btn btn-success">
                            <i class="fa fa-link"></i> Processo Administrativo: 50600.000865/2021-18
                        </a>
                    <?php endif;?>
                </div>
                <div class="clearfix"><br></div>
                <?= $this->render('detalhamentocontrato', [
                    'model' => $model,
                    'dados' => $dados_api
                ]);
                ?>
                <div class="">
                    <a class="btn fw-bolder" data-bs-toggle="collapse" href="#edicoes-do-contrato" role="button" aria-expanded="false" aria-controls="collapseExample">
                        ✏️ Editar
                    </a>
                </div>
                <div id="edicoes-do-contrato" class="collapse col-12 my-2">
                    <?= '<div class="row">'.$this->render('update', [
                        'model' => $model
                    ]).'</div>'; ?>
                </div>
            </div>
            <div class="card-header bg-primary text-white">
                <a class="btn fw-bolder text-white fs-5" data-bs-toggle="collapse" href="#impactos-do-contrato" role="button" aria-expanded="false" aria-controls="collapseExample">
                📊 Impactos do Contrato <i class="fas fa-chevron-down"></i>
                </a>
            </div>
            <div id="impactos-do-contrato" class="collapse col-12 my-2">
                <?= $gestaoimpactos ?>
            </div>
    </div>
        
        <div class="clearfix"></div>
        <br>
    <div class="row">
        <?php 
        ?>
    </div>
        
</div>
<?php 
$this->registerJs(<<<JS
    $('#w1-collapse0').collapse("hide");
    $('.accordion').collapse("hide");
JS);
?>