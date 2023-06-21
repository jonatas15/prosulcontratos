<?php
use yii\bootstrap5\Modal;
Modal::begin([
    'title' => 'Lista de Documentos',
    'toggleButton' => [
        'label' => '<i class="bi bi-filetype-doc"></i>',
        'class' => 'btn btn-primary'
    ],
    'size' => 'modal-xl',
    'options' => [
        'tabindex' => "false"
    ]
]);

$searchModelArquivo = new \app\models\ArquivoSearch();
$dataProviderArquivo = $searchModelArquivo->search(['oficio_id'=>$oficio_id]);
$gestaoarquivos  = '<div class="row">';
$gestaoarquivos .= '<div class="col-md-12">';
$gestaoarquivos .= '<br>';
$gestaoarquivos .= $this->render('/arquivo/index', [
    'searchModel' => $searchModelArquivo,
    'dataProvider' => $dataProviderArquivo,
    'oficio_id' => $oficio_id,
    'funcionalidades' => false
]);
$gestaoarquivos .= '</div>';
$gestaoarquivos .= '</div>';

echo $gestaoarquivos;

Modal::end();