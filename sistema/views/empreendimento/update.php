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
################################ GESTÃO DE FASES ##############################
$searchModelFase = new \app\models\FaseSearch();
$dataProviderFase = $searchModelFase->search(['empreendimento_id'=>$model->id]);
$gestaofase  = '<div class="row">';
$gestaofase .= '<div class="col-md-12">';
$gestaofase .= '<br>';
$gestaofase .= $this->render('/empreendimento/fases', [
    'searchModel' => $searchModelFase,
    'dataProvider' => $dataProviderFase,
    'id' => $model->id,
    'funcionalidades' => true
]);
$gestaofase .= '</div>';
$gestaofase .= '</div>';
############################### GESTÃO DE GUIAS ################################
$aba_dados = false;
$aba_arquivos = false;
$aba_fases = false;
$ativo = $_REQUEST['abativa'];
switch ($ativo) {
    case 'aba_dados':
        $aba_dados = true;
        $aba_arquivos = false;
        $aba_fases = false;
        break;
    case 'fases':
        $aba_dados = false;
        $aba_arquivos = false;
        $aba_fases = true;
        break;
    case 'arquivos':
        $aba_dados = false;
        $aba_arquivos = true;
        $aba_fases = false;
        break;
    default:
        $aba_dados = true;
        $aba_arquivos = false;
        $aba_fases = false;
        break;
}

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = 'Atualizar Empreendimento: ' .$model->id . ' - ' . $model->titulo;
# Breadcrumbs
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['/empreendimento']];
$this->params['breadcrumbs'][] = 'Atualizar '.$model->id . '- ' . $model->titulo;
?>
<div class="oficio-update">
    <h3><?= Html::encode($this->title) ?></h3>
    <?php 
    echo Tabs::widget([
        'items' => [
            [
                'label' => '📋 Editar Empreendimento',
                'content' => '<div class="row pt-3">'.$this->render('_form', [
                    'model' => $model,
                    'action' => 'empreendimento/update?id='.$model->id //A Yii->homeUrl fica na _form
                ]).'</div>',
                'options' => ['id' => 'aba_dados'],
                'active' => $aba_dados
            ],
            [
                'label' => '⌛ Fases',
                'content' => $gestaofase,
                'options' => ['id' => 'aba_fases'],
                'active' => $aba_fases
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
