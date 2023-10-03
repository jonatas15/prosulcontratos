<?php
    use yii\helpers\Html;
    use yii\bootstrap5\Modal;
?>
<?php
Modal::begin([
    'title' => "Novo Licenciamento",
    'options' => [
        'id' => 'cadastrar-novo-licenciamento',
        'tabindex' => false,
    ],
    'bodyOptions' => [
        'class' => 'bg-white',
    ],
    'size' => 'modal-xl',
    'toggleButton' => [
        'label' => '<i class="bi bi-card-list"></i> Novo Licenciamento',
        'class' => 'btn btn-primary text-white  float-right'
    ],
]);
?>
<div class="oficio-create">
    <?= $this->render('_form', [
        'model' => $model,
        'action' => 'licenciamento/create',
        'contrato_id' => $contrato_id,
        'empreendimento_id' => $empreendimento_id
    ]) ?>
</div>
<?php Modal::end(); ?>