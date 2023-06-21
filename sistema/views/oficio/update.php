<?php

use yii\helpers\Html;
use yii\bootstrap5\Tabs;
?>
<style>
    .nav-link.active {
        background-color: gray !important;
        color: white !important;
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
$dataProviderArquivo = $searchModelArquivo->search(['oficio_id'=>$model->id]);
$gestaoarquivos  = '<div class="row">';
$gestaoarquivos .= '<div class="col-md-12">';
$gestaoarquivos .= '<br>';
$gestaoarquivos .= $this->render('/arquivo/index', [
    'searchModel' => $searchModelArquivo,
    'dataProvider' => $dataProviderArquivo,
    'oficio_id' => $model->id,
    'funcionalidades' => true
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
        break;
    case 'arquivos':
        $aba_dados = false;
        $aba_arquivos = true;
        break;
    default:
        $aba_dados = true;
        $aba_arquivos = false;
        break;
}

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = 'Atualizar Ofício: ' .$model->tipo . '- ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contrato: '.$model->contrato->id, 'url' => ['/contrato/view?id='.$model->contrato->id]];
$this->params['breadcrumbs'][] = ['label' => 'Oficios', 'url' => ['/contrato/view?id='.$model->contrato->id.'&abativa=aba_oficios']];
$this->params['breadcrumbs'][] = 'Atualizar '.$model->tipo . '- ' . $model->id;
?>
<div class="oficio-update">
    <h3><?= Html::encode($this->title) ?></h3>
    <?php 
    echo Tabs::widget([
        'items' => [
            [
                'label' => '📋 Ofício',
                'content' => '<div class="row">'.$this->render('_form', [
                    'model' => $model,
                    'action' => 'oficio/update?id='.$model->id //A Yii->homeUrl fica na _form
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
