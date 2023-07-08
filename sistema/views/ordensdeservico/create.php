<?php
    use yii\helpers\Html;
    use yii\bootstrap5\Modal;
?>
<?php
Modal::begin([
    'title' => "Nova Ordem de serviço",
    'options' => [
        'id' => 'cadastrar-novo-os',
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'class' => 'bg-white',
    ],
    'size' => 'modal-xl',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i> Nova Ordem de Serviço',
        'class' => 'btn btn-primary text-white  float-right'
    ],
]);
?>
<div class="ordensdeservico-create">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => 'ordensdeservico/create',
        'contrato_id' => $contrato_id
    ]) ?>
</div>
<?php Modal::end(); ?>