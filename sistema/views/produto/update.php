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
$dataProviderArquivo = $searchModelArquivo->search(['produto_id'=>$model->id]);
$gestaoarquivos  = '<div class="row">';
$gestaoarquivos .= '<div class="col-md-12">';
$gestaoarquivos .= '<br>';
$gestaoarquivos .= $this->render('/arquivo/index', [
    'searchModel' => $searchModelArquivo,
    'dataProvider' => $dataProviderArquivo,
    'funcionalidades' => true,
    'id_tabela_referencia' => 'produto_id',
    'id_valor_referencia' => $model->id,
]);
$gestaoarquivos .= '</div>';
$gestaoarquivos .= '</div>';
############################### GESTÃO DE REVISÕES #############################
$searchModelRevisao = new \app\models\RevisaoSearch();
$dataProviderRevisao = $searchModelRevisao->search(['produto_id'=>$model->id]);
$gestarevisao  = '<div class="row">';
$gestarevisao .= '<div class="col-md-12">';
$gestarevisao .= '<br>';
$gestarevisao .= $this->render('/produto/revisoes', [
    'searchModel' => $searchModelRevisao,
    'dataProvider' => $dataProviderRevisao,
    'id' => $model->id,
    'funcionalidades' => true
]);
$gestarevisao .= '</div>';
$gestarevisao .= '</div>';
############################### GESTÃO DE GUIAS ################################
$aba_dados = false;
$aba_arquivos = false;
$aba_reviews = false;
$ativo = $_REQUEST['abativa'];
switch ($ativo) {
    case 'aba_dados':
        $aba_dados = true;
        $aba_arquivos = false;
        $aba_reviews = false;
        break;
    case 'reviews':
        $aba_dados = false;
        $aba_arquivos = false;
        $aba_reviews = true;
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

$this->title = 'Atualizar Produto: ' .$model->id . ' - ' . $model->subproduto;
$this->params['breadcrumbs'][] = ['label' => 'Contrato: '.$model->contrato->id, 'url' => ['/contrato/view?id='.$model->contrato->id]];
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['/contrato/view?id='.$model->contrato->id.'&abativa=aba_produtos']];
$this->params['breadcrumbs'][] = 'Atualizar '.$model->id . '- ' . $model->subproduto;
?>
<div class="oficio-update">
    <div class="align-center my-4">
        <?= Html::a('<i class="fa fa-arrow-left"></i> Voltar aos Produtos', ['/contrato/pr?id='.$model->contrato->id.'&abativa=aba_produtos&empreendimento='.$model->empreendimento_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="bi bi-trash"></i> Excluir Produto', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger float-right',
            'data' => [
                'confirm' => 'Tens certeza que quer excluir esse registro?',
                'method' => 'post',
            ],
        ]);?>
    </div>
    <h3><?= Html::encode($this->title) ?></h3>
    <?php 
    echo Tabs::widget([
        'items' => [
            [
                'label' => '📋 Editar Produto',
                'content' => '<div class="row">'.$this->render('_form', [
                    'model' => $model,
                    'action' => 'produto/update?id='.$model->id, //A Yii->homeUrl fica na _form
                    'contrato_id' => $model->contrato->id
                ]).'</div>',
                'options' => ['id' => 'aba_dados'],
                'active' => $aba_dados
            ],
            [
                'label' => '📋 Revisões',
                'content' => $gestarevisao,
                'options' => ['id' => 'aba_reviews'],
                'active' => $aba_reviews
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
