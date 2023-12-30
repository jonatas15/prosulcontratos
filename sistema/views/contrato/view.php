<?php
#########################################################################
##########  Fazer 5 gráficos PIZZA pra relação tipos - status ###########
#########################################################################

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Accordion;

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
    ?>
    <br>
    <div class="row">
            <!-- <div class="card-header bg-default"> -->
                <!-- <a class="btn fw-bolder" data-bs-toggle="collapse" href="#resumo-do-contrato" role="button" aria-expanded="false" aria-controls="collapseExample"> -->
                    <!-- 📌 Resumo do Contrato -->
                <!-- </a> -->
            <!-- </div> -->
            <div id="resumo-do-contrato" class="col-12 my-2">
                <?= $this->render('detalhamentocontrato', [
                    'model' => $model
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