<?php
    use yii\helpers\Html;
    use yii\bootstrap5\Modal;
?>
<?php
Modal::begin([
    'title' => "Novo Empreendimento",
    'options' => [
        'id' => 'cadastrar-novo-empreendimento',
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'class' => 'bg-white',
    ],
    'size' => 'modal-xl',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i> Novo Empreendimento',
        'class' => 'btn btn-success text-white  float-right'
    ],
]);
?>
<div class="oficio-create">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => 'empreendimento/create',
        'contrato_id' => $contrato_id
    ]) ?>
</div>
<?php Modal::end(); ?>