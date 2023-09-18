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


/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = 'Empreendimento ' .$model->id . ' - ' . $model->titulo;
# Breadcrumbs
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['/empreendimento']];
$this->params['breadcrumbs'][] = 'Atualizar '.$model->id . '- ' . $model->titulo;
?>
<div class="empreendimento-update">
    <h3 class="my-4 text-left text-uppercase"><?= Html::encode($this->title) ?></h3>
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
