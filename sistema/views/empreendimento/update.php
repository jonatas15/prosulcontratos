<?php

use yii\helpers\Html;
use yii\bootstrap5\Tabs;
?>
<style>
    .nav-link.active {
        background-color: gray !important;
        color: white !important;
    }
    .bg-gray {
        background-color: lightgray;
        border-color: gray;
        padding: 0 50px !important;
    }
</style>
<?php
############################### GESTÃO DE ARQUIVOS #############################
/**
    Nota: temos que criar uma modal pro upload de multiplos arquivos
    que cria multiplos registros
*/
############################### GESTÃO DE ARQUIVOS #############################
$searchModelArquivo = new \app\models\ArquivoSearch();
$dataProviderArquivo = $searchModelArquivo->search(['empreendimento_id'=>$model->id]);
$gestaoarquivos  = '<div class="row">';
$gestaoarquivos .= '<div class="col-md-12">';
$gestaoarquivos .= '<br>';
$gestaoarquivos .= $this->render('/arquivo/index', [
    'searchModel' => $searchModelArquivo,
    'dataProvider' => $dataProviderArquivo,
    'funcionalidades' => true,
    'id_tabela_referencia' => 'empreendimento_id',
    'id_valor_referencia' => $model->id,
]);
$gestaoarquivos .= '</div>';
$gestaoarquivos .= '</div>';

$ativo = $_REQUEST['abativa'];
switch ($ativo) {
    case 'aba_dados':
        $aba_view = true;
        $aba_update = false;
        $aba_arquivos = false;
    break;
    case 'aba_update':
        $aba_view = false;
        $aba_update = true;
        $aba_arquivos = false;
    break;
    case 'aba_arquivos':
        $aba_view = false;
        $aba_update = false;
        $aba_arquivos = true;
    break;
    
    default:
        
        break;
}


/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = $model->titulo;
# Breadcrumbs
$this->params['breadcrumbs'][] = ['label' => $model->contrato->titulo, 'url' => ['/contrato/view?id='.$model->contrato->id]];
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['/empreendimento']];
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['/empreendimento/preview?id='.$model->id]];
$this->params['breadcrumbs'][] = 'Detalhes do Empreendimento';
?>
<div class="empreendimento-update">
    <h3 class="my-4 text-left text-uppercase"><span style='color: gray'><?=$model->contrato->titulo?></span>: <?= Html::encode($this->title) ?></h3>
    <?php 
    echo Tabs::widget([
        'items' => [
            [
                'label' => '📋 Empreendimento',
                'content' => '<div class="row pt-3">'.$this->render('view', [
                    'model' => $model,
                ]).'</div>',
                'options' => ['id' => 'aba_view'],
                'active' => $aba_view
            ],
            [
                'label' => '📋 Editar Empreendimento',
                'content' => '<div class="row pt-3">'.$this->render('_form', [
                    'model' => $model,
                    'action' => 'empreendimento/update?id='.$model->id //A Yii->homeUrl fica na _form
                ]).'</div>',
                'options' => ['id' => 'aba_update'],
                'active' => $aba_dados
            ],
            [
                'label' => '🗄️ Arquivos',
                'content' => $gestaoarquivos,
                'options' => ['id' => 'aba_arquivos'],
                'active' => $aba_arquivos
            ],
        ],
    ]);
    ?>
</div>
