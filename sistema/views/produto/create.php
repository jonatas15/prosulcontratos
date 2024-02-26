<?php
    use yii\helpers\Html;
    use yii\bootstrap5\Modal;
?>
<?php
Modal::begin([
    'title' => "Novo Produto",
    'options' => [
        'id' => 'cadastrar-novo-produto',
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'class' => 'bg-white',
    ],
    'size' => 'modal-xl',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i> Novo Produto',
        'class' => 'btn btn-primary text-white float-right pl-0'
    ],
]);
?>
<div class="oficio-create">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => 'produto/create',
        'contrato_id' => $contrato_id
    ]) ?>
</div>
<?php Modal::end(); ?>