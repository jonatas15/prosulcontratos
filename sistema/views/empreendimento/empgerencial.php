<?php

use yii\helpers\Html;
// use yii\bootstrap5\Tabs;
use kartik\tabs\TabsX as Tabs;

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
// $searchModelArquivo = new \app\models\ArquivoSearch();
// $dataProviderArquivo = $searchModelArquivo->search(['empreendimento_id'=>$model->id]);
// $gestaoarquivos  = '<div class="row">';
// $gestaoarquivos .= '<div class="col-md-12">';
// $gestaoarquivos .= '<br>';
// $gestaoarquivos .= $this->render('/arquivo/index', [
//     'searchModel' => $searchModelArquivo,
//     'dataProvider' => $dataProviderArquivo,
//     'funcionalidades' => true,
//     'id_tabela_referencia' => 'empreendimento_id',
//     'id_valor_referencia' => $model->id,
// ]);
// $gestaoarquivos .= '</div>';
// $gestaoarquivos .= '</div>';

/** @var yii\web\View $this */
/** @var app\models\Oficio $model */

$this->title = 'Empreendimento ' .$model->id . ' - ' . $model->titulo;
# Breadcrumbs
$this->params['breadcrumbs'][] = ['label' => 'Empreendimentos', 'url' => ['/empreendimento']];
$this->params['breadcrumbs'][] = 'Atualizar '.$model->id . '- ' . $model->titulo;
?>
<div class="empreendimento-update">
    <h3 class="my-4 text-left text-uppercase"><?= Html::encode($this->title) ?></h3>
    <?php if (count($model->licenciamentos) > 0): ?>
    <div class="row align-center pb-5">
        <?= $this->render('instancias', [
            'id' => $model->id,
            'model' => $model
        ]); ?>
    </div>
    <?php endif; ?>
    <?php 
    $items = [];
    foreach ($model->licenciamentos as $item) {
        $searchModelFases = new \app\models\FaseSearch();
        $dataProviderFases = $searchModelFases->search(['licenciamento_id' => $item->id]);
        
        $gestaofase = $this->render('/empreendimento/timeline', [
            'licenciamento_id' => $item->id,
            'model' => $item,
            'empreendimento_id' => $model->id,
            'funcionalidades' => true,
            'searchModelFases' => $searchModelFases,
            'dataProviderFases' => $dataProviderFases,
        ]);
        
        array_push($items, [
            'label' => '⌛ '.$item->numero,
            'content' => $gestaofase,
            'options' => ['id' => 'aba_fases_'.$item->id],
            'active' => $item->numero == 'IPHAN' ? true : false,
        ]);
    }
    echo Tabs::widget([
        'items' => $items,
        'position'=>Tabs::POS_ABOVE,
        'align'=>Tabs::ALIGN_CENTER,
        'bordered'=>true,
        'encodeLabels'=>false
    ]);
    ?>
</div>
