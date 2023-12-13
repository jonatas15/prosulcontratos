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
$dataProviderArquivo = $searchModelArquivo->search(['ordensdeservico_id'=>$model->id]);
$gestaoarquivos  = '<div class="row">';
$gestaoarquivos .= '<div class="col-md-12">';
$gestaoarquivos .= '<br>';
$gestaoarquivos .= $this->render('/arquivo/index', [
    'searchModel' => $searchModelArquivo,
    'dataProvider' => $dataProviderArquivo,
    'funcionalidades' => true,
    'id_tabela_referencia' => 'ordensdeservico_id',
    'id_valor_referencia' => $model->id,
]);
$gestaoarquivos .= '</div>';
$gestaoarquivos .= '</div>';

############################### GESTÃO DE GUIAS ################################
$aba_dados = false;
$aba_arquivos = false;
$ativo = $_REQUEST['abativa'];
switch ($ativo) {
    case 'aba_dados':
        $aba_dados = true;
        $aba_arquivos = false;
        $aba_reviews = false;
        break;
    case 'arquivos':
        $aba_dados = false;
        $aba_arquivos = true;
        $aba_reviews = false;
        break;
    default:
        $aba_dados = true;
        $aba_arquivos = false;
        $aba_reviews = false;
        break;
}

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = 'Atualizar OS: ' .$model->id . ' - ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Contrato: '.$model->contrato->id, 'url' => ['/contrato/view?id='.$model->contrato->id]];
$this->params['breadcrumbs'][] = ['label' => 'Ordens de Serviço', 'url' => ['/contrato/os?id='.$model->contrato->id.'&abativa=aba_ordens']];
$this->params['breadcrumbs'][] = 'Atualizar '.$model->id . '- ' . $model->titulo;
?>
<div class="align-center my-4">
    <?= Html::a('<i class="fa fa-arrow-left"></i> Voltar às Ordens de Serviço', ['/contrato/os?id='.$model->contrato->id.'&abativa=aba_ordens'], ['class' => 'btn btn-primary']) ?>
</div>
<div class="oficio-update">
    <h3><?= Html::encode($this->title) ?></h3>
    <?php 
    echo Tabs::widget([
        'items' => [
            [
                'label' => '📋 Editar OS',
                'content' => '<div class="row mt-3">'.$this->render('_form', [
                    'model' => $model,
                    'action' => 'ordensdeservico/update?id='.$model->id //A Yii->homeUrl fica na _form
                ]).'</div>',
                'options' => ['id' => 'aba_dados'],
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
